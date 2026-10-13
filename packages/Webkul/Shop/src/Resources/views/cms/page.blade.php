<x-shop::layouts :has-feature="false">
    <!-- Page Title -->
    <x-slot:title>
        {{ str_contains($page->meta_title ?: $page->page_title, 'SOXNSOX') ? ($page->meta_title ?: $page->page_title) : ($page->meta_title ?: $page->page_title) . ' | SOXNSOX' }}
    </x-slot>

    <!-- SEO Meta Content -->
    @push('meta')
        <meta name="title" content="{{ str_contains($page->meta_title ?: $page->page_title, 'SOXNSOX') ? ($page->meta_title ?: $page->page_title) : ($page->meta_title ?: $page->page_title) . ' | SOXNSOX' }}" />
        <meta name="description" content="{{ $page->meta_description }}" />
        <meta name="keywords" content="{{ $page->meta_keywords }}" />
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
        <link rel="canonical" href="{{ url('/page/' . $page->url_key) }}" />

        <!-- Open Graph -->
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ str_contains($page->meta_title ?: $page->page_title, 'SOXNSOX') ? ($page->meta_title ?: $page->page_title) : ($page->meta_title ?: $page->page_title) . ' | SOXNSOX' }}" />
        <meta property="og:description" content="{{ $page->meta_description }}" />
        <meta property="og:url" content="{{ url('/page/' . $page->url_key) }}" />

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ str_contains($page->meta_title ?: $page->page_title, 'SOXNSOX') ? ($page->meta_title ?: $page->page_title) : ($page->meta_title ?: $page->page_title) . ' | SOXNSOX' }}" />
        <meta name="twitter:description" content="{{ $page->meta_description }}" />

        <!-- JSON-LD BreadcrumbList & WebPage Schema -->
        @php
            $pageSchema = [
                '@context' => 'https://schema.org',
                '@graph'   => [
                    [
                        '@type'       => 'WebPage',
                        '@id'         => url('/page/' . $page->url_key) . '/#webpage',
                        'url'         => url('/page/' . $page->url_key),
                        'name'        => $page->page_title,
                        'description' => $page->meta_description,
                        'isPartOf'    => [
                            '@id' => url('/') . '/#website',
                        ],
                    ],
                    [
                        '@type'           => 'BreadcrumbList',
                        '@id'             => url('/page/' . $page->url_key) . '/#breadcrumb',
                        'itemListElement' => [
                            [
                                '@type'    => 'ListItem',
                                'position' => 1,
                                'name'     => 'Home',
                                'item'     => url('/'),
                            ],
                            [
                                '@type'    => 'ListItem',
                                'position' => 2,
                                'name'     => $page->page_title,
                                'item'     => url('/page/' . $page->url_key),
                            ],
                        ],
                    ],
                ],
            ];
        @endphp
        <script type="application/ld+json">
        {!! json_encode($pageSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endPush

    @php
        $customViews = [
            'about-us'          => 'shop::cms.about-us',
            'our-story'         => 'shop::cms.about-us',
            'why-choose-us'     => 'shop::cms.why-choose-us',
            'how-it-works'      => 'shop::cms.how-it-works',
            'quality'           => 'shop::cms.quality',
            'privacy-policy'    => 'shop::cms.privacy-policy',
            'terms-conditions'  => 'shop::cms.terms-conditions',
            'terms-of-service'  => 'shop::cms.terms-conditions',
            'terms-of-use'      => 'shop::cms.terms-conditions',
            'shipping-policy'   => 'shop::cms.shipping-policy',
        ];

        $dedicatedView = $customViews[$page->url_key] ?? (view()->exists('shop::cms.' . $page->url_key) ? 'shop::cms.' . $page->url_key : null);
    @endphp

    @if ($dedicatedView)
        @include($dedicatedView)
    @elseif (! empty($page->html_content))
        @if (str_contains($page->html_content, 'site-container') || str_contains($page->html_content, 'min-h-screen'))
            <div class="bg-[#f5f7fa] min-h-screen text-[#133b63]">
                @if (core()->getConfigData('general.general.breadcrumbs.shop'))
                    <!-- Breadcrumbs -->
                    <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
                        <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                            <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                            <span class="text-slate-300">/</span>
                            <span class="text-[#133b63] font-semibold">{{ $page->page_title }}</span>
                        </nav>
                    </div>
                @endif

                {!! $page->html_content !!}
            </div>
        @else
            <!-- Standard CMS Page Template (Terms, Return Policy, Privacy Policy, Customer Service, etc.) -->
            <div class="bg-[#f5f7fa] min-h-screen">
                @if (core()->getConfigData('general.general.breadcrumbs.shop'))
                    <!-- Breadcrumbs -->
                    <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
                        <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                            <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                            <span class="text-slate-300">/</span>
                            <span class="text-[#133b63] font-semibold">{{ $page->page_title }}</span>
                        </nav>
                    </div>
                @endif

                <!-- Page Content in Authoritative Global Site Container -->
                <main class="site-container pt-6 pb-20 space-y-8">
                    <header class="text-center space-y-3">
                        <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63]">
                            {{ $page->page_title }}
                        </h1>
                        <div class="soxnsox-decorative-line-center mt-3"></div>
                    </header>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-10 lg:p-12 shadow-sm">
                        <article class="prose prose-slate max-w-none text-[#133b63] leading-relaxed font-sans text-sm sm:text-base [&_h2]:font-display [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-[#133b63] [&_h2]:mt-8 [&_h2]:mb-4 [&_h2]:pb-2 [&_h2]:border-b [&_h2]:border-slate-200 [&_h3]:font-display [&_h3]:text-lg [&_h3]:font-bold [&_h3]:text-[#133b63] [&_h3]:mt-6 [&_h3]:mb-3 [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:space-y-2 [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:space-y-2 [&_li]:text-sm [&_p]:text-sm [&_p]:leading-relaxed [&_a]:text-[#1d5b8f] [&_a]:underline hover:[&_a]:text-[#133b63]">
                            {!! $page->html_content !!}
                        </article>
                    </div>
                </main>
            </div>
        @endif
    @endif
</x-shop::layouts>