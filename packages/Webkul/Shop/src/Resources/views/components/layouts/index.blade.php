@props([
    'hasHeader'  => true,
    'hasFeature' => true,
    'hasFooter'  => true,
])

<!DOCTYPE html>

<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>
    <head>

        {!! view_render_event('bagisto.shop.layout.head.before') !!}

        <title>{{ $title ?? '' }}</title>

        <meta charset="UTF-8">

        <meta
            http-equiv="X-UA-Compatible"
            content="IE=edge"
        >
        <meta
            http-equiv="content-language"
            content="{{ app()->getLocale() }}"
        >

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >
        <meta
            name="base-url"
            content="{{ url()->to('/') }}"
        >
        <meta
            name="currency"
            content="{{ core()->getCurrentCurrency()->toJson() }}"
        >
        <meta 
            name="generator" 
            content="SOX N SOX Bamboo Socks"
        >

        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}" />

        <!-- Robots Meta -->
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

        <!-- Open Graph Meta Tags -->
        <meta property="og:site_name" content="SOX N SOX Bamboo Socks" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@soxnsox" />

        @stack('meta')

        <!-- JSON-LD Global Organization & WebSite Schema -->
        @php
            $globalSchema = [
                '@context' => 'https://schema.org',
                '@graph'   => [
                    [
                        '@type'       => 'Organization',
                        '@id'         => url('/') . '/#organization',
                        'name'        => 'SOX N SOX',
                        'url'         => url('/'),
                        'logo'        => [
                            '@type'   => 'ImageObject',
                            '@id'     => url('/') . '/#logo',
                            'url'     => asset('logo.png'),
                            'caption' => 'SOX N SOX Bamboo Socks',
                        ],
                        'sameAs'      => [
                            'https://instagram.com/soxnsox',
                            'https://facebook.com/soxnsox',
                            'https://twitter.com/soxnsox',
                        ],
                        'address'     => [
                            '@type'           => 'PostalAddress',
                            'streetAddress'   => 'ALEAP Industrial Estate, Gajularamaram, Road Number 10, Pragathi Nagar',
                            'addressLocality' => 'Hyderabad',
                            'addressRegion'   => 'Telangana',
                            'postalCode'      => '500090',
                            'addressCountry'  => 'IN',
                        ],
                        'contactPoint' => [
                            '@type'             => 'ContactPoint',
                            'telephone'         => '+91-81061-55111',
                            'contactType'       => 'customer service',
                            'email'             => 'support@soxnsox.in',
                            'areaServed'        => 'IN',
                            'availableLanguage' => ['English', 'Hindi'],
                        ],
                    ],
                    [
                        '@type'           => 'WebSite',
                        '@id'             => url('/') . '/#website',
                        'url'             => url('/'),
                        'name'            => 'SOX N SOX',
                        'description'     => 'India\'s Premier Bamboo & Diabetic Socks for Men, Women & Kids',
                        'publisher'       => [
                            '@id' => url('/') . '/#organization',
                        ],
                        'potentialAction' => [
                            '@type'       => 'SearchAction',
                            'target'      => [
                                '@type'       => 'EntryPoint',
                                'urlTemplate' => url('/search') . '?query={search_term_string}',
                            ],
                            'query-input' => 'required name=search_term_string',
                        ],
                    ],
                ],
            ];
        @endphp
        <script type="application/ld+json">
        {!! json_encode($globalSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>

        @php
            $channel = core()->getCurrentChannel();
            $channelFavicon = $channel->favicon;
            $faviconUrl = ($channelFavicon && file_exists(public_path('storage/' . $channelFavicon)))
                ? asset('storage/' . $channelFavicon)
                : (file_exists(public_path('favicon.png')) ? asset('favicon.png') : ($channel->favicon_url ?: asset('favicon.ico')));
            $faviconIco = file_exists(public_path('favicon.ico')) ? asset('favicon.ico') : $faviconUrl;
            $appleIcon = file_exists(public_path('apple-touch-icon.png')) ? asset('apple-touch-icon.png') : $faviconUrl;
        @endphp

        <!-- Favicon & Touch Icons -->
        <link rel="icon" type="image/x-icon" href="{{ $faviconIco }}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ $faviconUrl }}" />
        <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconIco }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ $appleIcon }}" />

        @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

        <link
            rel="preconnect"
            href="https://fonts.googleapis.com"
            crossorigin
        />

        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin
        />

        <!-- Google Font: Poppins (Exclusive Store-Wide Font) -->
        <link
            rel="preload" as="style"
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        />

        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        />

        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

        <!-- Font Awesome 6 Free & Lucide Icons Providers -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://unpkg.com/lucide@latest"></script>

        <style>
            :root {
                --soxnsox-navy: #133b63;
                --soxnsox-blue: #1d5b8f;
                --soxnsox-teal: #2ca7a3;
                --soxnsox-orange: #f29a38;
                --soxnsox-orange-hover: #e08927;
                --soxnsox-bg: #f5f7fa;
                --soxnsox-surface: #ffffff;
                --soxnsox-border: #e2e8f0;
                --soxnsox-text: #133b63;
                --soxnsox-muted: #6b7280;
            }

            /* Strict Store-Wide Typography: Google Poppins Font Only */
            html,
            body,
            h1, h2, h3, h4, h5, h6,
            p,
            span:not([class*="material-symbols"]):not([class*="icon-"]):not([class*="fa-"]):not([class*="fa"]):not([data-lucide]),
            a:not([class*="material-symbols"]):not([class*="icon-"]):not([class*="fa-"]):not([class*="fa"]):not([data-lucide]),
            button:not([class*="material-symbols"]):not([class*="icon-"]):not([class*="fa-"]):not([class*="fa"]):not([data-lucide]),
            input, textarea, select, label,
            .font-serif,
            .font-sans,
            .font-display,
            .soxnsox-heading-display,
            .soxnsox-eyebrow,
            .prose,
            [class*="font-"]:not([class*="material-symbols"]):not([class*="icon-"]):not([class*="fa-"]):not([class*="fa"]) {
                font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
            }

            /* Preserve Bagisto Shop Icon Font on Elements and Pseudo-elements */
            [class^="icon-"],
            [class*=" icon-"],
            [class*="icon-"],
            [class^="icon-"]::before,
            [class*=" icon-"]::before,
            [class*="icon-"]::before,
            [class^="icon-"]::after,
            [class*=" icon-"]::after,
            [class*="icon-"]::after {
                font-family: "bagisto-shop" !important;
                font-style: normal !important;
                font-weight: normal !important;
                font-variant: normal !important;
                text-transform: none !important;
                line-height: 1 !important;
                speak: never;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            /* Preserve Google Material Symbols on Elements and Pseudo-elements */
            .material-symbols-outlined,
            .material-symbols-outlined::before,
            .material-symbols-outlined::after,
            [class*="material-symbols"],
            [class*="material-symbols"]::before,
            [class*="material-symbols"]::after {
                font-family: 'Material Symbols Outlined' !important;
                font-weight: normal !important;
                font-style: normal !important;
                font-size: 24px;
                line-height: 1;
                letter-spacing: normal;
                text-transform: none;
                display: inline-block;
                white-space: nowrap;
                word-wrap: normal;
                direction: ltr;
                -webkit-font-feature-settings: 'liga';
                -webkit-font-smoothing: antialiased;
            }

            body {
                background-color: #f5f7fa !important;
                color: #133b63 !important;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            /* SOX N SOX Official Brand Color Utilities */
            .bg-\[\#133b63\] { background-color: #133b63 !important; }
            .hover\:bg-\[\#133b63\]:hover { background-color: #133b63 !important; }
            .bg-\[\#1d5b8f\] { background-color: #1d5b8f !important; }
            .hover\:bg-\[\#1d5b8f\]:hover { background-color: #1d5b8f !important; }
            .bg-\[\#2ca7a3\] { background-color: #2ca7a3 !important; }
            .hover\:bg-\[\#2ca7a3\]:hover { background-color: #2ca7a3 !important; }
            .bg-\[\#f29a38\] { background-color: #f29a38 !important; }
            .hover\:bg-\[\#f29a38\]:hover { background-color: #f29a38 !important; }
            .bg-\[\#f5f7fa\] { background-color: #f5f7fa !important; }

            .border-\[\#133b63\] { border-color: #133b63 !important; }
            .border-\[\#2ca7a3\] { border-color: #2ca7a3 !important; }
            .border-\[\#f29a38\] { border-color: #f29a38 !important; }

            .text-\[\#133b63\] { color: #133b63; }
            .hover\:text-\[\#133b63\]:hover { color: #133b63 !important; }
            .text-\[\#1d5b8f\] { color: #1d5b8f; }
            .hover\:text-\[\#1d5b8f\]:hover { color: #1d5b8f !important; }
            .text-\[\#2ca7a3\] { color: #2ca7a3; }
            .hover\:text-\[\#2ca7a3\]:hover { color: #2ca7a3 !important; }
            .text-\[\#f29a38\] { color: #f29a38; }
            .hover\:text-\[\#f29a38\]:hover { color: #f29a38 !important; }
            .text-\[\#6b7280\] { color: #6b7280; }
            .hover\:text-white:hover { color: #ffffff !important; }

            /* Ensure group hover and direct hover icon & text color overrides take precedence */
            .group:hover .group-hover\:text-white,
            .group:hover [class*="group-hover:text-white"],
            .group-hover\:text-white:hover {
                color: #ffffff !important;
            }

            .group:hover .group-hover\:text-white i,
            .group:hover [class*="group-hover:text-white"] i,
            .group:hover [class*="group-hover:text-white"] svg {
                color: #ffffff !important;
                fill: #ffffff !important;
            }

            html {
                scroll-behavior: smooth;
            }

            header,
            .site-header,
            header.sticky,
            [role="banner"] {
                background-color: rgba(255, 255, 255, 0.96) !important;
                backdrop-filter: blur(12px) !important;
                -webkit-backdrop-filter: blur(12px) !important;
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
            }

            header.is-scrolled {
                background-color: rgba(255, 255, 255, 0.90) !important;
                backdrop-filter: blur(16px) !important;
                -webkit-backdrop-filter: blur(16px) !important;
                box-shadow: 0 10px 30px -10px rgba(19, 59, 99, 0.1) !important;
                border-bottom-color: rgba(226, 232, 240, 0.85) !important;
            }

            /* Global Selection */
            ::selection {
                background-color: #133b63 !important;
                color: #ffffff !important;
            }

            .soxnsox-eyebrow {
                display: block !important;
                font-size: 0.6875rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.22em !important;
                text-transform: uppercase !important;
                color: #2ca7a3 !important;
                margin-bottom: 0.5rem !important;
            }

            /* Primary Action Button (Radiant Tangerine / Amber) */
            .soxnsox-btn-primary,
            .primary-button, 
            .btn-primary, 
            button.btn-primary {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                background-color: #f29a38 !important;
                border: 1.5px solid #f29a38 !important;
                color: #ffffff !important;
                font-size: 0.75rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.12em !important;
                text-transform: uppercase !important;
                border-radius: 9999px !important;
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
                cursor: pointer !important;
                box-shadow: 0 4px 14px rgba(242, 154, 56, 0.3) !important;
            }

            .soxnsox-btn-primary:hover,
            .primary-button:hover, 
            .btn-primary:hover, 
            button.btn-primary:hover {
                background-color: #e08927 !important;
                border-color: #e08927 !important;
                box-shadow: 0 8px 24px rgba(242, 154, 56, 0.45) !important;
                transform: translateY(-2px) !important;
            }

            /* Secondary Action Button (Midnight Navy) */
            .soxnsox-btn-secondary,
            .gold-cta-btn {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                background: #133b63 !important;
                color: #ffffff !important;
                font-size: 0.75rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.12em !important;
                text-transform: uppercase !important;
                border: none !important;
                border-radius: 9999px !important;
                box-shadow: 0 6px 20px rgba(19, 59, 99, 0.25) !important;
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
                cursor: pointer !important;
            }

            .soxnsox-btn-secondary:hover,
            .gold-cta-btn:hover {
                background: #1d5b8f !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 10px 28px rgba(19, 59, 99, 0.35) !important;
            }

            /* Outline Button */
            .soxnsox-btn-outline,
            .secondary-button,
            .btn-secondary {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                background-color: transparent !important;
                border: 1.5px solid #133b63 !important;
                color: #133b63 !important;
                font-size: 0.75rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.12em !important;
                text-transform: uppercase !important;
                border-radius: 9999px !important;
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
                cursor: pointer !important;
            }

            .soxnsox-btn-outline:hover,
            .secondary-button:hover,
            .btn-secondary:hover {
                background-color: #133b63 !important;
                color: #ffffff !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 8px 24px rgba(19, 59, 99, 0.2) !important;
            }

            /* Teal Button */
            .soxnsox-btn-teal {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                background-color: #2ca7a3 !important;
                border: 1.5px solid #2ca7a3 !important;
                color: #ffffff !important;
                font-size: 0.75rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.12em !important;
                text-transform: uppercase !important;
                border-radius: 9999px !important;
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
                cursor: pointer !important;
                box-shadow: 0 4px 14px rgba(44, 167, 163, 0.3) !important;
            }

            .soxnsox-btn-teal:hover {
                background-color: #238a86 !important;
                border-color: #238a86 !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 8px 24px rgba(44, 167, 163, 0.45) !important;
            }

            /* Hero Premium Action Buttons (Guaranteed Contrast & Compact Proportions) */
            .soxnsox-hero-btn-orange {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.65rem 1.4rem !important;
                font-size: 0.75rem !important;
                gap: 0.5rem !important;
                background-color: #f28c38 !important;
                background-image: linear-gradient(135deg, #f28c38 0%, #e07a2f 100%) !important;
                color: #ffffff !important;
                border: 1px solid #f28c38 !important;
                border-radius: 9999px !important;
                font-weight: 700 !important;
                letter-spacing: 0.08em !important;
                text-transform: uppercase !important;
                box-shadow: 0 4px 14px rgba(242, 140, 56, 0.35) !important;
                transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
                cursor: pointer !important;
                text-decoration: none !important;
            }

            .soxnsox-hero-btn-orange:hover {
                background-color: #e07a2f !important;
                background-image: linear-gradient(135deg, #e07a2f 0%, #c86820 100%) !important;
                border-color: #e07a2f !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 6px 18px rgba(242, 140, 56, 0.45) !important;
                color: #ffffff !important;
            }

            .soxnsox-hero-btn-teal {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.65rem 1.4rem !important;
                font-size: 0.75rem !important;
                gap: 0.5rem !important;
                background-color: transparent !important;
                color: #2ca7a3 !important;
                border: 1.5px solid #2ca7a3 !important;
                border-radius: 9999px !important;
                font-weight: 700 !important;
                letter-spacing: 0.08em !important;
                text-transform: uppercase !important;
                backdrop-filter: blur(8px) !important;
                -webkit-backdrop-filter: blur(8px) !important;
                transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
                cursor: pointer !important;
                text-decoration: none !important;
            }

            .soxnsox-hero-btn-teal:hover {
                background-color: #2ca7a3 !important;
                color: #ffffff !important;
                border-color: #2ca7a3 !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 6px 18px rgba(44, 167, 163, 0.35) !important;
            }

            /* SOX N SOX Hero Slider Dimensions & Height Rules */
            .soxnsox-hero-slider-section {
                position: relative !important;
                width: 100% !important;
                min-height: 580px !important;
                display: flex !important;
                align-items: center !important;
                overflow: hidden !important;
                background-color: #133b63 !important;
                border-bottom: 1px solid #133b63 !important;
            }

            .soxnsox-hero-slides-wrapper {
                position: relative !important;
                width: 100% !important;
                height: 100% !important;
                min-height: 580px !important;
                display: flex !important;
                align-items: center !important;
            }

            @media (min-width: 640px) {
                .soxnsox-hero-slider-section,
                .soxnsox-hero-slides-wrapper {
                    min-height: 640px !important;
                }
            }

            @media (min-width: 1024px) {
                .soxnsox-hero-slider-section,
                .soxnsox-hero-slides-wrapper {
                    min-height: 680px !important;
                }
            }

            @media (min-width: 1280px) {
                .soxnsox-hero-slider-section,
                .soxnsox-hero-slides-wrapper {
                    min-height: 720px !important;
                }
            }

            /* SOX N SOX Hero Headline Typography (Font Weight 600 & Fluid Clamp Scaling) */
            .soxnsox-hero-headline {
                font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                font-weight: 600 !important;
                color: #ffffff !important;
                line-height: 1.18 !important;
                letter-spacing: -0.01em !important;
                font-size: clamp(1.85rem, 3.2vw, 2.75rem) !important;
            }

            .soxnsox-hero-headline-highlight {
                display: block !important;
                margin-top: 0.25rem !important;
                color: #2ca7a3 !important;
                font-weight: 600 !important;
                line-height: inherit !important;
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2) !important;
            }

            /* Bamboo & Accent Badges */
            .soxnsox-badge-bamboo {
                display: inline-flex !important;
                align-items: center !important;
                padding: 0.3rem 0.85rem !important;
                border-radius: 9999px !important;
                font-size: 0.6875rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.08em !important;
                text-transform: uppercase !important;
                background-color: #e6f8f7 !important;
                color: #2ca7a3 !important;
                border: 1px solid rgba(44, 167, 163, 0.25) !important;
            }

            .soxnsox-badge-amber,
            .soxnsox-badge-terracotta {
                display: inline-flex !important;
                align-items: center !important;
                padding: 0.3rem 0.85rem !important;
                border-radius: 9999px !important;
                font-size: 0.6875rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.08em !important;
                text-transform: uppercase !important;
                background-color: #fff4e8 !important;
                color: #f29a38 !important;
                border: 1px solid rgba(242, 154, 56, 0.3) !important;
            }

            .soxnsox-nav-link-active {
                color: #133b63 !important;
                font-weight: 700 !important;
            }

            .soxnsox-nav-link-active::after {
                content: '' !important;
                position: absolute !important;
                bottom: -2px !important;
                left: 0 !important;
                right: 0 !important;
                height: 2px !important;
                background-color: #f29a38 !important;
                border-radius: 9999px !important;
            }

            /* SOXNSOX Products Dropdown Menu Width & Interaction */
            .soxnsox-products-dropdown {
                width: 320px !important;
                min-width: 320px !important;
                z-index: 9999 !important;
                visibility: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important;
                transition: opacity 0.2s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.2s cubic-bezier(0.16, 1, 0.3, 1), transform 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
                transform: translateY(6px) !important;
            }

            .group:hover .soxnsox-products-dropdown,
            .group:focus-within .soxnsox-products-dropdown,
            .soxnsox-products-dropdown:hover {
                visibility: visible !important;
                opacity: 1 !important;
                pointer-events: auto !important;
                transform: translateY(0) !important;
            }

            /* SOXNSOX Dropdown Item Hover Effects */
            .soxnsox-dropdown-item {
                transition: all 0.18s ease !important;
            }

            .soxnsox-dropdown-item:hover {
                background-color: #e6f8f7 !important;
                color: #2ca7a3 !important;
            }

            .soxnsox-dropdown-item:hover span:first-child {
                background-color: #2ca7a3 !important;
                transform: scale(1.25) !important;
            }

            /* SOXNSOX Header Utility Action Icons (8px Balanced Gap) */
            .soxnsox-header-actions {
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
            }

            @media (min-width: 640px) {
                .soxnsox-header-actions {
                    gap: 8px !important;
                }
            }

            .soxnsox-header-action-btn {
                width: 38px !important;
                height: 38px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 9999px !important;
                color: #133b63 !important;
                transition: all 0.2s ease !important;
                flex-shrink: 0 !important;
            }

            .soxnsox-header-action-btn:hover {
                background-color: #e9f2fa !important;
                color: #1d5b8f !important;
            }

            /* SOXNSOX Footer Layout & Precision Alignment */
            .soxnsox-footer-grid {
                display: grid !important;
                grid-template-columns: 1fr !important;
                gap: 2.5rem !important;
                align-items: start !important;
                width: 100% !important;
            }

            @media (min-width: 640px) {
                .soxnsox-footer-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                    gap: 2rem !important;
                }
                .soxnsox-footer-col-brand {
                    grid-column: span 2 !important;
                }
                .soxnsox-footer-col-newsletter {
                    grid-column: span 2 !important;
                }
            }

            @media (min-width: 1024px) {
                .soxnsox-footer-grid {
                    grid-template-columns: 2.8fr 1.5fr 1.7fr 1.5fr 2.7fr !important;
                    gap: 2rem !important;
                }
                .soxnsox-footer-col-brand {
                    grid-column: auto !important;
                }
                .soxnsox-footer-col-newsletter {
                    grid-column: auto !important;
                }
            }

            @media (min-width: 1280px) {
                .soxnsox-footer-grid {
                    grid-template-columns: 3fr 1.5fr 1.7fr 1.5fr 2.8fr !important;
                    gap: 2.5rem !important;
                }
            }

            .soxnsox-footer-heading {
                font-family: 'Poppins', sans-serif !important;
                font-size: 0.8125rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.08em !important;
                text-transform: uppercase !important;
                height: 24px !important;
                line-height: 24px !important;
                display: flex !important;
                align-items: center !important;
                white-space: nowrap !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .soxnsox-footer-accent-line {
                width: 36px !important;
                height: 2px !important;
                border-radius: 9999px !important;
                margin-top: 0.5rem !important;
                margin-bottom: 1.25rem !important;
            }

            .soxnsox-accent-amber {
                background-color: rgba(242, 154, 56, 0.45) !important;
            }

            .soxnsox-accent-teal {
                background-color: rgba(44, 167, 163, 0.45) !important;
            }

            .soxnsox-footer-dot {
                width: 3px !important;
                height: 3px !important;
                border-radius: 9999px !important;
                background-color: rgba(245, 247, 250, 0.35) !important;
                display: inline-block !important;
                flex-shrink: 0 !important;
            }

            /* Stars and Rating Accents in Radiant Amber #f29a38 */
            .icon-star-fill, 
            .icon-star,
            [class*="icon-star"],
            .rating-star {
                color: #f29a38 !important;
            }

            /* Award-Winning Micro-Animations */
            @keyframes soxnsoxFadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(16px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .soxnsox-card-hover {
                transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
            }

            .soxnsox-card-hover:hover {
                transform: translateY(-5px) !important;
                box-shadow: 0 20px 40px -10px rgba(19, 59, 99, 0.12) !important;
                border-color: rgba(44, 167, 163, 0.4) !important;
            }

            /* Medical Socks Showcase Cards Hover Styling */
            .soxnsox-medical-img-wrapper {
                background: linear-gradient(to bottom, #f8fafc, #f1f5f9) !important;
                border: 1px solid #e2e8f0 !important;
                transition: all 0.4s ease !important;
            }

            .soxnsox-medical-card-teal:hover {
                border-color: #2ca7a3 !important;
                box-shadow: 0 20px 40px -10px rgba(44, 167, 163, 0.22) !important;
            }
            .soxnsox-medical-card-teal:hover .soxnsox-medical-img-wrapper {
                background: linear-gradient(to bottom, #f0fdfa, #e6f8f7) !important;
                border-color: rgba(44, 167, 163, 0.45) !important;
            }
            .soxnsox-medical-card-teal:hover .soxnsox-medical-heading,
            .soxnsox-medical-card-teal:hover .soxnsox-medical-link {
                color: #2ca7a3 !important;
            }
            .soxnsox-medical-card-teal:hover .soxnsox-card-arrow {
                background-color: #2ca7a3 !important;
                color: #ffffff !important;
            }

            .soxnsox-medical-card-amber:hover {
                border-color: #f29a38 !important;
                box-shadow: 0 20px 40px -10px rgba(242, 154, 56, 0.25) !important;
            }
            .soxnsox-medical-card-amber:hover .soxnsox-medical-img-wrapper {
                background: linear-gradient(to bottom, #fffbeb, #fef3c7) !important;
                border-color: rgba(242, 154, 56, 0.5) !important;
            }
            .soxnsox-medical-card-amber:hover .soxnsox-medical-heading,
            .soxnsox-medical-card-amber:hover .soxnsox-medical-link {
                color: #f29a38 !important;
            }
            .soxnsox-medical-card-amber:hover .soxnsox-card-arrow {
                background-color: #f29a38 !important;
                color: #ffffff !important;
            }

            .soxnsox-medical-card-navy:hover {
                border-color: #1d5b8f !important;
                box-shadow: 0 20px 40px -10px rgba(29, 91, 143, 0.25) !important;
            }
            .soxnsox-medical-card-navy:hover .soxnsox-medical-img-wrapper {
                background: linear-gradient(to bottom, #f0f9ff, #e0f2fe) !important;
                border-color: rgba(29, 91, 143, 0.45) !important;
            }
            .soxnsox-medical-card-navy:hover .soxnsox-medical-heading,
            .soxnsox-medical-card-navy:hover .soxnsox-medical-link {
                color: #1d5b8f !important;
            }
            .soxnsox-medical-card-navy:hover .soxnsox-card-arrow {
                background-color: #1d5b8f !important;
                color: #ffffff !important;
            }

            /* SOX N SOX Luxury Button Shimmer Light-Sweep */
            .soxnsox-btn-shimmer {
                position: relative !important;
                overflow: hidden !important;
            }
            .soxnsox-btn-shimmer::before {
                content: '' !important;
                position: absolute !important;
                top: -50% !important;
                left: -60% !important;
                width: 40% !important;
                height: 200% !important;
                background: linear-gradient(
                    to right,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.42) 50%,
                    rgba(255, 255, 255, 0) 100%
                ) !important;
                transform: rotate(25deg) translateX(-150%) !important;
                transition: transform 0.85s ease !important;
                pointer-events: none !important;
                z-index: 10 !important;
            }
            .soxnsox-btn-shimmer:hover::before {
                transform: rotate(25deg) translateX(550%) !important;
            }

            /* Floating Keyframe Animations */
            @keyframes soxnsoxFloat {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }
            @keyframes soxnsoxFloatSlow {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-12px) rotate(2deg); }
            }
            @keyframes soxnsoxPulseGlow {
                0%, 100% { opacity: 0.55; transform: scale(1); }
                50% { opacity: 0.95; transform: scale(1.06); }
            }
            @keyframes soxnsoxHeartbeat {
                0%, 100% { transform: scale(1); }
                14% { transform: scale(1.22); }
                28% { transform: scale(1); }
                42% { transform: scale(1.22); }
                70% { transform: scale(1); }
            }
            @keyframes heroTextGradient {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }
            @keyframes heroFadeDown {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes heroFadeUp {
                from { opacity: 0; transform: translateY(28px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes heroBadgePop {
                0% { opacity: 0; transform: scale(0.85) translateY(16px); }
                70% { opacity: 1; transform: scale(1.04) translateY(-2px); }
                100% { opacity: 1; transform: scale(1) translateY(0); }
            }
            @keyframes orbFloat1 {
                0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.35; }
                50% { transform: translate(30px, -20px) scale(1.15); opacity: 0.55; }
            }
            @keyframes orbFloat2 {
                0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.25; }
                50% { transform: translate(-25px, 25px) scale(1.1); opacity: 0.45; }
            }

            .animate-soxnsox-float {
                animation: soxnsoxFloat 4s ease-in-out infinite !important;
            }
            .animate-soxnsox-float-slow {
                animation: soxnsoxFloatSlow 6s ease-in-out infinite !important;
            }
            .animate-soxnsox-pulse-glow {
                animation: soxnsoxPulseGlow 3.5s ease-in-out infinite !important;
            }
            .animate-soxnsox-heartbeat {
                animation: soxnsoxHeartbeat 2.4s ease-in-out infinite !important;
            }
            .soxnsox-orb-1 {
                animation: orbFloat1 8s ease-in-out infinite !important;
            }
            .soxnsox-orb-2 {
                animation: orbFloat2 10s ease-in-out infinite !important;
            }

            /* Gradient Text Shimmer */
            .soxnsox-text-shimmer {
                background: linear-gradient(90deg, #2ca7a3 0%, #4ddcd7 30%, #f29a38 50%, #4ddcd7 70%, #2ca7a3 100%) !important;
                background-size: 200% auto !important;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent !important;
                animation: heroTextGradient 6s ease-in-out infinite !important;
            }

            /* Section Heading Decorative Line Expander */
            .soxnsox-heading-accent {
                position: relative;
                display: inline-block;
            }
            .soxnsox-heading-accent::after {
                content: '';
                display: block;
                width: 0;
                height: 3px;
                border-radius: 9999px;
                background: linear-gradient(90deg, #2ca7a3 0%, #f29a38 100%);
                margin: 1.375rem auto 0.5rem auto;
                transition: width 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.15s;
            }
            .is-revealed .soxnsox-heading-accent::after,
            .is-revealed.soxnsox-heading-accent::after,
            .soxnsox-heading-accent.is-active::after {
                width: 72px;
            }

            /* Left-Aligned Heading Decorative Line */
            .soxnsox-heading-accent.text-left::after,
            .text-left .soxnsox-heading-accent::after,
            .text-left.soxnsox-heading-accent::after,
            .soxnsox-heading-accent-left::after {
                margin: 1.375rem auto 0.5rem 0 !important;
            }

            /* Category Cards 3D Interactive Hover */
            .soxnsox-category-card {
                perspective: 1000px;
                transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.45s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.45s ease !important;
            }
            .soxnsox-category-card:hover {
                transform: translateY(-8px) scale(1.015) !important;
            }
            .soxnsox-cat-glow-teal:hover {
                border-color: #2ca7a3 !important;
                box-shadow: 0 25px 50px -12px rgba(44, 167, 163, 0.28), 0 0 0 1px rgba(44, 167, 163, 0.4) !important;
            }
            .soxnsox-cat-glow-navy:hover {
                border-color: #1d5b8f !important;
                box-shadow: 0 25px 50px -12px rgba(29, 91, 143, 0.28), 0 0 0 1px rgba(29, 91, 143, 0.4) !important;
            }
            .soxnsox-cat-glow-amber:hover {
                border-color: #f29a38 !important;
                box-shadow: 0 25px 50px -12px rgba(242, 154, 56, 0.28), 0 0 0 1px rgba(242, 154, 56, 0.4) !important;
            }

            /* Product & Blog Card Image Sheen */
            .soxnsox-image-shimmer {
                position: relative !important;
                overflow: hidden !important;
            }
            .soxnsox-image-shimmer::after {
                content: '' !important;
                position: absolute !important;
                inset: 0 !important;
                background: linear-gradient(
                    105deg,
                    transparent 0%,
                    rgba(255, 255, 255, 0) 35%,
                    rgba(255, 255, 255, 0.24) 50%,
                    rgba(255, 255, 255, 0) 65%,
                    transparent 100%
                ) !important;
                transform: translateX(-100%) !important;
                transition: transform 0.85s ease-out !important;
                pointer-events: none !important;
                z-index: 5 !important;
            }
            .group:hover .soxnsox-image-shimmer::after,
            .soxnsox-image-shimmer:hover::after {
                transform: translateX(100%) !important;
            }

            /* Stat Numbers Text Glow */
            .soxnsox-stat-card {
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s ease !important;
            }
            .soxnsox-stat-card:hover {
                transform: translateY(-8px) !important;
                border-color: rgba(44, 167, 163, 0.7) !important;
                box-shadow: 0 25px 50px -12px rgba(44, 167, 163, 0.25) !important;
            }
            .soxnsox-stat-card:hover .soxnsox-stat-num {
                text-shadow: 0 0 24px rgba(44, 167, 163, 0.8) !important;
                transform: scale(1.08) !important;
            }
            .soxnsox-stat-num {
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), text-shadow 0.3s ease !important;
            }

            /* Scroll Reveal Engine Styles */
            .reveal-on-scroll {
                opacity: 0;
                transform: translateY(28px);
                transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
                will-change: opacity, transform;
            }
            .reveal-on-scroll.reveal-down { transform: translateY(-28px); }
            .reveal-on-scroll.reveal-left { transform: translateX(-32px); }
            .reveal-on-scroll.reveal-right { transform: translateX(32px); }
            .reveal-on-scroll.reveal-scale { transform: scale(0.92); }
            .reveal-on-scroll.is-revealed {
                opacity: 1 !important;
                transform: translate(0, 0) scale(1) !important;
            }

            .reveal-stagger > * {
                opacity: 0;
                transform: translateY(24px);
                transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, border-color 0.3s ease;
                will-change: opacity, transform;
            }
            .reveal-stagger.is-revealed > *:nth-child(1) { transition-delay: 0.05s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }
            .reveal-stagger.is-revealed > *:nth-child(2) { transition-delay: 0.15s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }
            .reveal-stagger.is-revealed > *:nth-child(3) { transition-delay: 0.25s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }
            .reveal-stagger.is-revealed > *:nth-child(4) { transition-delay: 0.35s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }
            .reveal-stagger.is-revealed > *:nth-child(5) { transition-delay: 0.45s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }
            .reveal-stagger.is-revealed > *:nth-child(6) { transition-delay: 0.55s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }
            .reveal-stagger.is-revealed > *:nth-child(7) { transition-delay: 0.65s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }
            .reveal-stagger.is-revealed > *:nth-child(8) { transition-delay: 0.75s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }
            .reveal-stagger.is-revealed > *:nth-child(n+9) { transition-delay: 0.85s; opacity: 1 !important; transform: translate(0, 0) scale(1) !important; }

            @media (prefers-reduced-motion: reduce) {
                .reveal-on-scroll,
                .reveal-stagger > *,
                .animate-soxnsox-float,
                .animate-soxnsox-float-slow,
                .animate-soxnsox-pulse-glow,
                .animate-soxnsox-heartbeat,
                .soxnsox-orb-1,
                .soxnsox-orb-2 {
                    opacity: 1 !important;
                    transform: none !important;
                    transition: none !important;
                    animation: none !important;
                }
            }

            {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
        </style>

        @stack('styles')

        @if(core()->getConfigData('general.content.speculation_rules.enabled'))
            <script type="speculationrules">
                @json(core()->getSpeculationRules(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            </script>
        @endif

        {!! view_render_event('bagisto.shop.layout.head.after') !!}

    </head>

    <body class="bg-[#f5f7fa] text-[#133b63] font-sans antialiased selection:bg-[#133b63] selection:text-white">
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        <a
            href="#main"
            class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-6 focus:py-3 focus:bg-[#133b63] focus:text-white focus:shadow-xl focus:rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2ca7a3] font-semibold text-sm transition-all"
        >
            Skip to main content
        </a>

        <!-- Built With Bagisto -->
        <div id="app" class="min-h-screen flex flex-col justify-between">
            <!-- Flash Message Blade Component -->
            <x-shop::flash-group />

            <!-- Confirm Modal Blade Component -->
            <x-shop::modal.confirm />

            <!-- Page Header Blade Component -->
            @if ($hasHeader)
                <x-shop::layouts.header />
            @endif

            {!! view_render_event('bagisto.shop.layout.content.before') !!}

            <!-- Page Content Blade Component -->
            <main id="main" class="flex-grow bg-[#f5f7fa]">
                {{ $slot }}
            </main>

            {!! view_render_event('bagisto.shop.layout.content.after') !!}

            <!-- Page Services Blade Component -->
            @if ($hasFeature)
                <x-shop::layouts.services />
            @endif

            <!-- Global Quick View Modal -->
            <x-shop::products.quick-view />

            <!-- Global Back to Top Button -->
            <x-shop::layouts.back-to-top />

            <!-- Page Footer Blade Component -->
            @if ($hasFooter)
                <x-shop::layouts.footer />
            @endif
        </div>

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        <!-- WebMCP Tool Registration For AI Agents -->
        <x-shop::layouts.webmcp />

        @stack('scripts')

        {!! view_render_event('bagisto.shop.layout.vue-app-mount.before') !!}
        <script>
            /**
             * Mount the application as soon as the DOM is ready instead of waiting
             * for the `load` event. All `Vue` components are registered through
             * deferred `type="module"` scripts, which always finish executing
             * before `DOMContentLoaded` fires, so every component is available
             * by the time `app.mount()` runs. Mounting on `DOMContentLoaded`
             * avoids blocking the storefront behind every image/font download.
             */
            function mountApp() {
                app.mount("#app");
            }

            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", mountApp);
            } else {
                mountApp();
            }
        </script>

        {!! view_render_event('bagisto.shop.layout.vue-app-mount.after') !!}

        <script type="text/javascript">
            {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

                // ── 1. Scroll Reveal Engine (IntersectionObserver) ──
                const setupRevealObserver = () => {
                    const elements = document.querySelectorAll('.reveal-on-scroll, .reveal-stagger');
                    if (!elements.length) return;

                    if ('IntersectionObserver' in window) {
                        const observer = new IntersectionObserver((entries, obs) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    entry.target.classList.add('is-revealed');
                                    obs.unobserve(entry.target);
                                }
                            });
                        }, {
                            rootMargin: '0px 0px -40px 0px',
                            threshold: 0.05
                        });

                        elements.forEach(el => observer.observe(el));

                        // Observe new nodes dynamically injected by Vue
                        const mutObserver = new MutationObserver((mutations) => {
                            mutations.forEach((mutation) => {
                                mutation.addedNodes.forEach((node) => {
                                    if (node.nodeType === 1) {
                                        if (node.matches && (node.matches('.reveal-on-scroll') || node.matches('.reveal-stagger'))) {
                                            observer.observe(node);
                                        }
                                        if (node.querySelectorAll) {
                                            node.querySelectorAll('.reveal-on-scroll, .reveal-stagger').forEach(child => {
                                                observer.observe(child);
                                            });
                                        }
                                    }
                                });
                            });
                        });

                        const appRoot = document.getElementById('app') || document.body;
                        mutObserver.observe(appRoot, { childList: true, subtree: true });
                    } else {
                        elements.forEach(el => el.classList.add('is-revealed'));
                    }
                };

                // ── 2. Dynamic Sticky Header Translucency on Scroll ──
                const setupHeaderScroll = () => {
                    const header = document.querySelector('header');
                    if (!header) return;

                    const handleScroll = () => {
                        if (window.scrollY > 20) {
                            header.classList.add('is-scrolled');
                        } else {
                            header.classList.remove('is-scrolled');
                        }
                    };

                    window.addEventListener('scroll', handleScroll, { passive: true });
                    handleScroll();
                };

                setupRevealObserver();
                setupHeaderScroll();

                // Failsafe: Ensure top items or any missed elements are always displayed
                setTimeout(() => {
                    document.querySelectorAll('.reveal-on-scroll:not(.is-revealed), .reveal-stagger:not(.is-revealed)').forEach(el => {
                        const rect = el.getBoundingClientRect();
                        if (rect.top < window.innerHeight + 200) {
                            el.classList.add('is-revealed');
                        }
                    });
                }, 1200);
            });

            window.getSoxnsoxAvatar = function(name, size, rounded) {
                size = size || 80;
                rounded = rounded !== false;
                name = (name || 'U').trim();
                const initial = name.charAt(0).toUpperCase() || 'U';
                const palette = [
                    '#133b63', '#2ca7a3', '#d97706', '#059669',
                    '#7c3aed', '#2563eb', '#dc2626', '#db2777',
                    '#ea580c', '#0891b2', '#4f46e5', '#0d9488'
                ];
                let hash = 0;
                const lower = name.toLowerCase();
                for (let i = 0; i < lower.length; i++) {
                    hash = lower.charCodeAt(i) + ((hash << 5) - hash);
                }
                const color = palette[Math.abs(hash) % palette.length];
                const rx = rounded ? '50%' : '20%';
                const fontSize = Math.round(size * 0.48);
                const encodedColor = encodeURIComponent(color);
                return `data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 ${size} ${size}' width='${size}' height='${size}'><rect width='${size}' height='${size}' rx='${rx}' fill='${encodedColor}'/><text x='50%' y='54%' dominant-baseline='middle' text-anchor='middle' fill='%23ffffff' font-family='Plus Jakarta Sans, -apple-system, sans-serif' font-size='${fontSize}' font-weight='700'>${initial}</text></svg>`;
            };

            if (typeof app !== 'undefined' && app.config) {
                app.config.globalProperties.getSoxnsoxAvatar = window.getSoxnsoxAvatar;
            }
        </script>
    </body>
</html>
