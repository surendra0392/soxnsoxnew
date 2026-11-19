<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Webkul\MagicAI\Facades\MagicAI;
use Webkul\Marketing\Repositories\SearchTermRepository;
use Webkul\Product\Repositories\SearchRepository;

class SearchController extends Controller
{
    /**
     * Whitelist of allowable sort parameters.
     */
    const ALLOWED_SORTS = [
        'name-asc',
        'name-desc',
        'created_at-desc',
        'created_at-asc',
        'price-asc',
        'price-desc',
    ];

    /**
     * Whitelist of allowable limits.
     */
    const ALLOWED_LIMITS = [10, 12, 20, 24, 30, 40, 50];

    /**
     * Whitelist of allowable view modes.
     */
    const ALLOWED_MODES = ['grid', 'list'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected SearchTermRepository $searchTermRepository,
        protected SearchRepository $searchRepository
    ) {}

    /**
     * Index to handle the view loaded with the search results
     *
     * @return View
     */
    public function index()
    {
        // 1. Strict Input Validation & SQL Injection Prevention
        $this->validate(request(), [
            'query' => ['sometimes', 'nullable', 'string', 'max:100', 'regex:/^[^<>\/\\\]+$/u'],
            'category_id' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'price' => ['sometimes', 'nullable', 'string', 'max:50', 'regex:/^(\d+(\.\d+)?)(,(\d+(\.\d+)?))?$/'],
            'sort' => ['sometimes', 'nullable', 'string', 'in:'.implode(',', self::ALLOWED_SORTS)],
            'limit' => ['sometimes', 'nullable', 'integer', 'in:'.implode(',', self::ALLOWED_LIMITS)],
            'mode' => ['sometimes', 'nullable', 'string', 'in:'.implode(',', self::ALLOWED_MODES)],
        ]);

        $rawQuery = request()->query('query');
        $query = $rawQuery ? strip_tags(trim($rawQuery)) : null;

        if ($query) {
            $searchTerm = $this->searchTermRepository->findOneWhere([
                'term' => $query,
                'channel_id' => core()->getCurrentChannel()->id,
                'locale' => app()->getLocale(),
            ]);

            if ($searchTerm?->redirect_url) {
                return redirect()->to($searchTerm->redirect_url);
            }
        }

        $suggestion = null;

        if (
            $query
            && (! request()->has('suggest') || request()->query('suggest') !== '0')
        ) {
            $searchEngine = core()->getConfigData('catalog.products.search.engine') === 'elastic'
                ? core()->getConfigData('catalog.products.search.storefront_mode')
                : 'database';

            $suggestion = $this->searchRepository
                ->setSearchEngine($searchEngine)
                ->getSuggestions($query);
        }

        $sort = in_array(request()->query('sort'), self::ALLOWED_SORTS) ? request()->query('sort') : 'created_at-desc';
        $limit = in_array((int) request()->query('limit'), self::ALLOWED_LIMITS) ? (int) request()->query('limit') : 12;
        $mode = in_array(request()->query('mode'), self::ALLOWED_MODES) ? request()->query('mode') : 'grid';

        return view('shop::search.index', [
            'query' => $query,
            'suggestion' => $suggestion,
            'params' => [
                'sort' => $sort,
                'limit' => $limit,
                'mode' => $mode,
            ],
        ]);
    }

    /**
     * Upload image and analyze it for product search keywords.
     */
    public function upload(): JsonResponse
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageUrl = $this->searchRepository->uploadSearchImage(request()->all());

        $keywords = '';

        $useAi = core()->getConfigData('magic_ai.general.settings.enabled')
            && core()->getConfigData('magic_ai.storefront_features.image_search.enabled');

        if ($useAi) {
            try {
                $keywords = MagicAI::analyzeImage(
                    request()->file('image')->getRealPath()
                );
            } catch (\Exception $e) {
                report($e);

                $useAi = false;
            }
        }

        return response()->json([
            'image_url' => $imageUrl,
            'keywords' => $keywords,
            'engine' => $useAi ? 'ai' : 'tensorflow',
        ]);
    }
}
