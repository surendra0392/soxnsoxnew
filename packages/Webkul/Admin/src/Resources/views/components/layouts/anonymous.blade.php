<!DOCTYPE html>

<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>

<head>
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
        name="generator" 
        content="SOXNSOX"
    >

    @stack('meta')

    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

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
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=DM+Serif+Display&display=swap"
        rel="stylesheet"
    />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

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

    @stack('styles')

    <style>
        {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
    </style>

    {!! view_render_event('bagisto.admin.layout.head') !!}
</head>

<body>
    {!! view_render_event('bagisto.admin.layout.body.before') !!}

    <!-- Built With Bagisto -->
    <div id="app">
        <!-- Flash Message Blade Component -->
        <x-admin::flash-group />

        {!! view_render_event('bagisto.admin.layout.content.before') !!}

        <!-- Page Content Blade Component -->
        {{ $slot }}

        {!! view_render_event('bagisto.admin.layout.content.after') !!}
    </div>

    {!! view_render_event('bagisto.admin.layout.body.after') !!}

    @stack('scripts')

    {!! view_render_event('bagisto.admin.layout.vue-app-mount.before') !!}

    <script>
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

    <script type="text/javascript">
        {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
    </script>
</body>

</html>
