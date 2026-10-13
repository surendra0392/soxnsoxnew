<x-shop::layouts>
    <x-slot:title>
        SOX N SOX Journal | Bamboo Fiber Science &amp; Diabetic Foot Care Blog
    </x-slot>

    @push('meta')
        <meta name="title" content="SOX N SOX Journal | Bamboo Fiber Science &amp; Diabetic Foot Care Blog" />
        <meta name="description" content="Evidence-based podiatry insights, bamboo fiber engineering, diabetic foot comfort, and practical guides to keep your feet blister-free and energized every step of the way." />
        <meta name="keywords" content="bamboo socks blog, diabetic foot care, blister prevention, seamless socks podiatry, SOX N SOX journal" />
        @php
            $currentBlogUrl = ! empty($selectedCategorySlug) ? route('shop.blogs.category', ['category_slug' => $selectedCategorySlug]) : route('shop.blogs.index');
        @endphp
        <link rel="canonical" href="{{ $currentBlogUrl }}" />

        <meta property="og:type" content="blog" />
        <meta property="og:site_name" content="SOX N SOX" />
        <meta property="og:title" content="{{ ! empty($selectedCategory) ? $selectedCategory . ' Articles | SOX N SOX Journal' : 'SOX N SOX Journal | Bamboo Fiber Science &amp; Diabetic Foot Care Blog' }}" />
        <meta property="og:description" content="Evidence-based podiatry insights, bamboo fiber engineering, diabetic foot comfort, and practical guides." />
        <meta property="og:url" content="{{ $currentBlogUrl }}" />
        <meta property="og:image" content="{{ asset('logo.png') }}" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="SOX N SOX Journal | Bamboo Fiber Science &amp; Diabetic Foot Care Blog" />
        <meta name="twitter:description" content="Evidence-based podiatry insights, bamboo fiber engineering, diabetic foot comfort, and practical guides." />
        <meta name="twitter:image" content="{{ asset('logo.png') }}" />

        <!-- Schema.org Blog & BreadcrumbList -->
        @php
            $blogIndexSchema = [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'Blog',
                        '@id' => route('shop.blogs.index') . '#blog',
                        'name' => 'SOX N SOX Foot Wellness Journal',
                        'description' => 'Evidence-based podiatry insights, bamboo fiber engineering, and diabetic foot comfort guides.',
                        'url' => route('shop.blogs.index'),
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => 'SOX N SOX',
                            'url' => url('/'),
                            'logo' => [
                                '@type' => 'ImageObject',
                                'url' => asset('logo.png'),
                            ],
                        ],
                    ],
                    [
                        '@type' => 'BreadcrumbList',
                        '@id' => route('shop.blogs.index') . '#breadcrumb',
                        'itemListElement' => [
                            [
                                '@type' => 'ListItem',
                                'position' => 1,
                                'name' => 'Home',
                                'item' => route('shop.home.index'),
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 2,
                                'name' => 'Foot Wellness Journal',
                                'item' => route('shop.blogs.index'),
                            ],
                        ],
                    ],
                ],
            ];
        @endphp
        <script type="application/ld+json">
        {!! json_encode($blogIndexSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    @push('styles')
        <style>
            .soxnsox-avatar-circle {
                background: linear-gradient(135deg, #133b63 0%, #2ca7a3 100%) !important;
                color: #ffffff !important;
            }
        </style>
    @endpush

    <!-- Unified Width Wrapper (site-container) -->
    <div class="site-container">
        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" class="pt-6 pb-2 sm:pt-8 sm:pb-3 flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
            <a href="{{ route('shop.home.index') }}" class="hover:text-[#2ca7a3] transition-colors">Home</a>
            <span class="text-[#d1d5db]">/</span>
            @if (! empty($selectedCategory))
                <a href="{{ route('shop.blogs.index') }}" class="hover:text-[#2ca7a3] transition-colors">Foot Wellness Journal</a>
                <span class="text-[#d1d5db]">/</span>
                <span class="text-[#133b63] font-semibold">{{ $selectedCategory }}</span>
            @else
                <span class="text-[#133b63] font-semibold">Foot Wellness Journal</span>
            @endif
        </nav>
    </div>

    <!-- Hero Header -->
    <section class="relative bg-gradient-to-b from-[#f8fafc] via-white to-white pt-6 pb-12 sm:pt-10 sm:pb-16 border-b border-slate-100 overflow-hidden">
        <div class="site-container relative z-10 text-center">
            <!-- Eyebrow Pill -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#2ca7a3]/10 border border-[#2ca7a3]/25 text-[#2ca7a3] text-xs font-bold uppercase tracking-[0.14em] mb-4 shadow-xs">
                <i class="fa-solid fa-book-open-reader text-xs"></i>
                SOX N SOX Journal &amp; Wellness
            </div>

            <h1 class="text-3xl sm:text-5xl font-black text-[#133b63] tracking-tight mb-4 font-display leading-tight">
                {{ ! empty($selectedCategory) ? $selectedCategory . ' Articles' : 'The Bamboo & Foot Health Journal' }}
            </h1>

            <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto font-normal">
                Evidence-based podiatry insights, bamboo fiber engineering, diabetic foot comfort, and practical guides to keep your feet blister-free and energized every step of the way.
            </p>

            <!-- Category Pills Filter Bar -->
            @if ($categories->isNotEmpty())
                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5 mt-8 pt-2">
                    <a
                        href="{{ route('shop.blogs.index') }}"
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ empty($selectedCategory) ? 'bg-[#133b63] text-white shadow-md' : 'bg-white text-slate-600 hover:text-[#133b63] border border-slate-200 hover:border-slate-300 shadow-xs' }}"
                    >
                        All Articles
                    </a>
                    @foreach ($categories as $cat)
                        @php
                            $catSlug = \Illuminate\Support\Str::slug($cat);
                            $isActive = (isset($selectedCategorySlug) && $selectedCategorySlug === $catSlug) || ($selectedCategory === $cat);
                        @endphp
                        <a
                            href="{{ route('shop.blogs.category', ['category_slug' => $catSlug]) }}"
                            class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $isActive ? 'bg-[#2ca7a3] text-white shadow-md' : 'bg-white text-slate-600 hover:text-[#2ca7a3] border border-slate-200 hover:border-slate-300 shadow-xs' }}"
                        >
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Main Content Stage (Standard site-container) -->
    <section class="py-12 sm:py-16 bg-[#fcfdfd]">
        <div class="site-container">
            @if ($blogs->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 p-8 max-w-xl mx-auto shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-[#2ca7a3]/10 text-[#2ca7a3] flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#133b63] mb-2 font-display">No articles found in this category</h3>
                    <p class="text-sm text-slate-500 mb-6">Explore all articles or check back soon for our latest podiatry insights.</p>
                    <a href="{{ route('shop.blogs.index') }}" class="soxnsox-btn-primary px-6 py-2.5 rounded-full inline-block text-xs uppercase font-bold tracking-wider">
                        View All Articles
                    </a>
                </div>
            @else
                @php
                    $isAllView = empty($selectedCategory);
                    $firstBlog = $blogs->first();
                    $remainingBlogs = $isAllView && $blogs->count() > 1 ? $blogs->slice(1) : $blogs;
                @endphp

                <!-- Featured Story Hero Card (When viewing all articles) -->
                @if ($isAllView && $firstBlog)
                    @php
                        $heroImgUrl = null;
                        if ($firstBlog->featured_image) {
                            if (filter_var($firstBlog->featured_image, FILTER_VALIDATE_URL)) {
                                $heroImgUrl = $firstBlog->featured_image;
                            } elseif (file_exists(public_path('storage/' . $firstBlog->featured_image))) {
                                $heroImgUrl = asset('storage/' . $firstBlog->featured_image);
                            } elseif (file_exists(public_path($firstBlog->featured_image))) {
                                $heroImgUrl = asset($firstBlog->featured_image);
                            } else {
                                $heroImgUrl = Storage::url($firstBlog->featured_image);
                            }
                        }
                        $firstBlogCatSlug = \Illuminate\Support\Str::slug($firstBlog->category ?: 'general');
                        $firstBlogUrl = route('shop.blogs.view', ['category_slug' => $firstBlogCatSlug, 'url_key' => $firstBlog->url_key]);
                    @endphp
                    <div class="mb-12 sm:mb-16">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold uppercase tracking-[0.14em] text-[#2ca7a3] flex items-center gap-2">
                                <i class="fa-solid fa-star text-xs text-[#f29a38]"></i>
                                Featured Story
                            </span>
                        </div>

                        <article class="group bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-[#2ca7a3]/60 transition-all duration-300 overflow-hidden">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                                <!-- Image Column (7 cols) -->
                                <a href="{{ $firstBlogUrl }}" class="lg:col-span-7 block relative aspect-[16/10] sm:aspect-[16/9] lg:aspect-auto lg:h-full min-h-[260px] overflow-hidden bg-slate-100">
                                    @if ($heroImgUrl)
                                        <img
                                             src="{{ $heroImgUrl }}"
                                             alt="{{ $firstBlog->name }}"
                                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                        />
                                    @else
                                        <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-xl">
                                            SOX N SOX
                                        </div>
                                    @endif
                                    <!-- Badges -->
                                    <div class="absolute top-4 left-4 z-10">
                                        <a href="{{ route('shop.blogs.category', ['category_slug' => $firstBlogCatSlug]) }}" class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/95 text-[#133b63] shadow-md border border-slate-200/80 backdrop-blur-md hover:bg-[#2ca7a3] hover:text-white transition-colors">
                                            {{ $firstBlog->category ?: 'Foot Care' }}
                                        </a>
                                    </div>
                                    <div class="absolute top-4 right-4 z-10">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#133b63]/85 text-white backdrop-blur-md">
                                            <i class="fa-regular fa-clock text-[9px]"></i>
                                            {{ $firstBlog->read_time ?? 5 }} min read
                                        </span>
                                    </div>
                                </a>

                                <!-- Content Column (5 cols) -->
                                <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 flex flex-col justify-between">
                                    <div>
                                        <!-- Date & Author -->
                                        <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
                                            <span>{{ ($firstBlog->published_at ?? $firstBlog->created_at)?->format('M d, Y') }}</span>
                                            <span>&bull;</span>
                                            <span class="font-medium text-slate-700 truncate">{{ $firstBlog->author_name ?: 'SOX N SOX Team' }}</span>
                                        </div>

                                        <!-- Title -->
                                        <h2 class="text-xl sm:text-2xl font-black text-[#133b63] group-hover:text-[#2ca7a3] transition-colors leading-snug tracking-tight mb-3 font-display">
                                            <a href="{{ $firstBlogUrl }}">
                                                {{ $firstBlog->name }}
                                            </a>
                                        </h2>

                                        <!-- Excerpt -->
                                        <p class="text-sm text-slate-600 leading-relaxed line-clamp-3 mb-6">
                                            {{ $firstBlog->short_description }}
                                        </p>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="pt-2">
                                        <a
                                            href="{{ $firstBlogUrl }}"
                                            class="soxnsox-btn-primary px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider inline-flex items-center gap-2 shadow-md hover:shadow-lg transition-all"
                                        >
                                            <span>Read Featured Article</span>
                                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Heading for Remaining Articles -->
                    <div class="flex items-center justify-between mb-10 sm:mb-14" style="margin-bottom: 2.75rem;">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-[0.14em] text-[#2ca7a3] block mb-1.5">
                                Podiatry &amp; Wellness Library
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-black text-[#133b63] font-display">
                                Latest Articles &amp; Guides
                            </h3>
                        </div>
                    </div>
                @endif

                <!-- Grid of Articles (Balanced 3-column layout) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($remainingBlogs as $blog)
                        @php
                            $imgUrl = null;
                            if ($blog->featured_image) {
                                if (filter_var($blog->featured_image, FILTER_VALIDATE_URL)) {
                                    $imgUrl = $blog->featured_image;
                                } elseif (file_exists(public_path('storage/' . $blog->featured_image))) {
                                    $imgUrl = asset('storage/' . $blog->featured_image);
                                } elseif (file_exists(public_path($blog->featured_image))) {
                                    $imgUrl = asset($blog->featured_image);
                                } else {
                                    $imgUrl = Storage::url($blog->featured_image);
                                }
                            }
                            $blogCatSlug = \Illuminate\Support\Str::slug($blog->category ?: 'general');
                            $blogUrl = route('shop.blogs.view', ['category_slug' => $blogCatSlug, 'url_key' => $blog->url_key]);
                        @endphp
                        <article class="group flex flex-col justify-between bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-xl hover:border-[#2ca7a3]/60 hover:-translate-y-1.5 transition-all duration-300">
                            <div>
                                <!-- Image Stage -->
                                <a href="{{ $blogUrl }}" class="block relative aspect-[16/10] overflow-hidden bg-slate-100">
                                    @if ($imgUrl)
                                        <img
                                            src="{{ $imgUrl }}"
                                            alt="{{ $blog->name }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                        />
                                    @else
                                        <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold">
                                            SOX N SOX
                                        </div>
                                    @endif

                                    <!-- Category Pill -->
                                    <div class="absolute z-10" style="top: 14px; left: 14px;">
                                        <a href="{{ route('shop.blogs.category', ['category_slug' => $blogCatSlug]) }}" class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/95 text-[#133b63] shadow-xs border border-slate-200/80 backdrop-blur-md hover:bg-[#2ca7a3] hover:text-white transition-colors">
                                            {{ $blog->category ?: 'Foot Care' }}
                                        </a>
                                    </div>

                                    <!-- Read Time Badge -->
                                    <div class="absolute z-10" style="top: 14px; right: 14px;">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#133b63]/85 text-white backdrop-blur-md">
                                            <i class="fa-regular fa-clock text-[9px]"></i>
                                            {{ $blog->read_time ?? 5 }} min
                                        </span>
                                    </div>
                                </a>

                                <!-- Content Body -->
                                <div class="p-6">
                                    <!-- Date & Author Row -->
                                    <div class="flex items-center gap-2 text-xs text-slate-500 mb-2.5">
                                        <span>{{ ($blog->published_at ?? $blog->created_at)?->format('M d, Y') }}</span>
                                        <span>&bull;</span>
                                        <span class="font-medium text-slate-700 truncate">{{ $blog->author_name ?: 'SOX N SOX Team' }}</span>
                                    </div>

                                    <!-- Title -->
                                    <h2 class="text-base sm:text-lg font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors leading-snug tracking-tight mb-2.5 line-clamp-2 font-display">
                                        <a href="{{ $blogUrl }}">
                                            {{ $blog->name }}
                                        </a>
                                    </h2>

                                    <!-- Excerpt -->
                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3 mb-4 font-normal">
                                        {{ $blog->short_description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer CTA -->
                            <div class="px-6 pb-6 pt-0">
                                <a
                                    href="{{ $blogUrl }}"
                                    class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3] group-hover:text-[#133b63] transition-colors"
                                >
                                    <span>Read Full Guide</span>
                                    <i class="fa-solid fa-arrow-right text-[11px] group-hover:translate-x-1.5 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($blogs->hasPages())
                    <div class="mt-12 sm:mt-16 text-center">
                        {{ $blogs->withQueryString()->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>
</x-shop::layouts>
