<?php

namespace Webkul\Blog\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\ResponseCache\Facades\ResponseCache;
use Webkul\Blog\DataGrids\BlogDataGrid;
use Webkul\Blog\Repositories\BlogRepository;
use Webkul\Product\Repositories\ProductRepository;

class BlogController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Blog Repository instance.
     *
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * Product Repository instance.
     *
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(
        BlogRepository $blogRepository,
        ProductRepository $productRepository
    ) {
        $this->blogRepository = $blogRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of blog posts.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return app(BlogDataGrid::class)->toJson();
        }

        return view('blog::admin.index');
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create(): View
    {
        $products = $this->productRepository->all();

        return view('blog::admin.create', compact('products'));
    }

    /**
     * Store a newly created blog post.
     */
    public function store(): RedirectResponse
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'url_key' => 'required|string|max:255|unique:blog_translations,url_key',
            'short_description' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'author_name' => 'nullable|string|max:255',
            'author_title' => 'nullable|string|max:255',
            'read_time' => 'nullable|integer|min:1',
            'category' => 'nullable|string|max:100',
        ]);

        $data = request()->all();
        $locale = app()->getLocale();

        $featuredImagePath = null;
        if (request()->hasFile('featured_image')) {
            $featuredImagePath = request()->file('featured_image')->store('blogs');
        }

        $blogData = [
            'status' => (bool) ($data['status'] ?? 0),
            'featured_image' => $featuredImagePath,
            'author_name' => $data['author_name'] ?: 'SOX N SOX Team',
            'author_title' => $data['author_title'] ?: 'Footwear & Ergonomics Specialist',
            'read_time' => (int) ($data['read_time'] ?: 5),
            'published_at' => ! empty($data['published_at']) ? $data['published_at'] : now(),
            $locale => [
                'name' => $data['name'],
                'url_key' => $data['url_key'],
                'short_description' => $data['short_description'] ?? '',
                'content' => $data['content'] ?? '',
                'category' => $data['category'] ?: 'Foot Care',
                'meta_title' => $data['meta_title'] ?: $data['name'],
                'meta_description' => $data['meta_description'] ?: ($data['short_description'] ?? ''),
                'meta_keywords' => $data['meta_keywords'] ?? '',
            ],
        ];

        $blog = $this->blogRepository->create($blogData);

        if (! empty($data['product_ids']) && is_array($data['product_ids'])) {
            $blog->products()->sync($data['product_ids']);
        }

        if (class_exists(ResponseCache::class)) {
            ResponseCache::clear();
        }

        session()->flash('success', trans('blog::app.admin.blogs.create-success'));

        return redirect()->route('admin.blogs.index');
    }

    /**
     * Show the form for editing the specified blog post.
     */
    public function edit(int $id): View
    {
        $blog = $this->blogRepository->findOrFail($id);
        $products = $this->productRepository->all();

        return view('blog::admin.edit', compact('blog', 'products'));
    }

    /**
     * Update the specified blog post.
     */
    public function update(int $id): RedirectResponse
    {
        $blog = $this->blogRepository->findOrFail($id);
        $locale = app()->getLocale();
        $translation = $blog->translate($locale);
        $translationId = $translation?->id;

        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'url_key' => 'required|string|max:255|unique:blog_translations,url_key,'.$translationId,
            'short_description' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'author_name' => 'nullable|string|max:255',
            'author_title' => 'nullable|string|max:255',
            'read_time' => 'nullable|integer|min:1',
            'category' => 'nullable|string|max:100',
        ]);

        $data = request()->all();

        $featuredImagePath = $blog->featured_image;
        if (request()->hasFile('featured_image')) {
            if ($featuredImagePath && Storage::exists($featuredImagePath)) {
                Storage::delete($featuredImagePath);
            }
            $featuredImagePath = request()->file('featured_image')->store('blogs');
        }

        $blogData = [
            'status' => (bool) ($data['status'] ?? 0),
            'featured_image' => $featuredImagePath,
            'author_name' => $data['author_name'] ?: 'SOX N SOX Team',
            'author_title' => $data['author_title'] ?: 'Footwear & Ergonomics Specialist',
            'read_time' => (int) ($data['read_time'] ?: 5),
            'published_at' => ! empty($data['published_at']) ? $data['published_at'] : $blog->published_at,
            $locale => [
                'name' => $data['name'],
                'url_key' => $data['url_key'],
                'short_description' => $data['short_description'] ?? '',
                'content' => $data['content'] ?? '',
                'category' => $data['category'] ?: 'Foot Care',
                'meta_title' => $data['meta_title'] ?: $data['name'],
                'meta_description' => $data['meta_description'] ?: ($data['short_description'] ?? ''),
                'meta_keywords' => $data['meta_keywords'] ?? '',
            ],
        ];

        $blog = $this->blogRepository->update($blogData, $id);

        if (isset($data['product_ids'])) {
            $blog->products()->sync((array) $data['product_ids']);
        } else {
            $blog->products()->detach();
        }

        if (class_exists(ResponseCache::class)) {
            ResponseCache::clear();
        }

        session()->flash('success', trans('blog::app.admin.blogs.update-success'));

        return redirect()->route('admin.blogs.index');
    }

    /**
     * Remove the specified blog post.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $blog = $this->blogRepository->findOrFail($id);

            if ($blog->featured_image && Storage::exists($blog->featured_image)) {
                Storage::delete($blog->featured_image);
            }

            $this->blogRepository->delete($id);

            if (class_exists(ResponseCache::class)) {
                ResponseCache::clear();
            }

            return new JsonResponse([
                'message' => trans('blog::app.admin.blogs.delete-success'),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
