@inject('productRepository', 'Webkul\Product\Repositories\ProductRepository')
@inject('heroSliderRepository', 'Webkul\Theme\Repositories\HeroSliderRepository')

@php
    $channel = core()->getCurrentChannel();

    // Query 8 Featured Products
    $featuredProducts = app('Webkul\Product\Repositories\ProductRepository')->getModel()
        ->whereHas('attribute_values', function($q) {
            $q->whereHas('attribute', fn($q2) => $q2->where('code', 'status'))
              ->where('boolean_value', 1);
        })
        ->whereHas('attribute_values', function($q) {
            $q->whereHas('attribute', fn($q2) => $q2->where('code', 'visible_individually'))
              ->where('boolean_value', 1);
        })
        ->orderBy('updated_at', 'desc')
        ->take(8)->get();

    // Query 4 Best Sellers
    $bestSellers = app('Webkul\Product\Repositories\ProductRepository')->getModel()
        ->whereHas('attribute_values', function($q) {
            $q->whereHas('attribute', fn($q2) => $q2->where('code', 'status'))
              ->where('boolean_value', 1);
        })
        ->whereHas('attribute_values', function($q) {
            $q->whereHas('attribute', fn($q2) => $q2->where('code', 'visible_individually'))
              ->where('boolean_value', 1);
        })
        ->orderBy('id', 'asc')
        ->take(4)->get();

    // Query Hero Slider and Dynamic Slides from Admin Panel
    $heroSlider = null;
    $heroSlidesList = [];
    $heroAutoplay = true;
    $heroDuration = 6000;

    try {
        $heroSlider = $heroSliderRepository->with(['slides' => function($q) {
            $q->where('status', 1)->orderBy('sort_order', 'asc');
        }])->findOneWhere(['code' => 'soxnsox-homepage-hero', 'status' => 1]);

        if ($heroSlider) {
            $sliderSettings = is_array($heroSlider->settings) ? $heroSlider->settings : (json_decode($heroSlider->settings, true) ?: []);
            $heroAutoplay = isset($sliderSettings['autoplay']) ? (bool) $sliderSettings['autoplay'] : true;
            $heroDuration = isset($sliderSettings['duration']) ? (int) $sliderSettings['duration'] : 6000;

            if ($heroSlider->slides && $heroSlider->slides->isNotEmpty()) {
                foreach ($heroSlider->slides as $dbSlide) {
                    $sSettings = is_array($dbSlide->settings) ? $dbSlide->settings : (json_decode($dbSlide->settings, true) ?: []);

                    $bgUrl = $dbSlide->desktop_media;
                    if ($bgUrl) {
                        if (!str_starts_with($bgUrl, 'http') && !str_starts_with($bgUrl, '/')) {
                            if (file_exists(public_path($bgUrl))) {
                                $bgUrl = asset($bgUrl);
                            } elseif (file_exists(public_path('storage/' . $bgUrl))) {
                                $bgUrl = asset('storage/' . $bgUrl);
                            } else {
                                $bgUrl = asset($bgUrl);
                            }
                        } elseif (str_starts_with($bgUrl, '/')) {
                            $bgUrl = url($bgUrl);
                        }
                    } else {
                        $bgUrl = asset('images/hero-slide-1.webp');
                    }

                    $heroSlidesList[] = [
                        'id'             => $dbSlide->id,
                        'shortTitle'     => $sSettings['short_title'] ?? $dbSlide->name ?? 'Comfort',
                        'bgImage'        => $bgUrl,
                        'eyebrow'        => $sSettings['eyebrow'] ?? 'PREMIUM EVERYDAY SOCKS',
                        'titleMain'      => $sSettings['title_main'] ?? $dbSlide->name ?? 'Comfort, Style &',
                        'titleHighlight' => $sSettings['title_highlight'] ?? 'Support For Every Step',
                        'description'    => $sSettings['description'] ?? 'Premium socks designed for everyday comfort, movement, and modern lifestyles — for Men, Women & Children.',
                        'badges'         => !empty($sSettings['badges']) && is_array($sSettings['badges']) ? $sSettings['badges'] : [
                            ['icon' => 'fa-solid fa-heart-pulse', 'label1' => 'Breathable', 'label2' => 'Comfort'],
                            ['icon' => 'fa-solid fa-shield-halved', 'label1' => 'Everyday', 'label2' => 'Durability'],
                            ['icon' => 'fa-solid fa-check', 'label1' => 'Soft', 'label2' => 'Support'],
                            ['icon' => 'fa-solid fa-wind', 'label1' => 'Modern', 'label2' => 'Fit'],
                        ],
                        'primaryBtn'     => [
                            'text' => $sSettings['primary_btn_text'] ?? 'SHOP PREMIUM SOCKS',
                            'url'  => !empty($sSettings['primary_btn_url']) ? (str_starts_with($sSettings['primary_btn_url'], 'http') || str_starts_with($sSettings['primary_btn_url'], '#') ? $sSettings['primary_btn_url'] : url($sSettings['primary_btn_url'])) : route('shop.products.index'),
                        ],
                        'secondaryBtn'   => [
                            'text' => $sSettings['secondary_btn_text'] ?? 'EXPLORE COLLECTIONS',
                            'url'  => !empty($sSettings['secondary_btn_url']) ? (str_starts_with($sSettings['secondary_btn_url'], 'http') || str_starts_with($sSettings['secondary_btn_url'], '#') ? $sSettings['secondary_btn_url'] : url($sSettings['secondary_btn_url'])) : route('shop.products.index'),
                        ],
                    ];
                }
            }
        }
    } catch (\Throwable $e) {}

    // Fallback if no active slides found in DB
    if (empty($heroSlidesList)) {
        $heroSlidesList = [
            [
                'id'             => 1,
                'shortTitle'     => 'Everyday Comfort',
                'bgImage'        => asset('images/hero-slide-1.webp'),
                'eyebrow'        => 'PREMIUM EVERYDAY SOCKS',
                'titleMain'      => 'Comfort, Style &',
                'titleHighlight' => 'Support For Every Step',
                'description'    => 'Premium socks designed for everyday comfort, movement, and modern lifestyles — for Men, Women & Children.',
                'badges'         => [
                    ['icon' => 'fa-solid fa-heart-pulse', 'label1' => 'Breathable', 'label2' => 'Comfort'],
                    ['icon' => 'fa-solid fa-shield-halved', 'label1' => 'Everyday', 'label2' => 'Durability'],
                    ['icon' => 'fa-solid fa-check', 'label1' => 'Soft', 'label2' => 'Support'],
                    ['icon' => 'fa-solid fa-wind', 'label1' => 'Modern', 'label2' => 'Fit'],
                ],
                'primaryBtn'     => ['text' => 'SHOP PREMIUM SOCKS', 'url' => route('shop.products.index')],
                'secondaryBtn'   => ['text' => 'EXPLORE COLLECTIONS', 'url' => route('shop.products.index')],
            ],
            [
                'id'             => 2,
                'shortTitle'     => 'Diabetic Care',
                'bgImage'        => asset('images/hero-slide-2.webp'),
                'eyebrow'        => 'CLINICALLY DESIGNED COMFORT',
                'titleMain'      => 'Diabetic & Compression Footwear',
                'titleHighlight' => 'For Sensitive Feet',
                'description'    => 'Non-binding loose-top cuffs that protect blood circulation, hand-linked seamless toes, and cushioned sole relief.',
                'badges'         => [
                    ['icon' => 'fa-solid fa-heart-circle-check', 'label1' => 'Circulation', 'label2' => 'Care'],
                    ['icon' => 'fa-solid fa-feather', 'label1' => 'Non-Binding', 'label2' => 'Tops'],
                    ['icon' => 'fa-solid fa-shield-halved', 'label1' => 'Seamless', 'label2' => 'Toe'],
                    ['icon' => 'fa-solid fa-stethoscope', 'label1' => 'Doctor', 'label2' => 'Approved'],
                ],
                'primaryBtn'     => ['text' => 'SHOP DIABETIC SOCKS', 'url' => route('shop.products.index')],
                'secondaryBtn'   => ['text' => 'VIEW MEDICAL RANGE', 'url' => route('shop.products.index')],
            ],
            [
                'id'             => 3,
                'shortTitle'     => 'Athletic Grip',
                'bgImage'        => asset('images/hero-slide-3.webp'),
                'eyebrow'        => 'ENGINEERED PERFORMANCE',
                'titleMain'      => 'Targeted Arch Support & Anti-Slip Grip',
                'titleHighlight' => 'For Active Life',
                'description'    => 'High-density knit with dynamic mid-foot compression and moisture-wicking fibers for training, work, and everyday movement.',
                'badges'         => [
                    ['icon' => 'fa-solid fa-shoe-prints', 'label1' => 'Anti-Slip', 'label2' => 'Traction'],
                    ['icon' => 'fa-solid fa-bolt', 'label1' => 'Dynamic Arch', 'label2' => 'Band'],
                    ['icon' => 'fa-solid fa-droplet-slash', 'label1' => 'Rapid-Dry', 'label2' => 'Mesh'],
                    ['icon' => 'fa-solid fa-shield', 'label1' => 'Reinforced', 'label2' => 'Heel'],
                ],
                'primaryBtn'     => ['text' => 'EXPLORE ACTIVEWEAR', 'url' => route('shop.products.index')],
                'secondaryBtn'   => ['text' => 'SHOP ALL STYLES', 'url' => route('shop.products.index')],
            ],
        ];
    }

    $firstHeroSlide = $heroSlidesList[0];

    // Query 3 Latest Blogs for Homepage Editorial Section
    $latestBlogs = [];
    try {
        $latestBlogs = DB::table('blogs')
            ->join('blog_translations', 'blogs.id', '=', 'blog_translations.blog_id')
            ->where('blogs.status', 1)
            ->where('blog_translations.locale', core()->getCurrentLocale()->code ?? 'en')
            ->select(
                'blogs.id',
                'blog_translations.name',
                'blog_translations.url_key',
                'blog_translations.short_description',
                'blog_translations.category',
                'blogs.featured_image',
                'blogs.read_time',
                'blogs.published_at'
            )
            ->orderBy('blogs.published_at', 'desc')
            ->take(3)
            ->get();
    } catch (\Throwable $e) {}
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    @php
        $homeTitle = 'SOX N SOX — 100% Bamboo Socks & Diabetic Footwear India';
        $homeDesc  = 'Shop India’s softest bamboo socks for Men, Women, Kids & Diabetic care. Antibacterial, seamless toe blister protection, and moisture wicking.';
        $homeKeys  = 'bamboo socks, diabetic socks india, seamless toe socks, bamboo socks for men, gym socks for women, odor free bamboo socks, medical socks online, anti blister socks, soxnsox';
        $ogImage   = asset('images/hero-slide-1.webp');
    @endphp

    <meta name="title" content="{{ $homeTitle }}" />
    <meta name="description" content="{{ $homeDesc }}" />
    <meta name="keywords" content="{{ $homeKeys }}" />
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
    <meta name="googlebot" content="index, follow" />

    <!-- Open Graph Social Meta -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $homeTitle }}" />
    <meta property="og:description" content="{{ $homeDesc }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:image:secure_url" content="{{ $ogImage }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="SOX N SOX 100% Bamboo Socks & Diabetic Footwear India" />

    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $homeTitle }}" />
    <meta name="twitter:description" content="{{ $homeDesc }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />
    <meta name="twitter:image:alt" content="SOX N SOX 100% Bamboo Socks" />

    <!-- FAQPage Schema for Google Rich Snippets -->
    @php
        $faqSchema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => [
                [
                    '@type'          => 'Question',
                    'name'           => 'What makes bamboo socks better than regular cotton socks?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => 'Bamboo socks are naturally antibacterial (powered by "Bamboo Kun"), preventing 99.8% of foot odour. The microscopic cross-section of bamboo viscose provides 4x greater moisture absorption than cotton, keeping feet cooler, drier, and blister-free all day.',
                    ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Why are SOX N SOX diabetic socks doctor-recommended?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => 'Our diabetic socks feature wide-rib non-binding honeycomb tops that do not restrict blood circulation or leave calf indentations, 100% seamless hand-linked toes that eliminate friction sores, and terry-cushioned soles that reduce foot pressure.',
                    ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'What are seamless hand-linked toe socks?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => 'Unlike mass-produced machine socks that leave a thick, raised ridge across the toes, hand-linked seamless socks link each stitch individually by hand to create a completely flat, zero-rub seam that prevents friction blisters.',
                    ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'How do bamboo socks eliminate foot odour?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => 'Foot odour is caused by bacteria feeding on trapped sweat. Bamboo viscose draws moisture away rapidly and possesses natural bacteriostatic properties that inhibit bacteria growth, ensuring 24-hour freshness.',
                    ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'What is the delivery timeframe and return policy across India?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => 'We provide free express shipping on orders above ₹499 with delivery across all major Indian cities in 2 to 4 business days. We also offer a hassle-free 7-day easy return and replacement guarantee.',
                    ],
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Preload Hero Slide 1 and prefetch Slides 2 & 3 for instant transitions -->
    @if (!empty($heroSlidesList[0]['bgImage']))
        <link rel="preload" as="image" href="{{ $heroSlidesList[0]['bgImage'] }}" fetchpriority="high">
    @endif
    @if (!empty($heroSlidesList[1]['bgImage']))
        <link rel="prefetch" as="image" href="{{ $heroSlidesList[1]['bgImage'] }}">
    @endif
    @if (!empty($heroSlidesList[2]['bgImage']))
        <link rel="prefetch" as="image" href="{{ $heroSlidesList[2]['bgImage'] }}">
    @endif
@endpush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ 'SOX N SOX — Ultra-Soft Bamboo Socks & Diabetic Footwear' }}
    </x-slot>

    <!-- SECTION 1: SOXNSOX HERO SLIDER WITH PROPER HALF SHADE (Interactive Admin-Connected Slides) -->
    <v-soxnsox-hero-slider
        :initial-slides="{{ json_encode($heroSlidesList) }}"
        :initial-autoplay="{{ json_encode($heroAutoplay) }}"
        :initial-duration="{{ $heroDuration }}"
    >
        <!-- SSR Initial State (Slide 1): Instant high-contrast paint before Vue hydration -->
        <section class="soxnsox-hero-slider-section relative flex items-center overflow-hidden border-b border-[#133b63] text-white bg-[#133b63]" style="min-height: 580px;">
            <!-- Ambient Glowing Depth Orbs -->
            <div class="absolute -left-24 top-1/4 w-96 h-96 rounded-full bg-[#2ca7a3]/20 blur-[120px] pointer-events-none soxnsox-orb-1 z-0"></div>
            <div class="absolute right-1/4 -bottom-24 w-96 h-96 rounded-full bg-[#f28c38]/15 blur-[130px] pointer-events-none soxnsox-orb-2 z-0"></div>

            <!-- 1. Authentic Hero Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-no-repeat pointer-events-none"
                style="background-image: url('{{ $firstHeroSlide['bgImage'] }}'); background-position: right center;"
            ></div>

            <!-- 2. The Signature "Proper Half Shade" Gradient Overlay -->
            <!-- Mobile/Tablet: Solid dark overlay for maximum contrast -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#133b63] via-[#133b63]/95 to-[#133b63]/85 lg:hidden pointer-events-none"></div>

            <!-- Desktop: Precision Horizontal Half-Shade (Solid on left 36%, smoothly feathering between 36%-75%, leaving right side clear) -->
            <div
                class="absolute inset-0 hidden lg:block pointer-events-none"
                style="background: linear-gradient(90deg, #133b63 0%, #133b63 36%, rgba(19, 59, 99, 0.95) 46%, rgba(19, 59, 99, 0.60) 60%, rgba(19, 59, 99, 0.15) 74%, rgba(19, 59, 99, 0) 84%);"
            ></div>

            <!-- 3. Main Hero Content Container with Harmonious Padding & Clearance Above Bottom Bar -->
            <div class="site-container relative z-10 pt-6 sm:pt-8 lg:pt-10 pb-24 sm:pb-28 lg:pb-32 w-full">
                <div class="max-w-xl lg:max-w-2xl text-left space-y-3.5 sm:space-y-4 lg:space-y-4.5">
                    <!-- Eyebrow Tagline & Accent Line with Proper Gap -->
                    <div class="space-y-2.5">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-[#2ca7a3]/40 text-[#2ca7a3] text-[11px] font-extrabold tracking-wider uppercase shadow-sm animate-soxnsox-float" style="animation-duration: 5s;">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#2ca7a3] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#2ca7a3]"></span>
                            </span>
                            <span>{{ $firstHeroSlide['eyebrow'] }}</span>
                        </div>
                        <div class="w-12 h-[2.5px] bg-[#f28c38] rounded-full shadow-[0_0_8px_rgba(242,140,56,0.6)]"></div>
                    </div>

                    <!-- Main Headline with Clean SemiBold Weight and 1.18 Line Height -->
                    <h1 class="soxnsox-hero-headline font-display text-3xl sm:text-4xl md:text-[42px] lg:text-[46px] xl:text-[50px] leading-[1.18]">
                        {{ $firstHeroSlide['titleMain'] }}
                        <span class="soxnsox-hero-headline-highlight soxnsox-text-shimmer" style="display: block !important; margin-top: 0.25rem !important;">{{ $firstHeroSlide['titleHighlight'] }}</span>
                    </h1>

                    <!-- Paragraph Description with Generous Leading and Breathing Room -->
                    <p class="text-xs sm:text-sm lg:text-[15px] text-slate-100/90 leading-relaxed font-normal max-w-lg">
                        {{ $firstHeroSlide['description'] }}
                    </p>

                    <!-- 4 Signature Feature Badges (2x2 Balanced Grid with Zero Overflow & Generous Padding) -->
                    <div class="grid grid-cols-2 gap-2 sm:gap-2.5 max-w-md pt-0.5">
                        @foreach ($firstHeroSlide['badges'] as $bIdx => $badge)
                            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-white/[0.08] hover:bg-white/[0.15] backdrop-blur-md border border-white/15 hover:border-[#2ca7a3]/60 hover:shadow-[0_8px_20px_-4px_rgba(44,167,163,0.3)] hover:-translate-y-0.5 transition-all duration-300 group cursor-default min-w-0 overflow-hidden">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full border border-[#2ca7a3] bg-[#2ca7a3]/15 flex items-center justify-center text-[#2ca7a3] text-xs group-hover:scale-110 group-hover:bg-[#2ca7a3] group-hover:text-white transition-all flex-shrink-0 {{ $bIdx === 0 ? 'animate-soxnsox-heartbeat' : '' }}">
                                    <i class="{{ $badge['icon'] }}"></i>
                                </div>
                                <div class="min-w-0 flex-1 leading-tight">
                                    <span class="block text-[11px] font-bold text-white uppercase tracking-wider truncate">
                                        {{ $badge['label1'] }}
                                    </span>
                                    <span class="block text-[10px] font-medium text-slate-300 uppercase tracking-wide truncate">
                                        {{ $badge['label2'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- CTA Action Buttons (Sleek, Compact Proportions) -->
                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <!-- Primary Orange Solid Button -->
                        <a
                            href="{{ $firstHeroSlide['primaryBtn']['url'] }}"
                            class="soxnsox-hero-btn-orange soxnsox-btn-shimmer soxnsox-btn-glow px-5 sm:px-6 py-2.5 text-xs hover:scale-105 active:scale-95 transition-all duration-300"
                            style="background-color: #f28c38 !important; background-image: linear-gradient(135deg, #f28c38 0%, #e07a2f 100%) !important; color: #ffffff !important; border: 1px solid #f28c38 !important;"
                        >
                            <span>{{ $firstHeroSlide['primaryBtn']['text'] }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                        </a>

                        <!-- Secondary Teal Outlined Button -->
                        <a
                            href="{{ $firstHeroSlide['secondaryBtn']['url'] }}"
                            class="soxnsox-hero-btn-teal soxnsox-btn-shimmer px-5 sm:px-6 py-2.5 text-xs hover:scale-105 active:scale-95 transition-all duration-300"
                            style="background-color: transparent !important; border: 1.5px solid #2ca7a3 !important; color: #2ca7a3 !important;"
                        >
                            <span>{{ $firstHeroSlide['secondaryBtn']['text'] }}</span>
                            <i class="fa-solid fa-angles-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </v-soxnsox-hero-slider>

    <!-- SECTION 2: 4 VIBRANT COLOR-CODED CATEGORY SHOWCASES -->
    <section class="py-20 lg:py-28 bg-[#f5f7fa] border-b border-[#e5e7eb] reveal-on-scroll">
        <div class="site-container">
            <div class="mx-auto max-w-3xl text-center space-y-4 mb-16 reveal-on-scroll reveal-up">
                <span class="soxnsox-eyebrow">Curated Collections</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] soxnsox-heading-accent">
                    Engineered For Every Need &amp; Lifestyle
                </h2>
                <p class="text-sm sm:text-base text-[#6b7280] max-w-2xl mx-auto leading-relaxed">
                    Select your perfect match: therapeutic medical compression, sharp boardroom office wear, high-intensity gym performance, or playful non-slip kids socks.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 reveal-stagger">
                <!-- Category 1: Medical & Diabetic (Teal Glow) -->
                <a href="{{ route('shop.category.view', 'medical-socks') }}" class="soxnsox-category-card soxnsox-cat-glow-teal group relative rounded-3xl bg-white border border-[#2ca7a3]/30 p-6 shadow-sm hover:shadow-2xl flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 right-0 w-36 h-36 bg-[#e6f8f7] rounded-bl-full -z-0 transition-transform duration-700 ease-out group-hover:scale-135 group-hover:rotate-6"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="h-12 w-12 rounded-2xl bg-[#e6f8f7] border border-[#2ca7a3]/40 flex items-center justify-center text-xl text-[#2ca7a3] transition-all duration-300 group-hover:rotate-12 group-hover:scale-115 group-hover:bg-[#2ca7a3] group-hover:text-white shadow-sm">
                            <i class="fa-solid fa-heart-pulse transition-colors duration-300 group-hover:text-white"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold tracking-widest uppercase text-[#2ca7a3]">Doctor Recommended</span>
                            <h3 class="font-display text-xl font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors mt-0.5">
                                Medical &amp; Diabetic
                            </h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed mt-2">
                                Non-binding loose tops, extra sole padding, arch support, and circulatory protection for sensitive feet.
                            </p>
                        </div>
                    </div>
                    <div class="relative z-10 pt-6 mt-6 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#2ca7a3]">
                        <span>Shop Diabetic Care</span>
                        <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-2.5"></i>
                    </div>
                </a>

                <!-- Category 2: Men's Bamboo (Ocean Blue Glow) -->
                <a href="{{ route('shop.category.view', 'men') }}" class="soxnsox-category-card soxnsox-cat-glow-navy group relative rounded-3xl bg-white border border-[#1d5b8f]/30 p-6 shadow-sm hover:shadow-2xl flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 right-0 w-36 h-36 bg-[#e9f2fa] rounded-bl-full -z-0 transition-transform duration-700 ease-out group-hover:scale-135 group-hover:rotate-6"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="h-12 w-12 rounded-2xl bg-[#e9f2fa] border border-[#1d5b8f]/40 flex items-center justify-center text-xl text-[#1d5b8f] transition-all duration-300 group-hover:rotate-12 group-hover:scale-115 group-hover:bg-[#1d5b8f] group-hover:text-white shadow-sm">
                            <i class="fa-solid fa-user-tie transition-colors duration-300 group-hover:text-white"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold tracking-widest uppercase text-[#1d5b8f]">Formal &amp; Athletic</span>
                            <h3 class="font-display text-xl font-bold text-[#133b63] group-hover:text-[#1d5b8f] transition-colors mt-0.5">
                                Men's Collection
                            </h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed mt-2">
                                Formal office dress socks, cushioned sports ankle socks, and all-day odour-free workwear.
                            </p>
                        </div>
                    </div>
                    <div class="relative z-10 pt-6 mt-6 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#1d5b8f]">
                        <span>Shop Men's Socks</span>
                        <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-2.5"></i>
                    </div>
                </a>

                <!-- Category 3: Women's Active (Radiant Tangerine/Amber Glow) -->
                <a href="{{ route('shop.category.view', 'women') }}" class="soxnsox-category-card soxnsox-cat-glow-amber group relative rounded-3xl bg-white border border-[#f29a38]/30 p-6 shadow-sm hover:shadow-2xl flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 right-0 w-36 h-36 bg-[#fef5ea] rounded-bl-full -z-0 transition-transform duration-700 ease-out group-hover:scale-135 group-hover:rotate-6"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="h-12 w-12 rounded-2xl bg-[#fef5ea] border border-[#f29a38]/40 flex items-center justify-center text-xl text-[#f29a38] transition-all duration-300 group-hover:rotate-12 group-hover:scale-115 group-hover:bg-[#f29a38] group-hover:text-white shadow-sm">
                            <i class="fa-solid fa-person-running transition-colors duration-300 group-hover:text-white"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold tracking-widest uppercase text-[#f29a38]">Active &amp; Casual</span>
                            <h3 class="font-display text-xl font-bold text-[#133b63] group-hover:text-[#f29a38] transition-colors mt-0.5">
                                Women's Collection
                            </h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed mt-2">
                                Gym performance bamboo socks, yoga anti-slip grip soles, and lightweight feather-soft everyday pairs.
                            </p>
                        </div>
                    </div>
                    <div class="relative z-10 pt-6 mt-6 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#f29a38]">
                        <span>Shop Women's Socks</span>
                        <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-2.5"></i>
                    </div>
                </a>

                <!-- Category 4: Kids & Infant (Playful Fresh Green/Teal) -->
                <a href="{{ route('shop.category.view', 'children') }}" class="soxnsox-category-card soxnsox-cat-glow-teal group relative rounded-3xl bg-white border border-[#2ca7a3]/30 p-6 shadow-sm hover:shadow-2xl flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 right-0 w-36 h-36 bg-[#e6f8f7] rounded-bl-full -z-0 transition-transform duration-700 ease-out group-hover:scale-135 group-hover:rotate-6"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="h-12 w-12 rounded-2xl bg-[#e6f8f7] border border-[#2ca7a3]/40 flex items-center justify-center text-xl text-[#2ca7a3] transition-all duration-300 group-hover:rotate-12 group-hover:scale-115 group-hover:bg-[#2ca7a3] group-hover:text-white shadow-sm">
                            <i class="fa-solid fa-baby transition-colors duration-300 group-hover:text-white"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold tracking-widest uppercase text-[#2ca7a3]">Gentle Skin &amp; Grip</span>
                            <h3 class="font-display text-xl font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors mt-0.5">
                                Kids &amp; Infants
                            </h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed mt-2">
                                Non-slip silicone dotted soles for safe active steps, seamless construction for zero sensory irritation.
                            </p>
                        </div>
                    </div>
                    <div class="relative z-10 pt-6 mt-6 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#2ca7a3]">
                        <span>Shop Kids Socks</span>
                        <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-2.5"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 3: SHOP MEDICAL SOCKS (Dedicated Therapeutic Lines with Real Photography) -->
    <section id="medical-socks" class="py-20 lg:py-28 bg-[#f8fafc] border-b border-[#e5e7eb] reveal-on-scroll">
        <div class="site-container">
            <div class="mx-auto max-w-3xl text-center mb-14 lg:mb-16 reveal-on-scroll reveal-up">
                <div class="mb-3">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#e6f8f7] border border-[#2ca7a3]/30 text-[#2ca7a3] text-[11px] font-extrabold tracking-[0.2em] uppercase shadow-xs">
                        <span class="h-2 w-2 rounded-full bg-[#2ca7a3] animate-pulse"></span>
                        Therapeutic &amp; Clinical Line
                    </span>
                </div>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] soxnsox-heading-accent block">
                    Shop Medical Socks
                </h2>
                <p class="mt-4 text-sm sm:text-base text-[#6b7280] max-w-2xl mx-auto leading-relaxed">
                    Comfort-focused medical support socks designed for everyday relief and stability. Engineered with graduated pressure, targeted heel cushioning, and non-slip safety treads.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 reveal-stagger">
                <!-- Medical Card 1: Compression Socks -->
                <a
                    href="{{ route('shop.product_or_category.index', 'medical-socks') }}"
                    class="soxnsox-category-card group relative rounded-3xl bg-white border border-slate-200/80 p-4 sm:p-5 flex flex-col justify-between hover:border-[#2ca7a3] hover:shadow-[0_24px_50px_-10px_rgba(44,167,163,0.25)] hover:-translate-y-2.5 transition-all duration-500 overflow-hidden soxnsox-medical-card-teal"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#2ca7a3] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="space-y-4">
                        <div class="soxnsox-image-shimmer soxnsox-medical-img-wrapper relative overflow-hidden rounded-2xl aspect-square flex items-center justify-center p-2 sm:p-2.5 transition-all duration-500">
                            <img
                                src="{{ asset('images/brand/ce37a673-a4ef-491a-823a-51d686f535b6.webp') }}"
                                alt="Compression Socks"
                                class="w-full h-full object-contain rounded-xl filter drop-shadow-[0_4px_10px_rgba(19,59,99,0.06)] group-hover:scale-105 group-hover:-translate-y-0.5 transition-all duration-500"
                                loading="lazy"
                            />
                            <div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#133b63] shadow-sm border border-slate-200/70">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#2ca7a3] opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#2ca7a3]"></span>
                                </span>
                                Circulation
                            </div>
                            <span class="absolute top-3 right-3 w-7 h-7 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-[#2ca7a3] text-xs shadow-sm border border-slate-200/60 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all duration-300">
                                <i class="fa-solid fa-heart-pulse"></i>
                            </span>
                        </div>

                        <div class="space-y-1.5">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-[#2ca7a3] block">Clinical Line</span>
                            <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63] soxnsox-medical-heading transition-colors leading-snug">
                                Compression Socks
                            </h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed">
                                Improves circulation &amp; reduces swelling during long shifts, travel, and recovery.
                            </p>
                            <div class="flex flex-wrap items-center gap-1.5 pt-2">
                                <span class="px-2 py-0.5 rounded-md bg-[#e6f8f7] text-[#1e7874] text-[10px] font-bold">15-20 mmHg</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-semibold">Graduated Calf</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#133b63] transition-colors">
                        <span class="tracking-wide soxnsox-medical-link transition-colors">Explore Socks</span>
                        <span class="w-7 h-7 rounded-full bg-slate-100 group-hover:bg-[#2ca7a3] group-hover:text-white flex items-center justify-center text-[10px] text-slate-600 transition-all duration-300 shadow-sm group-hover:translate-x-1.5 soxnsox-card-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <!-- Medical Card 2: Plantar Fasciitis Socks -->
                <a
                    href="{{ route('shop.product_or_category.index', 'medical-socks') }}"
                    class="soxnsox-category-card group relative rounded-3xl bg-white border border-slate-200/80 p-4 sm:p-5 flex flex-col justify-between hover:border-[#2ca7a3] hover:shadow-[0_24px_50px_-10px_rgba(44,167,163,0.25)] hover:-translate-y-2.5 transition-all duration-500 overflow-hidden soxnsox-medical-card-teal"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#2ca7a3] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="space-y-4">
                        <div class="soxnsox-image-shimmer soxnsox-medical-img-wrapper relative overflow-hidden rounded-2xl aspect-square flex items-center justify-center p-2 sm:p-2.5 transition-all duration-500">
                            <img
                                src="{{ asset('images/home/a758b39f-0ce5-42fd-baaa-73d6dcb36a80.webp') }}"
                                alt="Plantar Fasciitis Socks"
                                class="w-full h-full object-contain rounded-xl filter drop-shadow-[0_4px_10px_rgba(19,59,99,0.06)] group-hover:scale-105 group-hover:-translate-y-0.5 transition-all duration-500"
                                loading="lazy"
                            />
                            <div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#133b63] shadow-sm border border-slate-200/70">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#2ca7a3] opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#2ca7a3]"></span>
                                </span>
                                Arch Support
                            </div>
                            <span class="absolute top-3 right-3 w-7 h-7 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-[#2ca7a3] text-xs shadow-sm border border-slate-200/60 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all duration-300">
                                <i class="fa-solid fa-bone"></i>
                            </span>
                        </div>

                        <div class="space-y-1.5">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-[#2ca7a3] block">Targeted Relief</span>
                            <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63] soxnsox-medical-heading transition-colors leading-snug">
                                Plantar Fasciitis Socks
                            </h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed">
                                Targeted heel &amp; arch support to relieve morning foot pain and plantar strain.
                            </p>
                            <div class="flex flex-wrap items-center gap-1.5 pt-2">
                                <span class="px-2 py-0.5 rounded-md bg-[#e6f8f7] text-[#1e7874] text-[10px] font-bold">Fascia Relief</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-semibold">Targeted Heel</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#133b63] transition-colors">
                        <span class="tracking-wide soxnsox-medical-link transition-colors">Explore Socks</span>
                        <span class="w-7 h-7 rounded-full bg-slate-100 group-hover:bg-[#2ca7a3] group-hover:text-white flex items-center justify-center text-[10px] text-slate-600 transition-all duration-300 shadow-sm group-hover:translate-x-1.5 soxnsox-card-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <!-- Medical Card 3: Grip / Anti-Slip Socks -->
                <a
                    href="{{ route('shop.product_or_category.index', 'medical-socks') }}"
                    class="soxnsox-category-card group relative rounded-3xl bg-white border border-slate-200/80 p-4 sm:p-5 flex flex-col justify-between hover:border-[#f29a38] hover:shadow-[0_24px_50px_-10px_rgba(242,154,56,0.25)] hover:-translate-y-2.5 transition-all duration-500 overflow-hidden soxnsox-medical-card-amber"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#f29a38] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="space-y-4">
                        <div class="soxnsox-image-shimmer soxnsox-medical-img-wrapper relative overflow-hidden rounded-2xl aspect-square flex items-center justify-center p-2 sm:p-2.5 transition-all duration-500">
                            <img
                                src="{{ asset('images/home/da365f9e-9ea5-4cfe-9d2e-5ea595632c8f.webp') }}"
                                alt="Grip & Anti-Slip Socks"
                                class="w-full h-full object-contain rounded-xl filter drop-shadow-[0_4px_10px_rgba(19,59,99,0.06)] group-hover:scale-105 group-hover:-translate-y-0.5 transition-all duration-500"
                                loading="lazy"
                            />
                            <div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#133b63] shadow-sm border border-slate-200/70">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#f29a38] opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#f29a38]"></span>
                                </span>
                                Anti-Slip Tread
                            </div>
                            <span class="absolute top-3 right-3 w-7 h-7 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-[#f29a38] text-xs shadow-sm border border-slate-200/60 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all duration-300">
                                <i class="fa-solid fa-shoe-prints"></i>
                            </span>
                        </div>

                        <div class="space-y-1.5">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-[#f29a38] block">Silicone Safety</span>
                            <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63] soxnsox-medical-heading transition-colors leading-snug">
                                Grip / Anti-Slip Socks
                            </h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed">
                                Enhanced stability &amp; safety on tiled floors with medical-grade silicone grip dots.
                            </p>
                            <div class="flex flex-wrap items-center gap-1.5 pt-2">
                                <span class="px-2 py-0.5 rounded-md bg-[#fef3e9] text-[#d97321] text-[10px] font-bold">Silicone Dots</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-semibold">Hospital Grade</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#133b63] transition-colors">
                        <span class="tracking-wide soxnsox-medical-link transition-colors">Explore Socks</span>
                        <span class="w-7 h-7 rounded-full bg-slate-100 group-hover:bg-[#f29a38] group-hover:text-white flex items-center justify-center text-[10px] text-slate-600 transition-all duration-300 shadow-sm group-hover:translate-x-1.5 soxnsox-card-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <!-- Medical Card 4: Running / Performance Socks -->
                <a
                    href="{{ route('shop.products.index') }}"
                    class="soxnsox-category-card group relative rounded-3xl bg-white border border-slate-200/80 p-4 sm:p-5 flex flex-col justify-between hover:border-[#1d5b8f] hover:shadow-[0_24px_50px_-10px_rgba(29,91,143,0.25)] hover:-translate-y-2.5 transition-all duration-500 overflow-hidden soxnsox-medical-card-navy"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#1d5b8f] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="space-y-4">
                        <div class="soxnsox-image-shimmer soxnsox-medical-img-wrapper relative overflow-hidden rounded-2xl aspect-square flex items-center justify-center p-2 sm:p-2.5 transition-all duration-500">
                            <img
                                src="{{ asset('images/brand/4362e1c9-c29f-43b1-85d9-ca178d3166ca.webp') }}"
                                alt="Running & Performance Socks"
                                class="w-full h-full object-contain rounded-xl filter drop-shadow-[0_4px_10px_rgba(19,59,99,0.06)] group-hover:scale-105 group-hover:-translate-y-0.5 transition-all duration-500"
                                loading="lazy"
                            />
                            <div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#133b63] shadow-sm border border-slate-200/70">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1d5b8f] opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1d5b8f]"></span>
                                </span>
                                Performance
                            </div>
                            <span class="absolute top-3 right-3 w-7 h-7 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-[#1d5b8f] text-xs shadow-sm border border-slate-200/60 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all duration-300">
                                <i class="fa-solid fa-bolt"></i>
                            </span>
                        </div>

                        <div class="space-y-1.5">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-[#1d5b8f] block">Active Care</span>
                            <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63] soxnsox-medical-heading transition-colors leading-snug">
                                Running / Performance
                            </h3>
                            <p class="text-xs text-[#6b7280] leading-relaxed">
                                Breathable &amp; moisture-wicking design with high-density midfoot cushioning.
                            </p>
                            <div class="flex flex-wrap items-center gap-1.5 pt-2">
                                <span class="px-2 py-0.5 rounded-md bg-[#eaf2f9] text-[#133b63] text-[10px] font-bold">3X Wicking</span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-semibold">Shock Absorb</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#133b63] transition-colors">
                        <span class="tracking-wide soxnsox-medical-link transition-colors">Explore Socks</span>
                        <span class="w-7 h-7 rounded-full bg-slate-100 group-hover:bg-[#1d5b8f] group-hover:text-white flex items-center justify-center text-[10px] text-slate-600 transition-all duration-300 shadow-sm group-hover:translate-x-1.5 soxnsox-card-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 4: EVERYDAY COMFORT SOCKS BANNER (From Old Website Section 4, 6 & 7) -->
    <section class="relative py-20 lg:py-28 overflow-hidden bg-[#133b63] text-white border-b border-[#103254] reveal-on-scroll" style="padding-top: 5.5rem; padding-bottom: 5.5rem;">
        <!-- Full-Width Authentic Background Image with Layered Gradient (Horizontally Reversed) -->
        <div
            class="absolute inset-0 bg-cover bg-bottom pointer-events-none opacity-45 mix-blend-luminosity"
            style="background-image: url('{{ asset('images/brand/8aee6b0e-068c-4320-b405-c7061cea546d.webp') }}'); background-position: center bottom; transform: scaleX(-1); -webkit-transform: scaleX(-1);"
        ></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#133b63] via-[#133b63]/90 to-[#133b63]/40 pointer-events-none"></div>

        <div class="site-container relative z-10">
            <div class="max-w-2xl space-y-6 reveal-on-scroll reveal-up">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-[#2ca7a3]/40 text-[#2ca7a3] text-xs font-bold uppercase tracking-widest shadow-sm animate-soxnsox-float" style="animation-duration: 5s;">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#2ca7a3] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#2ca7a3]"></span>
                    </span>
                    <span>EVERYDAY COMFORT SOCKS</span>
                </div>

                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight soxnsox-heading-accent soxnsox-heading-accent-left text-left" style="line-height: 1.2 !important;">
                    Comfort That Supports Every Step You Take.
                </h2>

                <p class="text-base sm:text-lg text-slate-200 leading-relaxed font-normal">
                    Designed for work, travel, movement, and everyday routines with breathable comfort and reliable support. SOX N SOX creates premium socks engineered to deliver lasting softness, breathability, and durability throughout your day.
                </p>

                <!-- 4 Quick Benefit Pills -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2 reveal-stagger">
                    <div class="flex items-center justify-center gap-2.5 px-3 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 text-center transition-all duration-300 hover:scale-105 hover:-translate-y-1 hover:border-[#2ca7a3]/50" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fa-solid fa-leaf text-[#2ca7a3] text-sm shrink-0"></i>
                        <span class="text-xs font-bold text-white whitespace-nowrap">100% Bamboo</span>
                    </div>
                    <div class="flex items-center justify-center gap-2.5 px-3 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 text-center transition-all duration-300 hover:scale-105 hover:-translate-y-1 hover:border-[#2ca7a3]/50" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fa-solid fa-shield-halved text-[#2ca7a3] text-sm shrink-0"></i>
                        <span class="text-xs font-bold text-white whitespace-nowrap">Seamless Toe</span>
                    </div>
                    <div class="flex items-center justify-center gap-2.5 px-3 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 text-center transition-all duration-300 hover:scale-105 hover:-translate-y-1 hover:border-[#2ca7a3]/50" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fa-solid fa-droplet text-[#2ca7a3] text-sm shrink-0"></i>
                        <span class="text-xs font-bold text-white whitespace-nowrap">3X Wicking</span>
                    </div>
                    <div class="flex items-center justify-center gap-2.5 px-3 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 text-center transition-all duration-300 hover:scale-105 hover:-translate-y-1 hover:border-[#2ca7a3]/50" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fa-solid fa-feather text-[#2ca7a3] text-sm shrink-0"></i>
                        <span class="text-xs font-bold text-white whitespace-nowrap">Non-Binding</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4 pt-4">
                    <a
                        href="{{ route('shop.products.index') }}"
                        class="soxnsox-hero-btn-orange soxnsox-btn-shimmer soxnsox-btn-glow px-6 py-3 text-xs hover:scale-105 active:scale-95 transition-all duration-300"
                        style="background-color: #f28c38 !important; color: #ffffff !important; border: 1px solid #f28c38 !important;"
                    >
                        <span>Shop Everyday Comfort</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                    </a>
                    <a
                        href="{{ url('/why-choose-us') }}"
                        class="soxnsox-btn-shimmer px-6 py-3 text-xs rounded-full font-bold uppercase tracking-wider text-white border border-white/40 hover:bg-white/10 hover:scale-105 active:scale-95 transition-all duration-300 inline-flex items-center gap-2"
                    >
                        <span>Why Choose Us</span>
                        <i class="fa-solid fa-angles-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: FEATURED SOCKS CATALOG (THE 12 PRODUCTS) -->
    <section id="products" class="py-20 lg:py-28 bg-[#f5f7fa] border-b border-[#e5e7eb] reveal-on-scroll">
        <div class="site-container">
            <!-- Header Strip -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14 reveal-on-scroll reveal-up">
                <div class="space-y-3">
                    <div class="mb-2">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#e6f8f7] border border-[#2ca7a3]/30 text-[#2ca7a3] text-[11px] font-extrabold tracking-[0.2em] uppercase shadow-xs">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#2ca7a3] animate-pulse"></span>
                            Direct From Mill
                        </span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] soxnsox-heading-accent soxnsox-heading-accent-left text-left block">
                        Featured Bamboo Socks
                    </h2>
                    <p class="text-xs sm:text-sm text-[#6b7280] max-w-lg leading-relaxed">
                        Handcrafted with certified bamboo. Available in multi-packs of 4, 6, and 12 pairs with free delivery across India.
                    </p>
                </div>

                <a
                    href="{{ route('shop.product_or_category.index', 'products') }}"
                    class="soxnsox-btn-outline soxnsox-btn-shimmer self-start md:self-auto !px-7 !py-3 text-xs inline-flex items-center gap-1.5 hover:scale-105 active:scale-95 transition-all duration-300"
                >
                    <span>View All Socks</span>
                    <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1.5"></i>
                </a>
            </div>

            <!-- Product Showcase Grid -->
            @if ($featuredProducts->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 reveal-stagger">
                    @foreach ($featuredProducts as $product)
                        <x-shop::products.card :product="$product" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- SECTION 6: ADVANCED MATERIAL & LIFESTYLE SHOWCASE (From Old Website Section 8 & 9) -->
    <section class="py-20 lg:py-28 bg-white border-b border-[#e5e7eb] overflow-hidden reveal-on-scroll">
        <div class="site-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Left Column: Copy & Benefits -->
                <div class="lg:col-span-7 space-y-6 reveal-on-scroll reveal-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#e6f8f7] border border-[#2ca7a3]/40 text-[#2ca7a3] text-xs font-bold uppercase tracking-widest shadow-sm">
                        <i class="fa-solid fa-dna text-xs"></i>
                        <span>ADVANCED MATERIAL</span>
                    </div>

                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] leading-tight soxnsox-heading-accent soxnsox-heading-accent-left text-left block">
                        Breathable Fabric For Everyday Comfort.
                    </h2>

                    <div class="space-y-2 pt-1">
                        <p class="font-display text-lg sm:text-xl font-bold text-[#133b63]">
                            "Move Better. Feel Better. Live Better."
                        </p>
                        <p class="text-sm sm:text-base text-[#6b7280] leading-relaxed">
                            Crafted with lightweight breathable fabrics that help keep your feet feeling fresh, soft, and comfortable all day long. Comfort-focused socks designed to support your everyday lifestyle with softness, flexibility, and modern performance.
                        </p>
                    </div>

                    <!-- 3 Feature Highlights -->
                    <div class="space-y-4 pt-2 reveal-stagger">
                        <div class="group flex items-start gap-4 p-4 rounded-2xl bg-[#f5f7fa] hover:bg-white border border-slate-200 hover:border-[#2ca7a3]/40 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="w-10 h-10 rounded-xl bg-[#2ca7a3]/10 text-[#2ca7a3] flex items-center justify-center text-lg shrink-0 group-hover:scale-110 group-hover:bg-[#2ca7a3] group-hover:text-white transition-all duration-300">
                                <i class="fa-solid fa-wind"></i>
                            </div>
                            <div>
                                <h4 class="font-display text-sm font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors">Thermoregulating Fiber</h4>
                                <p class="text-xs text-[#6b7280] leading-relaxed mt-0.5">Naturally adapts to heat: keeps skin up to 3°C cooler in scorching summer weather and warmly insulated in winter.</p>
                            </div>
                        </div>

                        <div class="group flex items-start gap-4 p-4 rounded-2xl bg-[#f5f7fa] hover:bg-white border border-slate-200 hover:border-[#2ca7a3]/40 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="w-10 h-10 rounded-xl bg-[#2ca7a3]/10 text-[#2ca7a3] flex items-center justify-center text-lg shrink-0 group-hover:scale-110 group-hover:bg-[#2ca7a3] group-hover:text-white transition-all duration-300">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <h4 class="font-display text-sm font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors">Bamboo Kun Antimicrobial Defense</h4>
                                <p class="text-xs text-[#6b7280] leading-relaxed mt-0.5">Natural bio-agents permanently embedded in bamboo eliminate 99.8% of foot odor-causing bacteria.</p>
                            </div>
                        </div>

                        <div class="group flex items-start gap-4 p-4 rounded-2xl bg-[#f5f7fa] hover:bg-white border border-slate-200 hover:border-[#2ca7a3]/40 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="w-10 h-10 rounded-xl bg-[#2ca7a3]/10 text-[#2ca7a3] flex items-center justify-center text-lg shrink-0 group-hover:scale-110 group-hover:bg-[#2ca7a3] group-hover:text-white transition-all duration-300">
                                <i class="fa-solid fa-droplet"></i>
                            </div>
                            <div>
                                <h4 class="font-display text-sm font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors">3X Faster Sweat Evaporation</h4>
                                <p class="text-xs text-[#6b7280] leading-relaxed mt-0.5">Micro-gap capillary structure pulls moisture away from the skin immediately, guaranteeing dry, blister-free steps.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a
                            href="{{ route('shop.products.index') }}"
                            class="soxnsox-hero-btn-orange soxnsox-btn-shimmer soxnsox-btn-glow px-6 py-3 text-xs hover:scale-105 active:scale-95 transition-all duration-300"
                            style="background-color: #f28c38 !important; color: #ffffff !important; border: 1px solid #f28c38 !important;"
                        >
                            <span>Shop Collection</span>
                            <i class="fa-solid fa-arrow-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                        </a>
                        <a
                            href="{{ url('/how-it-works') }}"
                            class="soxnsox-btn-outline soxnsox-btn-shimmer px-6 py-3 text-xs hover:scale-105 active:scale-95 transition-all duration-300"
                        >
                            <span>See How It Works</span>
                            <i class="fa-solid fa-arrow-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Visual Photo Card with Floating Badges -->
                <div class="lg:col-span-5 relative reveal-on-scroll reveal-right">
                    <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-white group">
                        <img
                            src="{{ asset('images/home/c5a9e8e8-80fe-4811-8d2e-7a40b46ca5c0.webp') }}"
                            alt="SOX N SOX Move Better Feel Better Live Better"
                            class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                            loading="lazy"
                        />
                    </div>

                    <!-- Floating Feature Card: positioned under the image with slight overlap over the bottom edge -->
                    <div style="margin-top: -52px;" class="relative mx-4 sm:mx-6 z-10 bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-4.5 shadow-xl border border-slate-200/90 transition-all duration-300 ease-out hover:shadow-2xl hover:-translate-y-1.5 hover:border-[#2ca7a3]/50 hover:ring-2 hover:ring-[#2ca7a3]/20 group/card cursor-default text-center">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-[#2ca7a3] block transition-colors duration-300 group-hover/card:text-[#2ca7a3]">Engineered In India</span>
                        <span class="text-xs sm:text-sm font-bold text-[#133b63] block mt-0.5 transition-colors duration-300 group-hover/card:text-[#2ca7a3]">Precision Comfort for Active Everyday Life</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 7: THE 4 CORE COMFORT PILLARS (From Old Website Section 11 & Material Science) -->
    <section id="why-bamboo" class="py-20 lg:py-28 bg-[#f5f7fa] border-b border-[#e5e7eb] reveal-on-scroll">
        <div class="site-container">
            <div class="mx-auto max-w-3xl text-center space-y-4 mb-16 reveal-on-scroll reveal-up">
                <span class="soxnsox-eyebrow">The Science of Foot Health</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] soxnsox-heading-accent">
                    4 Core Pillars of Everyday Foot Comfort
                </h2>
                <p class="text-sm sm:text-base text-[#6b7280] max-w-2xl mx-auto leading-relaxed">
                    We focus on creating premium socks that combine all-day comfort, durability, breathability, and modern everyday style for every walk of life.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 reveal-stagger">
                <!-- Pillar 1: All-Day Comfort -->
                <div class="soxnsox-category-card group p-8 rounded-3xl bg-white border border-[#e5e7eb] shadow-sm hover:border-[#2ca7a3] hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center text-xl font-bold transition-transform duration-300 group-hover:rotate-12 group-hover:scale-115">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors">All-Day Comfort</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Tested for safety and durability with cushioned heel and sole padding that absorbs shock on hard city floors.
                    </p>
                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#2ca7a3]">Tested For Longevity</span>
                </div>

                <!-- Pillar 2: Breathable Materials -->
                <div class="soxnsox-category-card group p-8 rounded-3xl bg-white border border-[#e5e7eb] shadow-sm hover:border-[#2ca7a3] hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#e6f8f7] text-[#2ca7a3] flex items-center justify-center text-xl font-bold transition-transform duration-300 group-hover:rotate-12 group-hover:scale-115">
                        <i class="fa-solid fa-wind"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors">Breathable Materials</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Micro-gap bamboo fibers keep your feet dry and cool, allowing constant air circulation and preventing perspiration.
                    </p>
                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#2ca7a3]">Keeps Feet Dry</span>
                </div>

                <!-- Pillar 3: Supportive Fit -->
                <div class="soxnsox-category-card group p-8 rounded-3xl bg-white border border-[#e5e7eb] shadow-sm hover:border-[#f29a38] hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#fef5ea] text-[#f29a38] flex items-center justify-center text-xl font-bold transition-transform duration-300 group-hover:rotate-12 group-hover:scale-115">
                        <i class="fa-solid fa-shoe-prints"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold text-[#133b63] group-hover:text-[#f29a38] transition-colors">Supportive Fit</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Anatomical midfoot arch band improves circulation and actively reduces leg strain from standing or walking.
                    </p>
                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#f29a38]">Reduces Fatigue</span>
                </div>

                <!-- Pillar 4: Designed For Everyday Life -->
                <div class="soxnsox-category-card group p-8 rounded-3xl bg-white border border-[#e5e7eb] shadow-sm hover:border-[#1d5b8f] hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#e9f2fa] text-[#1d5b8f] flex items-center justify-center text-xl font-bold transition-transform duration-300 group-hover:rotate-12 group-hover:scale-115">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold text-[#133b63] group-hover:text-[#1d5b8f] transition-colors">Everyday Reliability</h3>
                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed">
                        Hand-linked seamless toes eliminate blisters, and non-binding cuffs keep socks gently in place without marks.
                    </p>
                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#1d5b8f]">Zero Blisters</span>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 8: SPECIALIZED MEDICAL & DIABETIC FOOTCARE SHOWCASE -->
    <section id="medical-features" class="py-20 lg:py-28 bg-gradient-to-br from-[#133b63] via-[#103254] to-[#0c243d] text-white border-b border-white/10 relative overflow-hidden reveal-on-scroll">
        <div class="absolute -right-32 top-1/2 w-96 h-96 rounded-full bg-[#2ca7a3]/20 blur-[100px] pointer-events-none animate-soxnsox-pulse-glow"></div>

        <div class="site-container relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Left: Educational Content -->
                <div class="lg:col-span-6 space-y-6 reveal-on-scroll reveal-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#2ca7a3]/20 border border-[#2ca7a3]/40 text-[#2ca7a3] text-xs font-bold uppercase tracking-widest shadow-sm">
                        <i class="fa-solid fa-shield-halved text-xs text-[#2ca7a3]"></i>
                        <span>Podiatrist &amp; Doctor Approved</span>
                    </div>

                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white soxnsox-heading-accent soxnsox-heading-accent-left text-left block">
                        Engineered Protection For Diabetic &amp; Sensitive Feet.
                    </h2>

                    <p class="text-sm sm:text-base text-[#f5f7fa]/85 leading-relaxed">
                        Traditional elastic socks restrict blood circulation and cause deep indentations on diabetic legs. SOX N SOX medical socks are engineered with loose non-binding cuffs, reinforced terry cushions, and friction-less toe seams to promote healthy circulation.
                    </p>

                    <!-- Medical Features Check-List -->
                    <div class="space-y-4 pt-2 reveal-stagger">
                        <div class="group flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#2ca7a3]/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#2ca7a3] text-white text-xs shadow-sm group-hover:scale-115 group-hover:bg-[#4ddcd7] group-hover:text-[#133b63] transition-all duration-300">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <div>
                                <h4 class="font-display text-sm font-bold text-white group-hover:text-[#4ddcd7] transition-colors">Non-Binding Extra-Wide Top</h4>
                                <p class="text-xs text-[#f5f7fa]/75 mt-0.5">Allows unrestricted blood flow without rolling down or squeezing ankles.</p>
                            </div>
                        </div>

                        <div class="group flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#2ca7a3]/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#2ca7a3] text-white text-xs shadow-sm group-hover:scale-115 group-hover:bg-[#4ddcd7] group-hover:text-[#133b63] transition-all duration-300">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <div>
                                <h4 class="font-display text-sm font-bold text-white group-hover:text-[#4ddcd7] transition-colors">Full Terry Footbed Cushioning</h4>
                                <p class="text-xs text-[#f5f7fa]/75 mt-0.5">Absorbs shock, protecting the heel and metatarsal bones from pressure sores.</p>
                            </div>
                        </div>

                        <div class="group flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#2ca7a3]/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#2ca7a3] text-white text-xs shadow-sm group-hover:scale-115 group-hover:bg-[#4ddcd7] group-hover:text-[#133b63] transition-all duration-300">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <div>
                                <h4 class="font-display text-sm font-bold text-white group-hover:text-[#4ddcd7] transition-colors">Zero Blister Flat Seam</h4>
                                <p class="text-xs text-[#f5f7fa]/75 mt-0.5">Completely flat toe seam prevents abrasions and ulcers critical in neuropathy.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <a
                            href="{{ route('shop.product_or_category.index', 'medical-socks') }}"
                            class="soxnsox-hero-btn-orange soxnsox-btn-shimmer soxnsox-btn-glow !px-8 !py-4 text-xs tracking-widest inline-flex items-center gap-2 hover:scale-105 active:scale-95 transition-all duration-300"
                            style="background-color: #f28c38 !important; color: #ffffff !important; border: 1px solid #f28c38 !important;"
                        >
                            <span>Shop Medical Socks Now</span>
                            <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1.5"></i>
                        </a>
                    </div>
                </div>

                <!-- Right: Comparison Box (SOX N SOX vs Regular Socks) -->
                <div class="lg:col-span-6 reveal-on-scroll reveal-scale">
                    <div class="soxnsox-category-card rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 hover:border-[#2ca7a3]/60 p-6 sm:p-8 shadow-2xl space-y-6 hover:shadow-[0_25px_60px_-15px_rgba(44,167,163,0.3)] transition-all duration-500">
                        <h3 class="font-display text-xl font-bold text-white text-center pb-2 border-b border-white/15">
                            Why Make The Switch?
                        </h3>

                        <div class="space-y-4 text-xs sm:text-sm">
                            <div class="grid grid-cols-2 gap-4 pb-3 border-b border-white/10">
                                <div class="text-[#2ca7a3] font-bold">SOX N SOX Bamboo</div>
                                <div class="text-[#f5f7fa]/50 font-bold">Standard Cotton Socks</div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-2 text-white font-semibold">
                                    <i class="fa-solid fa-circle-check text-[#2ca7a3] text-sm shrink-0"></i>
                                    <span>Bamboo Kun (Zero Odour)</span>
                                </div>
                                <div class="flex items-center gap-2 text-[#f5f7fa]/60">
                                    <i class="fa-solid fa-circle-xmark text-red-400 text-sm shrink-0"></i>
                                    <span>Traps sweat &amp; bacteria</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-2 text-white font-semibold">
                                    <i class="fa-solid fa-circle-check text-[#2ca7a3] text-sm shrink-0"></i>
                                    <span>Hand-Linked Seamless Toe</span>
                                </div>
                                <div class="flex items-center gap-2 text-[#f5f7fa]/60">
                                    <i class="fa-solid fa-circle-xmark text-red-400 text-sm shrink-0"></i>
                                    <span>Bulky ridge rubs toes</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-2 text-white font-semibold">
                                    <i class="fa-solid fa-circle-check text-[#2ca7a3] text-sm shrink-0"></i>
                                    <span>Circulation-Safe Loose Cuff</span>
                                </div>
                                <div class="flex items-center gap-2 text-[#f5f7fa]/60">
                                    <i class="fa-solid fa-circle-xmark text-red-400 text-sm shrink-0"></i>
                                    <span>Tight elastic leaves marks</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-2 text-white font-semibold">
                                    <i class="fa-solid fa-circle-check text-[#2ca7a3] text-sm shrink-0"></i>
                                    <span>3X Faster Moisture Evaporation</span>
                                </div>
                                <div class="flex items-center gap-2 text-[#f5f7fa]/60">
                                    <i class="fa-solid fa-circle-xmark text-red-400 text-sm shrink-0"></i>
                                    <span>Becomes damp &amp; cold</span>
                                </div>
                            </div>
                        </div>

                        <div class="soxnsox-btn-shimmer p-4 rounded-2xl bg-[#f29a38]/20 border border-[#f29a38]/40 text-center text-xs font-semibold text-[#f29a38] flex items-center justify-center gap-2">
                            <i class="fa-solid fa-star text-sm animate-pulse"></i>
                            <span>Over 12,000+ Diabetic Patients Trust SOX N SOX Daily</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 9: WHY CUSTOMERS CHOOSE SOX N SOX (From Old Website Section 12) -->
    <section class="relative py-20 lg:py-28 bg-[#133b63] text-white border-b border-[#103254] overflow-hidden reveal-on-scroll" style="padding-top: 5.5rem; padding-bottom: 5.5rem;">
        <!-- Full-Width Background Photography from Old Site -->
        <div
            class="absolute inset-0 bg-cover pointer-events-none opacity-85"
            style="background-image: url('{{ asset('images/brand/72081381-b4ff-4097-9f1e-59db98d2feff.webp') }}'); background-position: center 35%;"
        ></div>
        <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(180deg, rgba(15, 43, 73, 0.45) 0%, rgba(15, 43, 73, 0.28) 45%, rgba(15, 43, 73, 0.58) 100%);"></div>

        <div class="site-container relative z-10">
            <div class="mx-auto max-w-3xl text-center space-y-4 mb-12 reveal-on-scroll reveal-up">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-[#2ca7a3]/40 text-[#2ca7a3] text-xs font-bold uppercase tracking-widest shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-[#2ca7a3] animate-pulse"></span>
                    <span>Our Brand Commitment</span>
                </div>

                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight soxnsox-heading-accent" style="line-height: 1.2 !important; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);">
                    Why Customers Choose <br>
                    <span class="whitespace-nowrap">SOX N SOX</span>
                </h2>
                <p class="text-sm sm:text-base text-slate-100 max-w-2xl mx-auto leading-relaxed" style="text-shadow: 0 1px 6px rgba(0, 0, 0, 0.6);">
                    We focus on creating premium socks that combine comfort, durability, breathability, and modern everyday style for every lifestyle.
                </p>
            </div>

            <!-- 4 Proof Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 reveal-stagger">
                <div class="soxnsox-stat-card group p-6 rounded-3xl border border-white/20 hover:border-[#2ca7a3]/60 text-center space-y-2 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" style="background: rgba(15, 43, 73, 0.65); backdrop-filter: blur(12px);">
                    <span class="font-display text-3xl sm:text-4xl font-extrabold text-[#2ca7a3] block soxnsox-stat-num transition-transform duration-300 group-hover:scale-110">12,000+</span>
                    <span class="text-xs font-bold text-white uppercase tracking-wider block">Happy Walkers</span>
                    <p class="text-[11px] text-slate-300">Trusted across India for work and sensitive care</p>
                </div>

                <div class="soxnsox-stat-card group p-6 rounded-3xl border border-white/20 hover:border-[#2ca7a3]/60 text-center space-y-2 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" style="background: rgba(15, 43, 73, 0.65); backdrop-filter: blur(12px);">
                    <span class="font-display text-3xl sm:text-4xl font-extrabold text-[#2ca7a3] block soxnsox-stat-num transition-transform duration-300 group-hover:scale-110">200N</span>
                    <span class="text-xs font-bold text-white uppercase tracking-wider block">High-Density Knit</span>
                    <p class="text-[11px] text-slate-300">Fine needle count for silky softness and durability</p>
                </div>

                <div class="soxnsox-stat-card group p-6 rounded-3xl border border-white/20 hover:border-[#2ca7a3]/60 text-center space-y-2 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" style="background: rgba(15, 43, 73, 0.65); backdrop-filter: blur(12px);">
                    <span class="font-display text-3xl sm:text-4xl font-extrabold text-[#2ca7a3] block soxnsox-stat-num transition-transform duration-300 group-hover:scale-110">0%</span>
                    <span class="text-xs font-bold text-white uppercase tracking-wider block">Seam Irritation</span>
                    <p class="text-[11px] text-slate-300">Hand-linked flat toe closure with zero friction</p>
                </div>

                <div class="soxnsox-stat-card group p-6 rounded-3xl border border-white/20 hover:border-[#2ca7a3]/60 text-center space-y-2 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" style="background: rgba(15, 43, 73, 0.65); backdrop-filter: blur(12px);">
                    <span class="font-display text-3xl sm:text-4xl font-extrabold text-[#2ca7a3] block soxnsox-stat-num transition-transform duration-300 group-hover:scale-110">99.8%</span>
                    <span class="text-xs font-bold text-white uppercase tracking-wider block">Odour Defense</span>
                    <p class="text-[11px] text-slate-300">Natural Bamboo Kun eliminates foot bacteria</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 10: BESTSELLERS STRIP (COMMUNITY FAVORITES) -->
    <section class="py-20 lg:py-28 bg-[#f5f7fa] border-b border-[#e5e7eb] reveal-on-scroll">
        <div class="site-container">
            <div class="mx-auto max-w-3xl text-center space-y-4 mb-14 reveal-on-scroll reveal-up">
                <span class="soxnsox-eyebrow">Customer Favorites</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] soxnsox-heading-accent">
                    Most Loved Multi-Packs
                </h2>
                <p class="text-sm text-[#6b7280] max-w-lg mx-auto leading-relaxed">
                    Stock your sock drawer with our top-rated bamboo bundles. Unbeatable value in 4-packs and 6-packs.
                </p>
            </div>

            @if ($bestSellers->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 reveal-stagger">
                    @foreach ($bestSellers as $bsProduct)
                        <x-shop::products.card :product="$bsProduct" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- SECTION 11: CUSTOMER FEEDBACK & VERIFIED REVIEWS (From Old Website Section 10) -->
    <section class="py-20 lg:py-28 bg-white border-b border-[#e5e7eb] reveal-on-scroll">
        <div class="site-container">
            <div class="mx-auto max-w-3xl text-center space-y-4 mb-14 reveal-on-scroll reveal-up">
                <span class="soxnsox-eyebrow">Customer Feedback</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] soxnsox-heading-accent">
                    Trusted by Customers Who Value Comfort
                </h2>
                <p class="text-xs sm:text-sm text-[#6b7280] max-w-lg mx-auto">
                    Verified reviews from gym enthusiasts, doctors, and working professionals across India.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 reveal-stagger">
                <!-- Review 1 -->
                <div class="soxnsox-category-card p-8 rounded-3xl bg-[#f5f7fa] border border-[#e5e7eb] shadow-sm space-y-4 hover:border-[#2ca7a3]/60 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(19,59,99,0.12)] transition-all duration-300 group">
                    <div class="flex items-center gap-1 text-[#f28c38] text-xs">
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-75"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-100"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-150"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-200"></i>
                    </div>
                    <p class="font-display text-sm sm:text-base font-semibold text-[#133b63] leading-relaxed">
                        "My father has diabetes and regular socks would always leave red, painful ring marks on his calves. These diabetic bamboo socks are life changing! No pinching at all."
                    </p>
                    <div class="pt-3 border-t border-[#e5e7eb] text-xs font-bold text-[#6b7280]">
                        — Rajesh Verma, Bengaluru
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="soxnsox-category-card p-8 rounded-3xl bg-[#f5f7fa] border border-[#e5e7eb] shadow-sm space-y-4 hover:border-[#2ca7a3]/60 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(19,59,99,0.12)] transition-all duration-300 group">
                    <div class="flex items-center gap-1 text-[#f28c38] text-xs">
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-75"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-100"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-150"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-200"></i>
                    </div>
                    <p class="font-display text-sm sm:text-base font-semibold text-[#133b63] leading-relaxed">
                        "I spend 10 hours a day in formal leather shoes. Standard cotton socks used to smell terrible by evening. With SOX N SOX, my feet stay completely odorless and dry!"
                    </p>
                    <div class="pt-3 border-t border-[#e5e7eb] text-xs font-bold text-[#6b7280]">
                        — Siddharth Mehra, Mumbai
                    </div>
                </div>

                <!-- Review 3 -->
                <div class="soxnsox-category-card p-8 rounded-3xl bg-[#f5f7fa] border border-[#e5e7eb] shadow-sm space-y-4 hover:border-[#2ca7a3]/60 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(19,59,99,0.12)] transition-all duration-300 group">
                    <div class="flex items-center gap-1 text-[#f28c38] text-xs">
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-75"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-100"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-150"></i>
                        <i class="fa-solid fa-star transition-transform duration-300 group-hover:scale-125 delay-200"></i>
                    </div>
                    <p class="font-display text-sm sm:text-base font-semibold text-[#133b63] leading-relaxed">
                        "The Gym Performance bamboo socks have amazing arch support. I run 5km every morning and haven't had a single blister since switching to SOX N SOX. Truly 10/10."
                    </p>
                    <div class="pt-3 border-t border-[#e5e7eb] text-xs font-bold text-[#6b7280]">
                        — Ananya Sen, New Delhi
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 12: ELEVATE YOUR COMFORT, EVERY DAY (From Old Website Section 13) -->
    <section class="py-20 lg:py-28 bg-[#133b63] text-white border-b border-[#103254] relative overflow-hidden reveal-on-scroll">
        <div class="absolute -left-20 -bottom-20 w-80 h-80 rounded-full bg-[#2ca7a3]/20 blur-[90px] pointer-events-none animate-soxnsox-pulse-glow"></div>
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-[#f28c38]/20 blur-[90px] pointer-events-none animate-soxnsox-pulse-glow" style="animation-delay: 2s;"></div>

        <div class="site-container relative z-10 text-center max-w-3xl mx-auto space-y-6 reveal-on-scroll reveal-scale">
            <span class="soxnsox-eyebrow !text-[#2ca7a3]">Simple Comfort. Everyday Life.</span>
            <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight soxnsox-heading-accent">
                Elevate Your Comfort, Every Day
            </h2>
            <p class="text-base sm:text-lg text-slate-200 leading-relaxed max-w-2xl mx-auto">
                Discover premium socks designed for comfort, movement, and everyday living. Handcrafted from pure bamboo yarn with seamless blister protection.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                <a
                    href="{{ route('shop.products.index') }}"
                    class="soxnsox-hero-btn-orange soxnsox-btn-shimmer soxnsox-btn-glow px-8 py-3.5 text-xs shadow-lg hover:shadow-orange-500/25 hover:scale-105 active:scale-95 transition-all duration-300"
                    style="background-color: #f28c38 !important; color: #ffffff !important; border: 1px solid #f28c38 !important;"
                >
                    <span>Shop Collection</span>
                    <i class="fa-solid fa-arrow-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                </a>
                <a
                    href="{{ route('shop.home.contact_us') }}"
                    class="soxnsox-btn-shimmer px-8 py-3.5 text-xs rounded-full font-bold uppercase tracking-wider text-white border border-white/40 hover:bg-white/10 hover:border-white hover:scale-105 active:scale-95 transition-all duration-300 inline-flex items-center gap-2"
                >
                    <span>Contact Support</span>
                    <i class="fa-solid fa-headset text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 13: FOOT WELLNESS & BAMBOO JOURNAL (EDITORIAL SHOWCASE) -->
    @if (!empty($latestBlogs) && count($latestBlogs) > 0)
    <section id="wellness-journal" class="py-20 lg:py-28 bg-white border-b border-[#e5e7eb] reveal-on-scroll">
        <div class="site-container">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14 reveal-on-scroll reveal-up">
                <div class="space-y-3">
                    <span class="soxnsox-eyebrow">Foot Health &amp; Science</span>
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] soxnsox-heading-accent soxnsox-heading-accent-left text-left block">
                        Stories From The Loom
                    </h2>
                    <p class="text-xs sm:text-sm text-[#6b7280] max-w-lg leading-relaxed">
                        Evidence-based podiatry advice, bamboo fiber benefits, and diabetic foot wellness guides from our specialists.
                    </p>
                </div>

                <a
                    href="{{ route('shop.blogs.index') }}"
                    class="soxnsox-btn-outline soxnsox-btn-shimmer self-start md:self-auto !px-7 !py-3 text-xs inline-flex items-center gap-2 hover:scale-105 active:scale-95 transition-all duration-300"
                >
                    <span>View All Articles</span>
                    <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1.5"></i>
                </a>
            </div>

            <!-- Blog Showcase Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 reveal-stagger">
                @foreach ($latestBlogs as $blog)
                    @php
                        $bImgUrl = null;
                        if (!empty($blog->featured_image)) {
                            if (filter_var($blog->featured_image, FILTER_VALIDATE_URL)) {
                                $bImgUrl = $blog->featured_image;
                            } elseif (file_exists(public_path('storage/' . $blog->featured_image))) {
                                $bImgUrl = asset('storage/' . $blog->featured_image);
                            } elseif (file_exists(public_path($blog->featured_image))) {
                                $bImgUrl = asset($blog->featured_image);
                            } else {
                                $bImgUrl = asset('storage/' . $blog->featured_image);
                            }
                        }
                        if (!$bImgUrl) {
                            $bImgUrl = asset('images/hero-slide-1.webp');
                        }

                        $formattedDate = !empty($blog->published_at) ? date('M d, Y', strtotime($blog->published_at)) : 'Latest';
                        $blogCatSlug = \Illuminate\Support\Str::slug($blog->category ?: 'wellness') ?: 'general';
                        $blogUrl = route('shop.blogs.view', ['category_slug' => $blogCatSlug, 'url_key' => $blog->url_key]);
                    @endphp
                    <article class="soxnsox-category-card group flex flex-col justify-between bg-[#f5f7fa] rounded-3xl border border-[#e5e7eb] overflow-hidden shadow-sm hover:shadow-[0_20px_45px_-12px_rgba(19,59,99,0.16)] hover:border-[#2ca7a3] hover:-translate-y-2 transition-all duration-300">
                        <div>
                            <!-- Image Stage with Light Sheen Shimmer -->
                            <a href="{{ $blogUrl }}" class="soxnsox-image-shimmer block relative aspect-[16/10] overflow-hidden bg-slate-200">
                                <img
                                    src="{{ $bImgUrl }}"
                                    alt="{{ $blog->name }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-108"
                                />
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/95 text-[#133b63] shadow-md border border-slate-200/80 backdrop-blur-md">
                                        {{ $blog->category ?: 'Foot Care' }}
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4 z-10">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#133b63]/85 text-white backdrop-blur-md">
                                        <i class="fa-regular fa-clock text-[9px]"></i>
                                        {{ $blog->read_time ?? 5 }} min read
                                    </span>
                                </div>
                            </a>

                            <!-- Card Body -->
                            <div class="p-6 sm:p-7">
                                <div class="flex items-center gap-2 text-xs text-[#6b7280] mb-3">
                                    <span>{{ $formattedDate }}</span>
                                    <span>&bull;</span>
                                    <span class="font-medium text-[#133b63]">SOX N SOX Wellness</span>
                                </div>

                                <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors leading-snug tracking-tight mb-3 line-clamp-2">
                                    <a href="{{ $blogUrl }}">
                                        {{ $blog->name }}
                                    </a>
                                </h3>

                                <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed line-clamp-3 mb-5">
                                    {{ $blog->short_description }}
                                </p>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-0">
                            <a
                                href="{{ $blogUrl }}"
                                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#2ca7a3] group-hover:text-[#133b63] transition-colors"
                            >
                                <span>Read Full Article</span>
                                <i class="fa-solid fa-arrow-right text-[11px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- SECTION 14: FAQ ACCORDION -->
    <section class="py-20 lg:py-28 bg-[#f5f7fa] reveal-on-scroll">
        <div class="site-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                <!-- Left: Header -->
                <div class="lg:col-span-4 space-y-4 reveal-on-scroll reveal-left">
                    <span class="soxnsox-eyebrow">Got Questions?</span>
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-[2.75rem] font-extrabold tracking-tight text-[#133b63] soxnsox-heading-accent soxnsox-heading-accent-left text-left block" style="line-height: 1.2 !important;">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-sm text-[#6b7280] leading-relaxed">
                        Learn more about our bamboo material, washing instructions, and diabetic fit.
                    </p>
                    <a
                        href="{{ route('shop.home.contact_us') }}"
                        class="soxnsox-btn-outline soxnsox-btn-shimmer inline-flex !px-6 !py-3 text-xs mt-4 active:scale-95"
                    >
                        Contact Our Support
                    </a>
                </div>

                <!-- Right: Accordion Cards -->
                <div class="lg:col-span-8 space-y-4 reveal-stagger">
                    <!-- FAQ 1 -->
                    <details class="group rounded-2xl border border-[#e5e7eb] bg-white p-6 transition-all duration-300 hover:border-[#2ca7a3]/40 hover:shadow-sm open:border-[#2ca7a3]/60 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between font-display text-base font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="pr-4 group-hover:text-[#2ca7a3] transition-colors">Why are bamboo socks better than regular cotton socks?</span>
                            <span class="w-8 h-8 rounded-full bg-[#2ca7a3]/10 flex items-center justify-center shrink-0 group-open:bg-[#2ca7a3] transition-colors duration-300">
                                <i class="fa-solid fa-plus text-[#2ca7a3] group-open:text-white text-xs transition-transform duration-300 group-open:rotate-45"></i>
                            </span>
                        </summary>
                        <div class="pt-4 text-sm text-[#6b7280] leading-relaxed border-t border-gray-100 mt-4">
                            Bamboo fiber contains natural antibacterial bio-agents ("Bamboo Kun") that eliminate odor-causing bacteria. Bamboo is also 3 times more moisture-wicking and significantly softer than cotton, keeping your feet completely dry, blister-free, and comfortable throughout the day.
                        </div>
                    </details>

                    <!-- FAQ 2 -->
                    <details class="group rounded-2xl border border-[#e5e7eb] bg-white p-6 transition-all duration-300 hover:border-[#2ca7a3]/40 hover:shadow-sm open:border-[#2ca7a3]/60 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between font-display text-base font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="pr-4 group-hover:text-[#2ca7a3] transition-colors">What makes your Diabetic Socks doctor-recommended?</span>
                            <span class="w-8 h-8 rounded-full bg-[#2ca7a3]/10 flex items-center justify-center shrink-0 group-open:bg-[#2ca7a3] transition-colors duration-300">
                                <i class="fa-solid fa-plus text-[#2ca7a3] group-open:text-white text-xs transition-transform duration-300 group-open:rotate-45"></i>
                            </span>
                        </summary>
                        <div class="pt-4 text-sm text-[#6b7280] leading-relaxed border-t border-gray-100 mt-4">
                            Our Diabetic Friendly socks feature non-binding, loose-top cuffs that do not constrict blood flow or leave tight elastic marks on calves. They also feature hand-linked seamless toes to eliminate friction blisters, and extra sole cushioning for plantar pressure relief.
                        </div>
                    </details>

                    <!-- FAQ 3 -->
                    <details class="group rounded-2xl border border-[#e5e7eb] bg-white p-6 transition-all duration-300 hover:border-[#2ca7a3]/40 hover:shadow-sm open:border-[#2ca7a3]/60 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between font-display text-base font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="pr-4 group-hover:text-[#2ca7a3] transition-colors">How do I wash and care for bamboo socks?</span>
                            <span class="w-8 h-8 rounded-full bg-[#2ca7a3]/10 flex items-center justify-center shrink-0 group-open:bg-[#2ca7a3] transition-colors duration-300">
                                <i class="fa-solid fa-plus text-[#2ca7a3] group-open:text-white text-xs transition-transform duration-300 group-open:rotate-45"></i>
                            </span>
                        </summary>
                        <div class="pt-4 text-sm text-[#6b7280] leading-relaxed border-t border-gray-100 mt-4">
                            Machine wash in cold or warm water (under 40°C) with gentle detergent. Avoid chlorine bleach or fabric softeners as bamboo is naturally soft. Air dry or tumble dry on low heat for maximum fabric longevity.
                        </div>
                    </details>

                    <!-- FAQ 4 -->
                    <details class="group rounded-2xl border border-[#e5e7eb] bg-white p-6 transition-all duration-300 hover:border-[#2ca7a3]/40 hover:shadow-sm open:border-[#2ca7a3]/60 open:shadow-md">
                        <summary class="flex cursor-pointer list-none items-center justify-between font-display text-base font-bold text-[#133b63] [&::-webkit-details-marker]:hidden select-none">
                            <span class="pr-4 group-hover:text-[#2ca7a3] transition-colors">What pack sizes and colors are available?</span>
                            <span class="w-8 h-8 rounded-full bg-[#2ca7a3]/10 flex items-center justify-center shrink-0 group-open:bg-[#2ca7a3] transition-colors duration-300">
                                <i class="fa-solid fa-plus text-[#2ca7a3] group-open:text-white text-xs transition-transform duration-300 group-open:rotate-45"></i>
                            </span>
                        </summary>
                        <div class="pt-4 text-sm text-[#6b7280] leading-relaxed border-t border-gray-100 mt-4">
                            Most of our socks are available in convenient multi-packs of 4, 6, and 12 pairs in Classic Black, Navy Blue, Sand Beige, Pure White, and assorted multi-color sets.
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>


    @push('scripts')
    <script type="text/x-template" id="v-soxnsox-hero-slider-template">
        <section
            class="soxnsox-hero-slider-section relative flex items-center overflow-hidden border-b border-[#133b63] text-white bg-[#133b63] select-none outline-none"
            style="min-height: 580px;"
            @mouseenter="onMouseEnter"
            @mouseleave="onMouseLeave"
            @touchstart="handleTouchStart"
            @touchend="handleTouchEnd"
            tabindex="0"
            @keydown.left="prev"
            @keydown.right="next"
            role="region"
            aria-roledescription="carousel"
            aria-label="SOX N SOX Hero Slider"
        >
            <!-- Ambient Glowing Depth Orbs -->
            <div class="absolute -left-24 top-1/4 w-96 h-96 rounded-full bg-[#2ca7a3]/20 blur-[120px] pointer-events-none soxnsox-orb-1 z-0"></div>
            <div class="absolute right-1/4 -bottom-24 w-96 h-96 rounded-full bg-[#f28c38]/15 blur-[130px] pointer-events-none soxnsox-orb-2 z-0"></div>

            <!-- Slides Container -->
            <div class="soxnsox-hero-slides-wrapper relative w-full h-full flex items-center" style="min-height: 580px;">
                <div
                    v-for="(slide, index) in slides"
                    :key="slide.id"
                    class="absolute inset-0 w-full h-full flex items-center transition-opacity duration-700 ease-in-out"
                    :class="currentSlide === index ? 'opacity-100 z-10 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none'"
                    role="group"
                    :aria-label="'Slide ' + (index + 1) + ' of ' + slides.length"
                    :aria-hidden="currentSlide !== index"
                >
                    <!-- Authentic Slide Background Image with subtle Ken Burns zoom effect -->
                    <div
                        class="absolute inset-0 bg-cover bg-no-repeat pointer-events-none transition-transform duration-[7000ms] ease-out will-change-transform"
                        :class="currentSlide === index ? 'scale-106' : 'scale-100'"
                        :style="{ backgroundImage: 'url(' + slide.bgImage + ')', backgroundPosition: 'right center' }"
                    ></div>

                    <!-- Mobile/Tablet Solid Dark Scrim Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-b from-[#133b63] via-[#133b63]/95 to-[#133b63]/85 lg:hidden pointer-events-none"></div>

                    <!-- Desktop Precision Horizontal Half-Shade (Solid on left 36%, smoothly feathering to transparent on right) -->
                    <div
                        class="absolute inset-0 hidden lg:block pointer-events-none"
                        style="background: linear-gradient(90deg, #133b63 0%, #133b63 36%, rgba(19, 59, 99, 0.95) 46%, rgba(19, 59, 99, 0.60) 60%, rgba(19, 59, 99, 0.15) 74%, rgba(19, 59, 99, 0) 84%);"
                    ></div>

                    <!-- Slide Content Container with Harmonious Padding & Clearance Above Bottom Bar -->
                    <div class="site-container relative z-10 pt-6 sm:pt-8 lg:pt-10 pb-24 sm:pb-28 lg:pb-32 w-full">
                        <div
                            class="max-w-xl lg:max-w-2xl text-left space-y-3.5 sm:space-y-4 lg:space-y-4.5 transition-all duration-700 ease-out"
                            :class="currentSlide === index ? 'translate-y-0 opacity-100' : 'translate-y-6 opacity-0'"
                        >
                            <!-- Eyebrow Tagline Badge -->
                            <div>
                                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-[#2ca7a3]/40 text-[#2ca7a3] text-[11px] font-extrabold tracking-wider uppercase shadow-sm animate-soxnsox-float" style="animation-duration: 5s;">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#2ca7a3] opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#2ca7a3]"></span>
                                    </span>
                                    <span>@{{ slide.eyebrow }}</span>
                                </div>
                            </div>

                            <!-- Main Headline with Clean SemiBold Weight and 1.18 Line Height -->
                            <h1 v-if="index === 0" class="soxnsox-hero-headline font-display text-3xl sm:text-4xl md:text-[42px] lg:text-[46px] xl:text-[50px] leading-[1.18]">
                                @{{ slide.titleMain }}
                                <span class="soxnsox-hero-headline-highlight soxnsox-text-shimmer" style="display: block !important; margin-top: 0.25rem !important;">@{{ slide.titleHighlight }}</span>
                            </h1>
                            <h2 v-else class="soxnsox-hero-headline font-display text-3xl sm:text-4xl md:text-[42px] lg:text-[46px] xl:text-[50px] leading-[1.18]">
                                @{{ slide.titleMain }}
                                <span class="soxnsox-hero-headline-highlight soxnsox-text-shimmer" style="display: block !important; margin-top: 0.25rem !important;">@{{ slide.titleHighlight }}</span>
                            </h2>

                            <!-- Paragraph Description with Generous Leading and Breathing Room -->
                            <p class="text-xs sm:text-sm lg:text-[15px] text-slate-100/90 leading-relaxed font-normal max-w-lg">
                                @{{ slide.description }}
                            </p>

                            <!-- 4 Signature Feature Badges (2x2 Balanced Grid with Zero Overflow & Generous Padding) -->
                            <div class="grid grid-cols-2 gap-3 sm:gap-3.5 max-w-md pt-1 sm:pt-1.5">
                                <div
                                    v-for="(badge, bIdx) in slide.badges"
                                    :key="bIdx"
                                    class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl bg-white/[0.08] hover:bg-white/[0.15] backdrop-blur-md border border-white/15 hover:border-[#2ca7a3]/60 hover:shadow-[0_8px_20px_-4px_rgba(44,167,163,0.3)] hover:-translate-y-0.5 transition-all duration-300 group cursor-default min-w-0 overflow-hidden"
                                >
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full border border-[#2ca7a3] bg-[#2ca7a3]/15 flex items-center justify-center text-[#2ca7a3] text-xs group-hover:scale-110 group-hover:bg-[#2ca7a3] group-hover:text-white transition-all flex-shrink-0" :class="bIdx === 0 ? 'animate-soxnsox-heartbeat' : ''">
                                        <i :class="badge.icon"></i>
                                    </div>
                                    <div class="min-w-0 flex-1 leading-tight">
                                        <span class="block text-[11px] font-bold text-white uppercase tracking-wider truncate">
                                            @{{ badge.label1 }}
                                        </span>
                                        <span class="block text-[10px] font-medium text-slate-300 uppercase tracking-wide truncate">
                                            @{{ badge.label2 }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Action Buttons (Sleek, Compact Proportions) -->
                            <div class="flex flex-wrap items-center gap-3 sm:gap-3.5 pt-2 sm:pt-2.5">
                                <!-- Primary Orange Solid Button -->
                                <a
                                    :href="slide.primaryBtn.url"
                                    class="soxnsox-hero-btn-orange soxnsox-btn-shimmer soxnsox-btn-glow px-5 sm:px-6 py-2.5 text-xs shadow-lg hover:shadow-orange-500/30 hover:scale-105 active:scale-95 transition-all duration-300"
                                    style="background-color: #f28c38 !important; background-image: linear-gradient(135deg, #f28c38 0%, #e07a2f 100%) !important; color: #ffffff !important; border: 1px solid #f28c38 !important;"
                                >
                                    <span>@{{ slide.primaryBtn.text }}</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                                </a>

                                <!-- Secondary Teal Outlined Button -->
                                <a
                                    :href="slide.secondaryBtn.url"
                                    class="soxnsox-hero-btn-teal soxnsox-btn-shimmer px-5 sm:px-6 py-2.5 text-xs hover:bg-[#2ca7a3] hover:text-white hover:scale-105 active:scale-95 transition-all duration-300"
                                    style="background-color: transparent !important; border: 1.5px solid #2ca7a3 !important; color: #2ca7a3 !important;"
                                >
                                    <span>@{{ slide.secondaryBtn.text }}</span>
                                    <i class="fa-solid fa-angles-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Pagination & Category Navigation Bar -->
            <div class="absolute bottom-5 sm:bottom-6 lg:bottom-8 left-0 w-full z-30 pointer-events-auto">
                <div class="site-container flex items-center justify-between">
                    <!-- 3 Category Navigation Buttons with Progress Bars -->
                    <div class="flex items-center gap-3 sm:gap-6">
                        <button
                            type="button"
                            v-for="(slide, idx) in slides"
                            :key="'dot-' + idx"
                            @click="goTo(idx)"
                            class="group flex items-center gap-2 sm:gap-3 py-2 cursor-pointer focus:outline-none transition-all duration-300"
                            :aria-label="'Go to slide ' + (idx + 1) + ': ' + slide.shortTitle"
                        >
                            <span
                                class="text-[11px] sm:text-xs font-mono font-bold tracking-wider transition-colors duration-300"
                                :class="currentSlide === idx ? 'text-[#2ca7a3]' : 'text-white/50 group-hover:text-white/80'"
                            >
                                0@{{ idx + 1 }}
                            </span>
                            <span
                                class="hidden sm:inline text-[11px] sm:text-xs font-bold tracking-wider uppercase transition-colors duration-300"
                                :class="currentSlide === idx ? 'text-white font-extrabold' : 'text-white/40 group-hover:text-white/70'"
                            >
                                @{{ slide.shortTitle }}
                            </span>
                            <div
                                class="h-[3px] sm:h-[4px] rounded-full transition-all duration-500 overflow-hidden relative"
                                :class="currentSlide === idx ? 'w-12 sm:w-20 bg-white/20' : 'w-4 sm:w-8 bg-white/25 group-hover:bg-white/45'"
                            >
                                <div
                                    v-if="currentSlide === idx"
                                    :key="'progress-' + currentSlide"
                                    class="absolute inset-0 bg-[#2ca7a3] rounded-full shadow-[0_0_10px_rgba(44,167,163,0.9)] soxnsox-progress-active"
                                    :style="{ animationDuration: slideDuration + 'ms' }"
                                ></div>
                            </div>
                        </button>
                    </div>

                    <!-- Slide Prev / Next Chevron Buttons in Bottom Bar -->
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="prev"
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/10 hover:bg-[#2ca7a3] text-white border border-white/20 hover:border-[#2ca7a3] backdrop-blur-md flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none cursor-pointer"
                            aria-label="Previous slide"
                        >
                            <i class="fa-solid fa-chevron-left text-[11px] sm:text-xs"></i>
                        </button>
                        <button
                            type="button"
                            @click="next"
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/10 hover:bg-[#2ca7a3] text-white border border-white/20 hover:border-[#2ca7a3] backdrop-blur-md flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none cursor-pointer"
                            aria-label="Next slide"
                        >
                            <i class="fa-solid fa-chevron-right text-[11px] sm:text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </script>

    <script type="module">
        app.component('v-soxnsox-hero-slider', {
            template: '#v-soxnsox-hero-slider-template',
            props: ['initialSlides', 'initialAutoplay', 'initialDuration'],

            data() {
                return {
                    currentSlide: 0,
                    autoplayTimer: null,
                    isHovered: false,
                    touchStartX: 0,
                    touchEndX: 0,
                    autoplayEnabled: this.initialAutoplay !== undefined ? Boolean(this.initialAutoplay) : true,
                    slideDuration: this.initialDuration ? parseInt(this.initialDuration) : 6000,
                    slides: (this.initialSlides && this.initialSlides.length > 0) ? this.initialSlides : [
                        {
                            id: 1,
                            shortTitle: 'Everyday Comfort',
                            bgImage: '{{ asset('images/hero-slide-1.webp') }}',
                            eyebrow: 'PREMIUM EVERYDAY SOCKS',
                            titleMain: 'Comfort, Style &',
                            titleHighlight: 'Support For Every Step',
                            description: 'Premium socks designed for everyday comfort, movement, and modern lifestyles — for Men, Women & Children.',
                            badges: [
                                { icon: 'fa-solid fa-heart-pulse', label1: 'Breathable', label2: 'Comfort' },
                                { icon: 'fa-solid fa-shield-halved', label1: 'Everyday', label2: 'Durability' },
                                { icon: 'fa-solid fa-check', label1: 'Soft', label2: 'Support' },
                                { icon: 'fa-solid fa-wind', label1: 'Modern', label2: 'Fit' }
                            ],
                            primaryBtn: {
                                text: 'SHOP PREMIUM SOCKS',
                                url: '{{ route('shop.products.index') }}'
                            },
                            secondaryBtn: {
                                text: 'EXPLORE COLLECTIONS',
                                url: '{{ route('shop.products.index') }}'
                            }
                        },
                        {
                            id: 2,
                            shortTitle: 'Diabetic Care',
                            bgImage: '{{ asset('images/hero-slide-2.webp') }}',
                            eyebrow: 'CLINICALLY DESIGNED COMFORT',
                            titleMain: 'Diabetic & Compression Footwear',
                            titleHighlight: 'For Sensitive Feet',
                            description: 'Non-binding loose-top cuffs that protect blood circulation, hand-linked seamless toes, and cushioned sole relief.',
                            badges: [
                                { icon: 'fa-solid fa-heart-circle-check', label1: 'Circulation', label2: 'Care' },
                                { icon: 'fa-solid fa-feather', label1: 'Non-Binding', label2: 'Tops' },
                                { icon: 'fa-solid fa-shield-halved', label1: 'Seamless', label2: 'Toe' },
                                { icon: 'fa-solid fa-stethoscope', label1: 'Doctor', label2: 'Approved' }
                            ],
                            primaryBtn: {
                                text: 'SHOP DIABETIC SOCKS',
                                url: '{{ route('shop.products.index') }}'
                            },
                            secondaryBtn: {
                                text: 'VIEW MEDICAL RANGE',
                                url: '{{ route('shop.products.index') }}'
                            }
                        },
                        {
                            id: 3,
                            shortTitle: 'Athletic Grip',
                            bgImage: '{{ asset('images/hero-slide-3.webp') }}',
                            eyebrow: 'ENGINEERED PERFORMANCE',
                            titleMain: 'Targeted Arch Support & Anti-Slip Grip',
                            titleHighlight: 'For Active Life',
                            description: 'High-density knit with dynamic mid-foot compression and moisture-wicking fibers for training, work, and everyday movement.',
                            badges: [
                                { icon: 'fa-solid fa-shoe-prints', label1: 'Anti-Slip', label2: 'Traction' },
                                { icon: 'fa-solid fa-bolt', label1: 'Dynamic Arch', label2: 'Band' },
                                { icon: 'fa-solid fa-droplet-slash', label1: 'Rapid-Dry', label2: 'Mesh' },
                                { icon: 'fa-solid fa-shield', label1: 'Reinforced', label2: 'Heel' }
                            ],
                            primaryBtn: {
                                text: 'EXPLORE ACTIVEWEAR',
                                url: '{{ route('shop.products.index') }}'
                            },
                            secondaryBtn: {
                                text: 'SHOP ALL STYLES',
                                url: '{{ route('shop.products.index') }}'
                            }
                        }
                    ]
                };
            },

            mounted() {
                if (this.autoplayEnabled) {
                    this.restartAutoplayTimer();
                }
            },

            beforeUnmount() {
                this.clearAutoplayTimer();
            },

            methods: {
                next() {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    if (!this.isHovered && this.autoplayEnabled) {
                        this.restartAutoplayTimer();
                    }
                },

                prev() {
                    this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                    if (!this.isHovered && this.autoplayEnabled) {
                        this.restartAutoplayTimer();
                    }
                },

                goTo(index) {
                    this.currentSlide = index;
                    if (!this.isHovered && this.autoplayEnabled) {
                        this.restartAutoplayTimer();
                    }
                },

                onMouseEnter() {
                    this.isHovered = true;
                    this.clearAutoplayTimer();
                },

                onMouseLeave() {
                    this.isHovered = false;
                    if (this.autoplayEnabled) {
                        this.restartAutoplayTimer();
                    }
                },

                restartAutoplayTimer() {
                    this.clearAutoplayTimer();
                    if (this.autoplayEnabled && this.slides.length > 1) {
                        this.autoplayTimer = setInterval(() => {
                            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                        }, this.slideDuration);
                    }
                },

                clearAutoplayTimer() {
                    if (this.autoplayTimer) {
                        clearInterval(this.autoplayTimer);
                        this.autoplayTimer = null;
                    }
                },

                handleTouchStart(e) {
                    if (e.changedTouches && e.changedTouches[0]) {
                        this.touchStartX = e.changedTouches[0].screenX;
                    }
                },

                handleTouchEnd(e) {
                    if (e.changedTouches && e.changedTouches[0]) {
                        this.touchEndX = e.changedTouches[0].screenX;
                        const diff = this.touchStartX - this.touchEndX;
                        if (diff > 50) {
                            this.next();
                        } else if (diff < -50) {
                            this.prev();
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-shop::layouts>
