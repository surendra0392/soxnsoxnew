<x-shop::layouts>
    <x-slot:title>
        {{ $blog->meta_title ?: $blog->name }} | SOX N SOX
    </x-slot>

    @push('meta')
        <meta name="title" content="{{ $blog->meta_title ?: $blog->name }} | SOX N SOX" />
        <meta name="description" content="{{ $blog->meta_description ?: $blog->short_description }}" />
        <meta name="keywords" content="{{ $blog->meta_keywords ?: 'bamboo socks, diabetic socks, foot health, SOX N SOX blog' }}" />
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
        @php
            $blogCatSlug = \Illuminate\Support\Str::slug($blog->category ?: 'general');
            $canonicalBlogUrl = route('shop.blogs.view', ['category_slug' => $blogCatSlug, 'url_key' => $blog->url_key]);
        @endphp
        <link rel="canonical" href="{{ $canonicalBlogUrl }}" />

        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="SOX N SOX" />
        <meta property="og:title" content="{{ $blog->meta_title ?: $blog->name }}" />
        <meta property="og:description" content="{{ $blog->meta_description ?: $blog->short_description }}" />
        <meta property="og:url" content="{{ $canonicalBlogUrl }}" />
        <meta property="article:published_time" content="{{ $blog->published_at ? $blog->published_at->toIso8601String() : $blog->created_at->toIso8601String() }}" />
        <meta property="article:author" content="{{ $blog->author_name ?? 'SOX N SOX Footcare Team' }}" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ $blog->meta_title ?: $blog->name }}" />
        <meta name="twitter:description" content="{{ $blog->meta_description ?: $blog->short_description }}" />

        @php
            $metaImg = null;
            if ($blog->featured_image) {
                if (filter_var($blog->featured_image, FILTER_VALIDATE_URL)) {
                    $metaImg = $blog->featured_image;
                } elseif (file_exists(public_path('storage/' . $blog->featured_image))) {
                    $metaImg = asset('storage/' . $blog->featured_image);
                } elseif (file_exists(public_path($blog->featured_image))) {
                    $metaImg = asset($blog->featured_image);
                } else {
                    $metaImg = Storage::url($blog->featured_image);
                }
            }
        @endphp

        @if ($metaImg)
            <meta property="og:image" content="{{ $metaImg }}" />
            <meta name="twitter:image" content="{{ $metaImg }}" />
        @endif

        <!-- Schema.org BlogPosting & BreadcrumbList -->
        @php
            $blogViewSchema = [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'BlogPosting',
                        '@id' => $canonicalBlogUrl . '#article',
                        'isPartOf' => [
                            '@type' => 'Blog',
                            '@id' => route('shop.blogs.index') . '#blog',
                            'name' => 'SOX N SOX Foot Wellness Journal',
                        ],
                        'headline' => $blog->name,
                        'description' => $blog->short_description ?: $blog->meta_description,
                        'url' => $canonicalBlogUrl,
                        'datePublished' => $blog->published_at ? $blog->published_at->toIso8601String() : $blog->created_at->toIso8601String(),
                        'dateModified' => $blog->updated_at->toIso8601String(),
                        'mainEntityOfPage' => $canonicalBlogUrl,
                        'author' => [
                            '@type' => 'Person',
                            'name' => $blog->author_name ?: 'SOX N SOX Footcare Team',
                            'jobTitle' => $blog->author_title ?: 'Foot Health Specialist',
                        ],
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => 'SOX N SOX',
                            'url' => url('/'),
                            'logo' => [
                                '@type' => 'ImageObject',
                                'url' => asset('logo.png'),
                            ],
                        ],
                        'image' => $metaImg ?: asset('logo.png'),
                    ],
                    [
                        '@type' => 'BreadcrumbList',
                        '@id' => $canonicalBlogUrl . '#breadcrumb',
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
                            [
                                '@type' => 'ListItem',
                                'position' => 3,
                                'name' => $blog->category ?: 'Foot Care',
                                'item' => route('shop.blogs.category', ['category_slug' => $blogCatSlug]),
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 4,
                                'name' => $blog->name,
                                'item' => $canonicalBlogUrl,
                            ],
                        ],
                    ],
                ],
            ];
        @endphp
        <script type="application/ld+json">
        {!! json_encode($blogViewSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    @push('styles')
        <style>
            /* SOX N SOX Article Editorial Typography */
            .soxnsox-article-content {
                font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                font-size: 1.0625rem;
                line-height: 1.85;
                color: #374151;
            }

            .soxnsox-article-content h2 {
                font-family: 'Poppins', sans-serif !important;
                font-size: 1.75rem !important;
                font-weight: 800 !important;
                color: #133b63 !important;
                line-height: 1.3 !important;
                letter-spacing: -0.015em !important;
                margin-top: 2.75rem !important;
                margin-bottom: 1.125rem !important;
                padding-bottom: 0.625rem !important;
                border-bottom: 1.5px solid #e5e7eb !important;
                display: flex !important;
                align-items: center !important;
                gap: 0.5rem !important;
            }

            @media (min-width: 640px) {
                .soxnsox-article-content h2 {
                    font-size: 2rem !important;
                    margin-top: 3.25rem !important;
                }
            }

            .soxnsox-article-content h3 {
                font-family: 'Poppins', sans-serif !important;
                font-size: 1.375rem !important;
                font-weight: 700 !important;
                color: #133b63 !important;
                line-height: 1.35 !important;
                margin-top: 2.25rem !important;
                margin-bottom: 0.875rem !important;
            }

            .soxnsox-article-content h4 {
                font-family: 'Poppins', sans-serif !important;
                font-size: 1.125rem !important;
                font-weight: 700 !important;
                color: #133b63 !important;
                line-height: 1.4 !important;
                margin-top: 1.5rem !important;
                margin-bottom: 0.625rem !important;
            }

            .soxnsox-article-content p {
                font-size: 1.0625rem !important;
                line-height: 1.85 !important;
                color: #374151 !important;
                margin-bottom: 1.5rem !important;
                font-weight: 400 !important;
            }

            .soxnsox-article-content ul,
            .soxnsox-article-content ol {
                margin-top: 1.25rem !important;
                margin-bottom: 1.75rem !important;
                padding-left: 1.75rem !important;
            }

            .soxnsox-article-content ul {
                list-style-type: disc !important;
            }

            .soxnsox-article-content ol {
                list-style-type: decimal !important;
            }

            .soxnsox-article-content li {
                font-size: 1.0625rem !important;
                line-height: 1.8 !important;
                color: #374151 !important;
                margin-bottom: 0.75rem !important;
                padding-left: 0.25rem !important;
            }

            .soxnsox-article-content li::marker {
                color: #2ca7a3 !important;
                font-weight: 700 !important;
            }

            .soxnsox-article-content strong,
            .soxnsox-article-content b {
                font-weight: 700 !important;
                color: #133b63 !important;
            }

            .soxnsox-article-content em,
            .soxnsox-article-content i {
                font-style: italic !important;
                color: #1f2937 !important;
            }

            .soxnsox-article-content a {
                color: #2ca7a3 !important;
                text-decoration: underline !important;
                font-weight: 600 !important;
                transition: color 0.2s ease !important;
            }

            .soxnsox-article-content a:hover {
                color: #133b63 !important;
            }

            /* Callout / Key Takeaway Boxes */
            .soxnsox-article-content .bg-teal-50\/70,
            .soxnsox-article-content [class*="bg-teal-50"] {
                background: linear-gradient(135deg, #f0fdfa 0%, #e6f8f7 100%) !important;
                border: 1px solid rgba(44, 167, 163, 0.3) !important;
                border-left: 4px solid #2ca7a3 !important;
                border-radius: 1rem !important;
                padding: 1.5rem 1.75rem !important;
                margin: 2.25rem 0 !important;
                box-shadow: 0 4px 16px -2px rgba(44, 167, 163, 0.08) !important;
            }

            .soxnsox-article-content .bg-teal-50\/70 h4,
            .soxnsox-article-content [class*="bg-teal-50"] h4 {
                color: #0f766e !important;
                font-size: 1.0625rem !important;
                font-weight: 800 !important;
                margin-top: 0 !important;
                margin-bottom: 0.5rem !important;
                display: flex !important;
                align-items: center !important;
                gap: 0.5rem !important;
            }

            .soxnsox-article-content .bg-teal-50\/70 p,
            .soxnsox-article-content [class*="bg-teal-50"] p {
                color: #115e59 !important;
                font-size: 0.9375rem !important;
                line-height: 1.75 !important;
                margin-bottom: 0 !important;
            }

            .soxnsox-article-content .bg-amber-50\/70,
            .soxnsox-article-content [class*="bg-amber-50"] {
                background: linear-gradient(135deg, #fffbeb 0%, #fff4e8 100%) !important;
                border: 1px solid rgba(242, 154, 56, 0.3) !important;
                border-left: 4px solid #f29a38 !important;
                border-radius: 1rem !important;
                padding: 1.5rem 1.75rem !important;
                margin: 2.25rem 0 !important;
                box-shadow: 0 4px 16px -2px rgba(242, 154, 56, 0.08) !important;
            }

            .soxnsox-article-content .bg-amber-50\/70 h4,
            .soxnsox-article-content [class*="bg-amber-50"] h4 {
                color: #b45309 !important;
                font-size: 1.0625rem !important;
                font-weight: 800 !important;
                margin-top: 0 !important;
                margin-bottom: 0.5rem !important;
                display: flex !important;
                align-items: center !important;
                gap: 0.5rem !important;
            }

            .soxnsox-article-content .bg-amber-50\/70 p,
            .soxnsox-article-content [class*="bg-amber-50"] p {
                color: #92400e !important;
                font-size: 0.9375rem !important;
                line-height: 1.75 !important;
                margin-bottom: 0 !important;
            }

            /* Responsive Author Avatar */
            .soxnsox-avatar-circle {
                background: linear-gradient(135deg, #133b63 0%, #2ca7a3 100%) !important;
                color: #ffffff !important;
            }
        </style>
    @endpush

    <!-- Unified Width Wrapper (site-container) -->
    <div class="site-container">
        <!-- Breadcrumbs (Precision Aligned) -->
        <nav aria-label="Breadcrumb" class="pt-6 pb-4 sm:pt-8 sm:pb-6 flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
            <a href="{{ route('shop.home.index') }}" class="hover:text-[#2ca7a3] transition-colors">Home</a>
            <span class="text-[#d1d5db]">/</span>
            <a href="{{ route('shop.blogs.index') }}" class="hover:text-[#2ca7a3] transition-colors">Foot Wellness Journal</a>
            <span class="text-[#d1d5db]">/</span>
            <a href="{{ route('shop.blogs.category', ['category_slug' => $blogCatSlug]) }}" class="hover:text-[#2ca7a3] transition-colors">{{ $blog->category ?: 'Foot Care' }}</a>
            <span class="text-[#d1d5db]">/</span>
            <span class="text-[#133b63] font-semibold truncate max-w-[200px] sm:max-w-md">{{ $blog->name }}</span>
        </nav>
    </div>

    <!-- Article Header Section -->
    <section class="bg-gradient-to-b from-[#f8fafc] via-white to-white border-b border-slate-100 pt-4 pb-10 sm:pt-6 sm:pb-14">
        <div class="site-container">
            <!-- Category, Read Time & Date Row -->
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 mb-5">
                <a href="{{ route('shop.blogs.category', ['category_slug' => $blogCatSlug]) }}" class="inline-flex items-center px-3.5 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-[#2ca7a3]/10 text-[#2ca7a3] border border-[#2ca7a3]/30 hover:bg-[#2ca7a3] hover:text-white transition-colors">
                    <i class="fa-solid fa-leaf text-[10px] mr-1.5"></i>
                    {{ $blog->category ?: 'Foot Health' }}
                </a>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                    <i class="fa-regular fa-clock text-[10px]"></i>
                    {{ $blog->read_time ?? 5 }} min read
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500">
                    <i class="fa-regular fa-calendar text-[10px]"></i>
                    {{ ($blog->published_at ?? $blog->created_at)?->format('M d, Y') }}
                </span>
            </div>

            <!-- Main Article Headline -->
            <h1 class="text-3xl sm:text-4xl lg:text-[2.65rem] font-black text-[#133b63] tracking-tight leading-[1.2] mb-5 font-display">
                {{ $blog->name }}
            </h1>

            @if ($blog->short_description)
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed mb-6 font-normal max-w-3xl">
                    {{ $blog->short_description }}
                </p>
            @endif

            <!-- Author & Share Action Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-slate-100">
                <!-- Author Info -->
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-full soxnsox-avatar-circle flex items-center justify-center font-bold text-sm shadow-sm shrink-0 ring-2 ring-[#2ca7a3]/20">
                        {{ strtoupper(substr($blog->author_name ?: 'S', 0, 1)) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-[#133b63] leading-snug">{{ $blog->author_name ?: 'SOX N SOX Team' }}</span>
                        <span class="text-xs text-slate-500 leading-snug">{{ $blog->author_title ?: 'Footwear Ergonomics Lead' }}</span>
                    </div>
                </div>

                <!-- Social Sharing -->
                <div class="flex items-center gap-2 self-start sm:self-center">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 mr-1 hidden sm:inline">Share</span>
                    
                    <!-- WhatsApp -->
                    <a
                        href="https://api.whatsapp.com/send?text={{ urlencode($blog->name . ' - ' . $canonicalBlogUrl) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-9 h-9 rounded-full bg-slate-100 hover:bg-[#25D366] text-slate-600 hover:text-white flex items-center justify-center transition-all duration-200"
                        title="Share on WhatsApp"
                    >
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>

                    <!-- Twitter / X -->
                    <a
                        href="https://twitter.com/intent/tweet?text={{ urlencode($blog->name) }}&url={{ urlencode($canonicalBlogUrl) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-9 h-9 rounded-full bg-slate-100 hover:bg-[#133b63] text-slate-600 hover:text-white flex items-center justify-center transition-all duration-200"
                        title="Share on X (Twitter)"
                    >
                        <i class="fa-brands fa-x-twitter text-xs"></i>
                    </a>

                    <!-- Copy Link -->
                    <button
                        type="button"
                        onclick="navigator.clipboard.writeText('{{ $canonicalBlogUrl }}'); const el = this; el.classList.add('bg-[#2ca7a3]', 'text-white'); setTimeout(() => el.classList.remove('bg-[#2ca7a3]', 'text-white'), 2000);"
                        class="w-9 h-9 rounded-full bg-slate-100 hover:bg-[#2ca7a3] text-slate-600 hover:text-white flex items-center justify-center transition-all duration-200"
                        title="Copy Article Link"
                    >
                        <i class="fa-solid fa-link text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Featured Image Stage -->
    @if ($blog->featured_image)
        @php
            $imgUrl = null;
            if (filter_var($blog->featured_image, FILTER_VALIDATE_URL)) {
                $imgUrl = $blog->featured_image;
            } elseif (file_exists(public_path('storage/' . $blog->featured_image))) {
                $imgUrl = asset('storage/' . $blog->featured_image);
            } elseif (file_exists(public_path($blog->featured_image))) {
                $imgUrl = asset($blog->featured_image);
            } else {
                $imgUrl = Storage::url($blog->featured_image);
            }
        @endphp
        <div class="site-container pt-8 pb-4">
            <div class="relative w-full aspect-[16/9] sm:aspect-[21/9] rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl border border-slate-200/90 bg-slate-100">
                <img
                    src="{{ $imgUrl }}"
                    alt="{{ $blog->name }}"
                    class="w-full h-full object-cover"
                />
            </div>
        </div>
    @endif

    @php
        $processedContent = $blog->content;
        $tocItems = [];
        if (preg_match_all('/<h2[^>]*>(.*?)<\/h2>/i', $blog->content, $matches)) {
            foreach ($matches[1] as $idx => $headingText) {
                $cleanTitle = trim(strip_tags($headingText));
                if (! empty($cleanTitle)) {
                    $slug = \Illuminate\Support\Str::slug($cleanTitle) ?: 'section-' . ($idx + 1);
                    $tocItems[] = [
                        'title' => $cleanTitle,
                        'slug'  => $slug,
                    ];
                    $processedContent = preg_replace(
                        '/<h2([^>]*)>' . preg_quote($headingText, '/') . '<\/h2>/i',
                        '<h2 id="' . $slug . '" class="scroll-mt-28"$1>' . $headingText . '</h2>',
                        $processedContent,
                        1
                    );
                }
            }
        }
    @endphp

    <!-- Main Article Reading Stage (Full site-container 1312px 12-Column Grid) -->
    <section class="py-10 sm:py-16 bg-white border-b border-slate-100">
        <div class="site-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Left Main Content Column (8 cols) -->
                <article class="lg:col-span-8 space-y-12">
                    <!-- Rich HTML Body Content with High-End Editorial Typography -->
                    <div class="soxnsox-article-content">
                        {!! $processedContent !!}
                    </div>

                    <!-- About The Author Box -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#f8fafc] border border-slate-200/90 shadow-sm flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-6">
                        <div class="w-16 h-16 rounded-full soxnsox-avatar-circle text-white flex items-center justify-center font-bold text-xl shadow-md shrink-0 ring-4 ring-white">
                            {{ strtoupper(substr($blog->author_name ?: 'S', 0, 1)) }}
                        </div>
                        <div class="text-center sm:text-left">
                            <div class="flex items-center justify-center sm:justify-start gap-2 mb-1.5">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-[#2ca7a3]/10 text-[#2ca7a3]">
                                    Author &amp; Specialist
                                </span>
                            </div>
                            <h4 class="text-lg font-bold text-[#133b63] mb-1 font-display">{{ $blog->author_name ?: 'SOX N SOX Research Lab' }}</h4>
                            <p class="text-xs text-slate-500 font-semibold mb-2.5">{{ $blog->author_title ?: 'Footwear Ergonomics Lead' }}</p>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-0">
                                Dedicated to advancing sustainable bamboo apparel and ergonomic foot wellness. Focused on blister prevention, diabetic micro-circulation, and hypoallergenic daily comfort for active living across India.
                            </p>
                        </div>
                    </div>
                </article>

                <!-- Right Sticky Sidebar Column (4 cols) -->
                <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
                    @if (! empty($tocItems))
                        <!-- Table of Contents Card -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                                <i class="fa-solid fa-list-ul"></i>
                                <span>In This Article</span>
                            </div>
                            <nav class="space-y-1 text-xs sm:text-sm font-medium">
                                @foreach ($tocItems as $idx => $item)
                                    <a
                                        href="#{{ $item['slug'] }}"
                                        class="flex items-start gap-2.5 py-2 px-3 rounded-xl hover:bg-[#e6f8f7] text-[#133b63] hover:text-[#2ca7a3] transition-colors leading-snug"
                                    >
                                        <span class="text-[11px] font-bold text-[#2ca7a3] shrink-0 mt-0.5">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span>{{ $item['title'] }}</span>
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                    @endif

                    <!-- Doctor / Specialist Recommended Product Spotlight Card -->
                    @if (isset($products) && $products->isNotEmpty())
                        <div class="space-y-3">
                            <div class="flex items-center justify-between px-1">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-[#2ca7a3]/10 text-[#2ca7a3] border border-[#2ca7a3]/20">
                                    <i class="fa-solid fa-star text-[9px] text-[#f29a38]"></i>
                                    Featured Recommendation
                                </span>
                            </div>
                            <x-shop::products.card :product="$products->first()" />
                        </div>
                    @endif

                    <!-- Fast Podiatry Takeaways / Why Bamboo Card -->
                    <div class="bg-gradient-to-br from-[#133b63] to-[#0c243d] rounded-3xl p-6 text-white shadow-md space-y-4">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">
                            <i class="fa-solid fa-shield-heart"></i>
                            <span>Podiatry Standard</span>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-200">
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-check text-[#2ca7a3] text-xs mt-0.5 shrink-0"></i>
                                <span><strong>0mm Ridge:</strong> Hand-linked flat toe seams prevent friction pressure.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-check text-[#2ca7a3] text-xs mt-0.5 shrink-0"></i>
                                <span><strong>4x Absorption:</strong> Bamboo capillary fibers keep skin reliably dry.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-check text-[#2ca7a3] text-xs mt-0.5 shrink-0"></i>
                                <span><strong>Non-Binding Fit:</strong> Promotes healthy venous blood flow all day.</span>
                            </li>
                        </ul>
                        <div class="pt-2 border-t border-white/10 flex items-center justify-between text-xs text-slate-300">
                            <span>Questions about fit?</span>
                            <a href="https://wa.me/918106155111" target="_blank" class="text-[#2ca7a3] hover:underline font-bold inline-flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp"></i> Chat Support
                            </a>
                        </div>
                    </div>

                    <!-- Quick Share Card -->
                    <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#133b63]">Share Guide</span>
                        <div class="flex items-center gap-2">
                            <a
                                href="https://api.whatsapp.com/send?text={{ urlencode($blog->name . ' - ' . $canonicalBlogUrl) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-[#25D366] text-slate-600 hover:text-white flex items-center justify-center transition-all"
                                title="Share on WhatsApp"
                            >
                                <i class="fa-brands fa-whatsapp text-xs"></i>
                            </a>
                            <a
                                href="https://twitter.com/intent/tweet?text={{ urlencode($blog->name) }}&url={{ urlencode($canonicalBlogUrl) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-[#133b63] text-slate-600 hover:text-white flex items-center justify-center transition-all"
                                title="Share on X"
                            >
                                <i class="fa-brands fa-x-twitter text-xs"></i>
                            </a>
                            <button
                                type="button"
                                onclick="navigator.clipboard.writeText('{{ $canonicalBlogUrl }}'); const el = this; el.classList.add('bg-[#2ca7a3]', 'text-white'); setTimeout(() => el.classList.remove('bg-[#2ca7a3]', 'text-white'), 2000);"
                                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-[#2ca7a3] text-slate-600 hover:text-white flex items-center justify-center transition-all"
                                title="Copy Link"
                            >
                                <i class="fa-solid fa-link text-xs"></i>
                            </button>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- Cross-Sell Products Section (Standard site-container) -->
    @if (isset($products) && $products->isNotEmpty())
        <section class="py-16 sm:py-20 bg-[#f8fafc] border-t border-slate-200/80">
            <div class="site-container">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 sm:mb-16" style="margin-bottom: 3.5rem;">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-[0.14em] text-[#2ca7a3] block mb-2">
                            Featured Formulations
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-black text-[#133b63] font-display">
                            Recommended Bamboo Socks
                        </h3>
                    </div>
                    <a
                        href="{{ route('shop.products.index') }}"
                        class="soxnsox-btn-outline px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-full self-start sm:self-auto inline-flex items-center gap-2 hover:bg-[#133b63] hover:text-white transition-all"
                    >
                        <span>Explore All 12 Styles</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                    @foreach ($products->take(4) as $product)
                        <x-shop::products.card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Related Articles Section (Standard site-container) -->
    @if (isset($relatedBlogs) && $relatedBlogs->isNotEmpty())
        <section class="py-16 sm:py-20 bg-white border-t border-slate-200/80">
            <div class="site-container">
                <div class="text-center max-w-xl mx-auto mb-12 sm:mb-16" style="margin-bottom: 3.5rem;">
                    <span class="text-xs font-bold uppercase tracking-[0.14em] text-[#2ca7a3] block mb-2">
                        More Podiatry Insights
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-black text-[#133b63] font-display">
                        Related Articles &amp; Guides
                    </h3>
                    <div class="soxnsox-decorative-line-center my-3.5"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($relatedBlogs as $relBlog)
                        @php
                            $relImgUrl = null;
                            if ($relBlog->featured_image) {
                                if (filter_var($relBlog->featured_image, FILTER_VALIDATE_URL)) {
                                    $relImgUrl = $relBlog->featured_image;
                                } elseif (file_exists(public_path('storage/' . $relBlog->featured_image))) {
                                    $relImgUrl = asset('storage/' . $relBlog->featured_image);
                                } elseif (file_exists(public_path($relBlog->featured_image))) {
                                    $relImgUrl = asset($relBlog->featured_image);
                                } else {
                                    $relImgUrl = Storage::url($relBlog->featured_image);
                                }
                            }
                            $relCatSlug = \Illuminate\Support\Str::slug($relBlog->category ?: 'general');
                            $relBlogUrl = route('shop.blogs.view', ['category_slug' => $relCatSlug, 'url_key' => $relBlog->url_key]);
                        @endphp
                        <article class="group flex flex-col justify-between bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-lg hover:border-[#2ca7a3]/60 hover:-translate-y-1 transition-all duration-300">
                            <div>
                                <a href="{{ $relBlogUrl }}" class="block relative aspect-[16/10] overflow-hidden bg-slate-100">
                                    @if ($relImgUrl)
                                        <img
                                            src="{{ $relImgUrl }}"
                                            alt="{{ $relBlog->name }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        />
                                    @else
                                        <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold">
                                            SOX N SOX
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <a href="{{ route('shop.blogs.category', ['category_slug' => $relCatSlug]) }}" class="inline-flex px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider bg-white/95 text-[#133b63] shadow-xs border border-slate-200/80 hover:bg-[#2ca7a3] hover:text-white transition-colors">
                                            {{ $relBlog->category ?: 'Foot Care' }}
                                        </a>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-[#133b63]/85 text-white">
                                            <i class="fa-regular fa-clock text-[8px]"></i>
                                            {{ $relBlog->read_time ?? 4 }}m
                                        </span>
                                    </div>
                                </a>
                                <div class="p-5 sm:p-6">
                                    <h4 class="text-base font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors leading-snug line-clamp-2 mb-2 font-display">
                                        <a href="{{ $relBlogUrl }}">
                                            {{ $relBlog->name }}
                                        </a>
                                    </h4>
                                    <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed">
                                        {{ $relBlog->short_description }}
                                    </p>
                                </div>
                            </div>
                            <div class="px-5 pb-5 sm:px-6 sm:pb-6 pt-0">
                                <a
                                    href="{{ $relBlogUrl }}"
                                    class="text-xs font-bold uppercase tracking-wider text-[#2ca7a3] group-hover:text-[#133b63] inline-flex items-center gap-1.5 transition-colors"
                                >
                                    <span>Read Guide</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12 sm:mt-14 text-center">
                    <a
                        href="{{ route('shop.blogs.index') }}"
                        class="soxnsox-btn-primary px-8 py-3 rounded-full inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider shadow-md hover:shadow-lg transition-all"
                    >
                        <span>View All Blog Articles</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif
</x-shop::layouts>
