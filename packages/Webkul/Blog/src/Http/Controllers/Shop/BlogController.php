<?php

namespace Webkul\Blog\Http\Controllers\Shop;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Webkul\Blog\Repositories\BlogRepository;
use Webkul\Product\Repositories\ProductRepository;

class BlogController extends Controller
{
    /**
     * Blog Repository instance.
     *
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of blog articles on the storefront.
     */
    public function index(): View|RedirectResponse
    {
        // 301 redirect query param ?category=... to clean URL /blog/category/{category_slug}
        if (request()->has('category') && filled(request('category'))) {
            $catSlug = Str::slug(request('category'));

            return redirect()->route('shop.blogs.category', ['category_slug' => $catSlug], 301);
        }

        $query = $this->blogRepository->getModel()
            ->where('status', 1)
            ->with(['translations', 'products'])
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc');

        $allPublished = (clone $query)->get();
        $featuredBlog = $allPublished->first();

        $blogs = $query->paginate(9);

        // Get unique categories for filter tabs
        $categories = $this->blogRepository->getModel()
            ->where('status', 1)
            ->with('translations')
            ->get()
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        $selectedCategory = null;
        $selectedCategorySlug = null;

        return view('blog::shop.index', compact('blogs', 'featuredBlog', 'categories', 'selectedCategory', 'selectedCategorySlug'));
    }

    /**
     * Display articles filtered by clean category slug.
     */
    public function category(string $categorySlug): View|RedirectResponse
    {
        $categories = $this->blogRepository->getModel()
            ->where('status', 1)
            ->with('translations')
            ->get()
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        $matchedCategory = $categories->first(function ($cat) use ($categorySlug) {
            return Str::slug($cat) === $categorySlug;
        });

        if (! $matchedCategory) {
            return redirect()->route('shop.blogs.index', [], 301);
        }

        $query = $this->blogRepository->getModel()
            ->where('status', 1)
            ->with(['translations', 'products'])
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->whereHas('translations', function ($q) use ($matchedCategory) {
                $q->where('category', $matchedCategory);
            });

        $blogs = $query->paginate(9);
        $featuredBlog = null;
        $selectedCategory = $matchedCategory;
        $selectedCategorySlug = $categorySlug;

        return view('blog::shop.index', compact('blogs', 'featuredBlog', 'categories', 'selectedCategory', 'selectedCategorySlug'));
    }

    /**
     * Display the specified blog article on the storefront.
     */
    public function view(string $categorySlug, string $urlKey): View|RedirectResponse
    {
        $cleanKey = ltrim($urlKey, '/');
        $rawKey = str_replace(['blog/', 'blogs/', 'article/', 'articles/'], '', $cleanKey);

        $blog = $this->blogRepository->getModel()
            ->where('status', 1)
            ->with(['translations', 'products'])
            ->whereHas('translations', function ($query) use ($cleanKey, $rawKey) {
                $query->whereIn('url_key', [$cleanKey, $rawKey]);
            })
            ->firstOrFail();

        $canonicalCatSlug = Str::slug($blog->category ?: 'general');

        if ($categorySlug !== $canonicalCatSlug || $cleanKey !== $blog->url_key) {
            return redirect()->route('shop.blogs.view', [
                'category_slug' => $canonicalCatSlug,
                'url_key' => $blog->url_key,
            ], 301);
        }

        // Related articles (matching category or latest)
        $relatedBlogs = $this->blogRepository->getModel()
            ->where('status', 1)
            ->where('id', '!=', $blog->id)
            ->with(['translations'])
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();

        // Associated products or fallback featured parent products (never variants)
        $products = $blog->products()->whereNull('parent_id')->get();
        if ($products->isEmpty()) {
            $products = app(ProductRepository::class)
                ->scopeQuery(function ($query) {
                    return $query->whereNull('parent_id');
                })
                ->all()
                ->take(4);
        }

        return view('blog::shop.view', compact('blog', 'relatedBlogs', 'products'));
    }

    /**
     * 301 redirect legacy /article/{url_key} to canonical /blog/{category_slug}/article/{url_key}.
     */
    public function legacyArticleRedirect(string $urlKey): RedirectResponse
    {
        $cleanKey = ltrim($urlKey, '/');
        $rawKey = str_replace(['blog/', 'blogs/', 'article/', 'articles/'], '', $cleanKey);

        $blog = $this->blogRepository->getModel()
            ->where('status', 1)
            ->whereHas('translations', function ($query) use ($cleanKey, $rawKey) {
                $query->whereIn('url_key', [$cleanKey, $rawKey]);
            })
            ->first();

        if ($blog) {
            return redirect()->route('shop.blogs.view', [
                'category_slug' => Str::slug($blog->category ?: 'general'),
                'url_key' => $blog->url_key,
            ], 301);
        }

        return redirect()->route('shop.blogs.index', [], 301);
    }

    /**
     * 301 redirect legacy /blog/{url_key} or /blogs/{url_key}.
     */
    public function legacyBlogSegmentRedirect(string $urlKey): RedirectResponse
    {
        $cleanKey = trim($urlKey, '/');

        // Check if it matches a category slug
        $categories = $this->blogRepository->getModel()
            ->where('status', 1)
            ->with('translations')
            ->get()
            ->pluck('category')
            ->filter()
            ->unique();

        $matchedCat = $categories->first(function ($cat) use ($cleanKey) {
            return Str::slug($cat) === $cleanKey;
        });

        if ($matchedCat) {
            return redirect()->route('shop.blogs.category', ['category_slug' => Str::slug($matchedCat)], 301);
        }

        // Check if it matches an article url_key
        return $this->legacyArticleRedirect($cleanKey);
    }
}
