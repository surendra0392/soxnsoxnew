<?php

namespace Webkul\Shop\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Marketing\Jobs\UpdateCreateSearchTerm as UpdateCreateSearchTermJob;
use Webkul\Product\Helpers\ConfigurableOption;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Shop\Helpers\CatalogApiCache;
use Webkul\Shop\Http\Resources\ProductCardResource;

class ProductController extends APIController
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ProductRepository $productRepository,
        protected CatalogApiCache $catalogApiCache
    ) {}

    /**
     * Product listings.
     */
    public function index(): JsonResource|JsonResponse
    {
        $searchEngine = 'database';

        if (core()->getConfigData('catalog.products.search.engine') == 'elastic') {
            $searchEngine = core()->getConfigData('catalog.products.search.storefront_mode');
        }

        $searchData = $this->resolveSearchQueryData($searchEngine);

        $query = $searchData['effective_query'] ?? $searchData['original_query'];

        /**
         * Search results are never cached: the search-term space is unbounded
         * and the search-term job must run on every request.
         */
        if (! empty($query)) {
            $products = $this->getProducts($searchEngine, $query);

            /**
             * Update or create search term only if
             * there is only one filter that is query param
             */
            if (count(request()->except(['mode', 'sort', 'limit'])) == 1) {
                UpdateCreateSearchTermJob::dispatch([
                    'term' => $query,
                    'results' => $products->total(),
                    'channel_id' => core()->getCurrentChannel()->id,
                    'locale' => app()->getLocale(),
                ]);
            }

            return ProductCardResource::collection($products);
        }

        /**
         * Listing/carousel responses (no search term) are cached per catalog
         * version, so repeated homepage visits skip the database entirely.
         */
        $data = $this->catalogApiCache->remember('products', request()->query(), function () use ($searchEngine) {
            return ProductCardResource::collection($this->getProducts($searchEngine, ''))
                ->response()
                ->getData(true);
        });

        return response()->json($data)->withHeaders($this->catalogCacheHeaders());
    }

    /**
     * Fetch the storefront product listing for the given search engine and query.
     */
    protected function getProducts(string $searchEngine, string $query)
    {
        $params = array_merge(request()->query(), [
            'query' => $query,
            'channel_id' => core()->getCurrentChannel()->id,
            'status' => 1,
            'visible_individually' => 1,
        ]);

        if (! empty($params['category_id'])) {
            $rootCategoryId = core()->getCurrentChannel()->root_category_id;

            if ($params['category_id'] == $rootCategoryId) {
                unset($params['category_id']);
            } elseif ($category = $this->categoryRepository->find($params['category_id'])) {
                $categoryIds = $category->descendantsAndSelf($params['category_id'])->pluck('id')->toArray();

                if (! empty($categoryIds)) {
                    $params['category_id'] = implode(',', $categoryIds);
                }
            }
        }

        return $this->productRepository
            ->setSearchEngine($searchEngine)
            ->getAll($params);
    }

    /**
     * Resolve search query data.
     */
    protected function resolveSearchQueryData($searchEngine): array
    {
        if (request()->query('suggest', '') === '0') {
            return [
                'original_query' => request()->query('query', ''),
                'effective_query' => null,
            ];
        }

        $originalQuery = request()->query('query', '');

        return [
            'original_query' => $originalQuery,
            'effective_query' => $this->getEffectiveQuery($originalQuery, $searchEngine),
        ];
    }

    /**
     * It will return the effective query based on the search engine.
     */
    protected function getEffectiveQuery(string $originalQuery, string $searchEngine): ?string
    {
        $effectiveQuery = $this->productRepository->setSearchEngine($searchEngine)->getSuggestions($originalQuery);

        return $effectiveQuery;
    }

    /**
     * Related product listings.
     *
     * @param  int  $id
     */
    public function relatedProducts($id): JsonResource
    {
        $product = $this->productRepository->findOrFail($id);

        $limit = core()->getConfigData('catalog.products.product_view_page.no_of_related_products') ?: 4;
        $channelCode = core()->getCurrentChannel()->code;

        $relatedProducts = $product->related_products()
            ->whereNull('products.parent_id')
            ->whereHas('product_flats', function ($q) use ($channelCode) {
                $q->where('status', 1)->where('channel', $channelCode);
            })
            ->take($limit)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $categoryIds = $product->categories->pluck('id')->toArray();

            $fallbackQuery = $this->productRepository
                ->where('products.id', '!=', $product->id)
                ->whereNull('products.parent_id')
                ->whereHas('product_flats', function ($q) use ($channelCode) {
                    $q->where('status', 1)->where('channel', $channelCode);
                });

            if (! empty($categoryIds)) {
                $fallbackQuery->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            }

            $relatedProducts = $fallbackQuery->take($limit)->get();

            if ($relatedProducts->isEmpty()) {
                $relatedProducts = $this->productRepository
                    ->where('products.id', '!=', $product->id)
                    ->whereNull('products.parent_id')
                    ->whereHas('product_flats', function ($q) use ($channelCode) {
                        $q->where('status', 1)->where('channel', $channelCode);
                    })
                    ->take($limit)
                    ->get();
            }
        }

        return ProductCardResource::collection($relatedProducts);
    }

    /**
     * Up-sell product listings.
     *
     * @param  int  $id
     */
    public function upSellProducts($id): JsonResource
    {
        $product = $this->productRepository->findOrFail($id);

        $limit = core()->getConfigData('catalog.products.product_view_page.no_of_up_sells_products') ?: 4;
        $channelCode = core()->getCurrentChannel()->code;

        $upSellProducts = $product->up_sells()
            ->whereNull('products.parent_id')
            ->whereHas('product_flats', function ($q) use ($channelCode) {
                $q->where('status', 1)->where('channel', $channelCode);
            })
            ->take($limit)
            ->get();

        return ProductCardResource::collection($upSellProducts);
    }

    /**
     * Get configurable options configuration for a product.
     */
    public function configurableConfig(int $id): JsonResponse
    {
        $product = $this->productRepository->findOrFail($id);

        if ($product->type !== 'configurable') {
            return response()->json([
                'data' => null,
            ]);
        }

        $config = app(ConfigurableOption::class)->getConfigurationConfig($product);

        return response()->json([
            'data' => $config,
        ]);
    }
}
