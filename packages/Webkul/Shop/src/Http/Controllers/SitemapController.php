<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL as URLFacade;
use Illuminate\Support\Str;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Webkul\Blog\Models\Blog;
use Webkul\Sitemap\Models\Category as SitemapCategory;
use Webkul\Sitemap\Models\Page as SitemapPage;
use Webkul\Sitemap\Models\Product as SitemapProduct;
use Webkul\Sitemap\Repositories\SitemapRepository;

class SitemapController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected SitemapRepository $sitemapRepository) {}

    /**
     * Serve `/sitemap.xml` for the channel matching the current request host.
     *
     * When generated sitemap files exist for the channel, returns a SitemapIndex
     * pointing to them. Otherwise dynamically generates a clean canonical UrlSet
     * where every URL resolves directly with HTTP 200 (no 301 hops or duplicates).
     */
    public function index(): Response
    {
        $channel = core()->getCurrentChannel();

        $baseUrl = $this->channelBaseUrl($channel);

        $disk = Storage::disk('public');

        $sitemapIndex = SitemapIndex::create();

        $hasGeneratedFiles = false;

        $sitemaps = $this->sitemapRepository->scopeQuery(function ($query) use ($channel) {
            return $query->whereHas('channels', fn ($sub) => $sub->where('channel_id', $channel->id));
        })->all();

        foreach ($sitemaps as $sitemap) {
            $files = $sitemap->additional['channels'][$channel->id]['sitemaps'] ?? [];

            foreach ($files as $file) {
                if ($disk->exists($file)) {
                    $sitemapIndex->add($baseUrl.'/storage/'.ltrim($file, '/'));
                    $hasGeneratedFiles = true;
                }
            }
        }

        if ($hasGeneratedFiles) {
            return response($sitemapIndex->render(), 200, [
                'Content-Type' => 'text/xml; charset=UTF-8',
                'Cache-Control' => 'no-cache, must-revalidate',
            ]);
        }

        $xml = $this->buildLiveSitemapXml($channel, $baseUrl);

        return response($xml, 200, [
            'Content-Type' => 'text/xml; charset=UTF-8',
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }

    /**
     * Build a complete, deduplicated live sitemap containing only canonical 200 URLs.
     */
    protected function buildLiveSitemapXml($channel, string $baseUrl): string
    {
        $originalRoot = url('/');

        URLFacade::forceRootUrl($baseUrl);

        try {
            $sitemap = Sitemap::create();

            $added = [];

            $pushUrl = function (string $loc, ?Carbon $lastMod = null) use ($sitemap, &$added): void {
                if (isset($added[$loc])) {
                    return;
                }

                $added[$loc] = true;

                $tag = Url::create($loc);

                if ($lastMod) {
                    $tag->setLastModificationDate($lastMod);
                }

                $sitemap->add($tag);
            };

            $pushUrl($baseUrl.'/');
            $pushUrl(route('shop.products.index'));
            $pushUrl(route('shop.home.contact_us'));

            $rootCategory = SitemapCategory::query()->find($channel->root_category_id, ['_lft', '_rgt']);

            if ($rootCategory) {
                SitemapCategory::query()
                    ->where('status', 1)
                    ->whereBetween('_lft', [$rootCategory->_lft + 1, $rootCategory->_rgt - 1])
                    ->get()
                    ->each(function ($category) use ($pushUrl): void {
                        if ($category->slug) {
                            $pushUrl(
                                route('shop.category.view', $category->slug),
                                $category->updated_at ? Carbon::create($category->updated_at) : null
                            );
                        }
                    });
            }

            SitemapProduct::query()
                ->whereNull('parent_id')
                ->whereHas('channels', fn ($query) => $query->where('channel_id', $channel->id))
                ->with(['categories', 'attribute_values.attribute'])
                ->get()
                ->each(function ($product) use ($pushUrl): void {
                    if ($product->url_key && $product->status && $product->visible_individually) {
                        $pushUrl(
                            route('shop.products.view', [
                                'category' => $product->getPrimaryCategorySlug(),
                                'slug' => $product->url_key,
                            ]),
                            $product->updated_at ? Carbon::create($product->updated_at) : null
                        );
                    }
                });

            SitemapPage::query()
                ->whereHas('channels', fn ($query) => $query->where('channel_id', $channel->id))
                ->get()
                ->each(function ($page) use ($pushUrl): void {
                    if ($page->url_key) {
                        $pushUrl(
                            route('shop.cms.page', $page->url_key),
                            $page->updated_at ? Carbon::create($page->updated_at) : null
                        );
                    }
                });

            if (class_exists(Blog::class)) {
                $pushUrl(route('shop.blogs.index'));

                Blog::query()
                    ->where('status', 1)
                    ->get()
                    ->each(function ($blog) use ($pushUrl): void {
                        if ($blog->url_key) {
                            $catSlug = Str::slug($blog->category ?: 'wellness') ?: 'general';

                            $pushUrl(
                                route('shop.blogs.view', [
                                    'category_slug' => $catSlug,
                                    'url_key' => $blog->url_key,
                                ]),
                                $blog->updated_at ? Carbon::create($blog->updated_at) : null
                            );
                        }
                    });
            }

            return $sitemap->render();
        } finally {
            URLFacade::forceRootUrl($originalRoot);
        }
    }

    /**
     * Serve `/robots.txt` with crawl rules, a per-channel `Sitemap:` reference,
     * and content usage signals for AI crawlers.
     */
    public function robots(): Response
    {
        $baseUrl = $this->channelBaseUrl(core()->getCurrentChannel());

        $lines = [
            'User-agent: *',
            'Disallow: /admin/',
            'Disallow: /checkout/',
            'Disallow: /customer/',
            'Disallow: /compare',
            'Disallow: /search*',
            '',
            'Content-Signal: search=yes, ai-train=no, ai-input=no',
            'Sitemap: '.$baseUrl.'/sitemap.xml',
            '',
        ];

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }

    /**
     * Resolve a channel's fully-qualified base URL, falling back to the app URL.
     */
    protected function channelBaseUrl($channel): string
    {
        if (! app()->runningInConsole() && request()->getHost()) {
            return rtrim(request()->getSchemeAndHttpHost(), '/');
        }

        $baseUrl = rtrim((string) ($channel?->hostname ?: config('app.url')), '/');

        if (! preg_match('#^https?://#i', $baseUrl)) {
            $scheme = (str_contains($baseUrl, '.test') || str_contains($baseUrl, 'localhost')) ? 'http://' : 'https://';
            $baseUrl = $scheme.ltrim($baseUrl, '/');
        }

        return $baseUrl;
    }
}
