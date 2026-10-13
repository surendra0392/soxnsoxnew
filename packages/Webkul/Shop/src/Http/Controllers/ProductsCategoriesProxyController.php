<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Marketing\Repositories\URLRewriteRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;

class ProductsCategoriesProxyController extends Controller
{
    /**
     * Using const variable for status
     *
     * @var int Status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ProductRepository $productRepository,
        protected ThemeCustomizationRepository $themeCustomizationRepository,
        protected URLRewriteRepository $urlRewriteRepository
    ) {}

    /**
     * Show product or category view. If neither category nor product matches, abort with code 404.
     *
     * @return View|RedirectResponse|\Exception
     */
    public function index(Request $request)
    {
        $slugOrURLKey = urldecode(trim($request->getPathInfo(), '/'));

        /**
         * Support url for chinese, japanese, arabic and english with numbers.
         */
        if (! preg_match('/^([\p{L}\p{N}\p{M}\x{0900}-\x{097F}\x{0590}-\x{05FF}\x{0600}-\x{06FF}\x{0400}-\x{04FF}_-]+\/?)+$/u', $slugOrURLKey)) {
            $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
                'status' => self::STATUS,
                'channel_id' => core()->getCurrentChannel()->id,
            ]);

            return view('shop::home.index', compact('customizations'));
        }

        $category = $this->categoryRepository->findBySlug($slugOrURLKey);

        if ($category) {
            return redirect()->route('shop.category.view', $category->slug, 301);
        }

        if (core()->getConfigData('catalog.products.search.engine') == 'elastic') {
            $searchEngine = core()->getConfigData('catalog.products.search.storefront_mode');
        }

        $product = $this->productRepository
            ->setSearchEngine($searchEngine ?? 'database')
            ->findBySlug($slugOrURLKey);

        if ($product) {
            if (
                ! $product->url_key
                || ! $product->visible_individually
                || ! $product->status
            ) {
                abort(404);
            }

            $catSlug = $this->getProductPrimaryCategorySlug($product);

            return redirect()->route('shop.products.view', [
                'category' => $catSlug,
                'slug' => $product->url_key,
            ], 301);
        }

        /**
         * If category or product is not found directly, try to find it by trimmed slug.
         */
        if (str_contains($slugOrURLKey, '/')) {
            $trimmedSlug = last(explode('/', $slugOrURLKey));

            $category = $this->categoryRepository->findBySlug($trimmedSlug);

            if ($category) {
                return redirect()->route('shop.category.view', $category->slug, 301);
            }

            $product = $this->productRepository
                ->setSearchEngine($searchEngine ?? 'database')
                ->findBySlug($trimmedSlug);

            if ($product) {
                $catSlug = $this->getProductPrimaryCategorySlug($product);

                return redirect()->route('shop.products.view', [
                    'category' => $catSlug,
                    'slug' => $product->url_key,
                ], 301);
            }
        }

        /**
         * If neither category nor product matches,
         * try to find it by url rewrite.
         */
        $urlRewrite = $this->urlRewriteRepository->findOneWhere([
            'request_path' => $slugOrURLKey,
            'locale' => app()->getLocale(),
        ]);

        if ($urlRewrite) {
            return redirect()->to($urlRewrite->target_path, $urlRewrite->redirect_type);
        }

        abort(404);
    }

    /**
     * Show dedicated category view under canonical /shop/category/{slug} route.
     */
    public function categoryView(string $slug, Request $request): View|RedirectResponse
    {
        $rawPath = urldecode(trim($slug, '/'));
        $targetSlug = str_contains($rawPath, '/') ? last(explode('/', $rawPath)) : $rawPath;

        $category = $this->categoryRepository->findBySlug($targetSlug)
            ?: $this->categoryRepository->findBySlug($rawPath);

        if ($category) {
            if ($rawPath !== $category->slug) {
                return redirect()->route('shop.category.view', $category->slug, 301);
            }

            return view('shop::categories.view', [
                'category' => $category,
                'params' => [
                    'sort' => request()->query('sort'),
                    'limit' => request()->query('limit'),
                    'mode' => request()->query('mode'),
                ],
            ]);
        }

        abort(404);
    }

    /**
     * Show dedicated product view under canonical /shop/{category}/{slug} route.
     */
    public function productView(string $category, string $slug, Request $request): View|RedirectResponse
    {
        $categorySlug = urldecode(trim($category, '/'));
        $rawProductSlug = urldecode(trim($slug, '/'));
        $targetProductSlug = str_contains($rawProductSlug, '/') ? last(explode('/', $rawProductSlug)) : $rawProductSlug;

        if (core()->getConfigData('catalog.products.search.engine') == 'elastic') {
            $searchEngine = core()->getConfigData('catalog.products.search.storefront_mode');
        }

        $product = $this->productRepository
            ->setSearchEngine($searchEngine ?? 'database')
            ->findBySlug($targetProductSlug);

        if ($product) {
            if (
                ! $product->url_key
                || ! $product->visible_individually
                || ! $product->status
            ) {
                abort(404);
            }

            $validCategories = $product->categories->filter(fn ($c) => $c->id != 1);
            $canonicalCategory = $validCategories->last() ?? $validCategories->first();
            $canonicalCatSlug = $canonicalCategory?->slug ?? 'socks';

            $isMatchingCategory = $validCategories->contains(fn ($c) => $c->slug === $categorySlug);

            // Redirect if category in URL doesn't belong to this product or is the placeholder 'socks'
            if (! $isMatchingCategory || $categorySlug === 'socks') {
                return redirect()->route('shop.products.view', [
                    'category' => $canonicalCatSlug,
                    'slug' => $product->url_key,
                ], 301);
            }

            // Redirect if raw product slug had trailing slashes or subpaths
            if ($rawProductSlug !== $product->url_key) {
                return redirect()->route('shop.products.view', [
                    'category' => $categorySlug,
                    'slug' => $product->url_key,
                ], 301);
            }

            $productURLRewrite = $this->urlRewriteRepository->findOneWhere([
                'entity_type' => 'product',
                'request_path' => 'shop/'.$categorySlug.'/'.$product->url_key,
                'locale' => app()->getLocale(),
            ]);

            if ($productURLRewrite) {
                return redirect()->to($productURLRewrite->target_path, $productURLRewrite->redirect_type);
            }

            return view('shop::products.view', compact('product'));
        }

        abort(404);
    }

    /**
     * Handle single-segment /shop/{slug} URLs and redirect to canonical category or product.
     */
    public function shopSingleSegment(string $slug, Request $request): View|RedirectResponse
    {
        $rawPath = urldecode(trim($slug, '/'));
        $targetSlug = str_contains($rawPath, '/') ? last(explode('/', $rawPath)) : $rawPath;

        // 1. If it matches a category, 301 redirect to /shop/category/{slug}
        $category = $this->categoryRepository->findBySlug($targetSlug);
        if ($category) {
            return redirect()->route('shop.category.view', $category->slug, 301);
        }

        // 2. If it matches a product, 301 redirect to /shop/{category}/{product}
        if (core()->getConfigData('catalog.products.search.engine') == 'elastic') {
            $searchEngine = core()->getConfigData('catalog.products.search.storefront_mode');
        }

        $product = $this->productRepository
            ->setSearchEngine($searchEngine ?? 'database')
            ->findBySlug($targetSlug);

        if ($product) {
            $catSlug = $this->getProductPrimaryCategorySlug($product);

            return redirect()->route('shop.products.view', [
                'category' => $catSlug,
                'slug' => $product->url_key,
            ], 301);
        }

        abort(404);
    }

    /**
     * Get the primary non-root category slug for a product.
     */
    protected function getProductPrimaryCategorySlug($product): string
    {
        $nonRootCategories = $product->categories->filter(fn ($c) => $c->id != 1);
        $primary = $nonRootCategories->last() ?? $nonRootCategories->first();

        return $primary?->slug ?? 'socks';
    }
}
