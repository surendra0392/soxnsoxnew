<!DOCTYPE html>

<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>

<head>
    {!! view_render_event('bagisto.admin.layout.head.before') !!}

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
        content="{{ core()->getBaseCurrency()->toJson() }}"
    >
    <meta
        name="generator"
        content="SOXNSOX"
    >

    @stack('meta')

    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap"
        rel="stylesheet"
    />

    <!-- Font Awesome 6 Free & Lucide Icons Providers -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/lucide@latest"></script>

    @php
        $adminFavicon = core()->getConfigData('general.design.admin_logo.favicon');
        $adminFaviconUrl = ($adminFavicon && file_exists(public_path('storage/' . $adminFavicon)))
            ? asset('storage/' . $adminFavicon)
            : (file_exists(public_path('favicon.png')) ? asset('favicon.png') : asset('favicon.ico'));
        $adminFaviconIco = file_exists(public_path('favicon.ico')) ? asset('favicon.ico') : $adminFaviconUrl;
    @endphp

    <link rel="icon" type="image/x-icon" href="{{ $adminFaviconIco }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $adminFaviconUrl }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $adminFaviconUrl }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ $adminFaviconIco }}" />

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    />
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet"
    />

    @stack('styles')

    <style>
        :root {
            --nexus-bg: #F8FAFC;
            --nexus-surface: #FFFFFF;
            --nexus-surface-hover: #F1F5F9;
            --nexus-border: rgba(0, 0, 0, 0.08);
            --nexus-border-focus: #133b63;
            --nexus-primary: #133b63;
            --nexus-primary-hover: #0d2847;
            --nexus-accent: #2ca7a3;
            --nexus-text-primary: #0F172A;
            --nexus-text-secondary: #64748B;
            --nexus-text-muted: #94A3B8;
            --nexus-card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 6px 16px -2px rgba(0, 0, 0, 0.03);
            --nexus-radius-card: 14px;
            --nexus-radius-control: 12px;
            --nexus-radius-pill: 9999px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            letter-spacing: -0.01em;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Inter', sans-serif !important;
            letter-spacing: -0.02em;
        }

        .font-mono, .mono-data, .font-mono-numbers {
            font-family: 'JetBrains Mono', monospace !important;
        }

        /* Nexus Bento Card Surface */
        .box-shadow, [class*="box-shadow"], .nexus-card {
            background-color: var(--nexus-surface) !important;
            border: 1px solid var(--nexus-border) !important;
            border-radius: 14px !important;
            box-shadow: var(--nexus-card-shadow) !important;
        }

        /* Color Overrides: Brand Palette */
        .bg-brand,
        .bg-[#133b63] {
            background-color: #133b63 !important;
        }

        .text-brand,
        .text-[#133b63] {
            color: #133b63 !important;
        }

        .border-brand,
        .border-[#133b63] {
            border-color: #133b63 !important;
        }

        /* Action Buttons */
        .primary-button,
        button.primary-button,
        a.primary-button,
        .btn-primary {
            background: linear-gradient(135deg, #133b63 0%, #0d2847 100%) !important;
            color: #FFFFFF !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            padding: 0.5rem 1.15rem !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 2px 8px -1px rgba(32, 81, 50, 0.3) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
        }

        .primary-button:hover,
        button.primary-button:hover,
        a.primary-button:hover,
        .btn-primary:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .secondary-button,
        button.secondary-button,
        a.secondary-button {
            background-color: #FFFFFF !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            color: #334155 !important;
            border-radius: 12px !important;
            padding: 0.5rem 1.15rem !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
            transition: all 0.2s ease !important;
        }

        .secondary-button:hover,
        button.secondary-button:hover,
        a.secondary-button:hover {
            background-color: #F8FAFC !important;
            border-color: rgba(0, 0, 0, 0.2) !important;
            color: #0F172A !important;
            transform: translateY(-1px);
        }

        .transparent-button {
            border-radius: 12px !important;
            color: var(--nexus-text-secondary) !important;
            transition: all 0.2s ease !important;
        }

        .transparent-button:hover {
            background-color: rgba(0, 0, 0, 0.04) !important;
            color: var(--nexus-text-primary) !important;
        }

        /* Form Controls */
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="number"],
        input[type="search"],
        input[type="tel"],
        input[type="url"],
        select,
        textarea {
            background-color: #FFFFFF !important;
            border: 1px solid rgba(0, 0, 0, 0.12) !important;
            border-radius: 12px !important;
            color: #0F172A !important;
            transition: all 0.2s ease !important;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #133b63 !important;
            box-shadow: 0 0 0 3px rgba(32, 81, 50, 0.15) !important;
        }

        input[type="checkbox"]:checked,
        input[type="radio"]:checked {
            background-color: #133b63 !important;
            border-color: #133b63 !important;
        }

        /* Flatpickr input padding guard across all admin forms */
        .flatpickr-input {
            padding-left: 0.875rem !important;
            padding-right: 2.25rem !important;
        }

        [dir="rtl"] .flatpickr-input {
            padding-right: 0.875rem !important;
            padding-left: 2.25rem !important;
        }

        /* DataGrid & Tables */
        table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        thead tr th {
            background-color: #F8FAFC !important;
            color: #64748B !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
            padding: 0.875rem 1rem !important;
        }

        tbody tr {
            transition: background-color 0.15s ease !important;
        }

        tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02) !important;
        }

        tbody tr td {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            padding: 0.875rem 1rem !important;
            color: #334155 !important;
        }

        /* Journal Scrollbar */
        .journal-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
            display: block;
        }

        .journal-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .journal-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 9999px;
        }

        .journal-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.25);
        }

        {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
    </style>

    {!! view_render_event('bagisto.admin.layout.head.after') !!}
</head>

<body class="h-full bg-[#F8FAFC] text-slate-900 font-sans antialiased">
    {!! view_render_event('bagisto.admin.layout.body.before') !!}

    <!-- Built With Bagisto -->
    <div
        id="app"
        class="h-full"
    >
        <!-- Flash Message Blade Component -->
        <x-admin::flash-group />

        <!-- Confirm Modal Blade Component -->
        <x-admin::modal.confirm />

        {!! view_render_event('bagisto.admin.layout.content.before') !!}

        <!-- Page Header Blade Component -->
        <x-admin::layouts.header />

        <div
            class="group/container {{ request()->cookie('sidebar_collapsed') ?? 0 ? 'sidebar-collapsed' : 'sidebar-not-collapsed' }} flex flex-col lg:flex-row gap-0 lg:gap-4"
            ref="appLayout"
        >
            <!-- Page Sidebar Blade Component -->
            <div class="lg:fixed lg:top-[62px] lg:left-0 rtl:lg:right-0 rtl:lg:left-auto lg:z-10 w-full lg:w-auto">
                <x-admin::layouts.sidebar />
            </div>

            <div class="flex min-h-[calc(100vh-62px)] max-w-full flex-1 flex-col bg-[#F8FAFC] transition-all duration-300 pt-3 px-2 sm:px-4 lg:pt-3 lg:px-4 lg:ltr:pl-[286px] lg:group-[.sidebar-collapsed]/container:ltr:pl-[85px] lg:rtl:pr-[286px] lg:group-[.sidebar-collapsed]/container:rtl:pr-[85px]">
                <!-- Added dynamic tabs for third level menus  -->
                <div class="pb-4 lg:pb-6">
                    <!-- Page Content Blade Component -->
                    <div class="w-full overflow-x-hidden">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Copyright Footer -->
                <div class="mt-auto">
                    <div class="border-t border-slate-200 bg-[#F8FAFC] py-3 text-center text-xs sm:text-sm text-slate-500">
                        &copy; {{ date('Y') }} <strong>{{ config('app.name', 'SOXNSOX') }}</strong> — <span class="text-[#133b63] font-semibold">India's Premier Bamboo & Diabetic Socks</span>. All rights reserved.
                    </div>
                </div>
            </div>
        </div>

        {!! view_render_event('bagisto.admin.layout.content.after') !!}
    </div>

    {!! view_render_event('bagisto.admin.layout.body.after') !!}

    @stack('scripts')

    {!! view_render_event('bagisto.admin.layout.vue-app-mount.before') !!}

    <script>
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

        /**
         * Load event, the purpose of using the event is to mount the application
         * after all of our `Vue` components which is present in blade file have
         * been registered in the app. No matter what `app.mount()` should be
         * called in the last.
         */
        window.addEventListener("load", function(event) {
            app.mount("#app");
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

    {!! view_render_event('bagisto.admin.layout.vue-app-mount.after') !!}
</body>

</html>
