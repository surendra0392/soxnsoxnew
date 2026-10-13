@php
    $channel = core()->getCurrentChannel();
    $logoUrl = ($channel->logo && file_exists(public_path('storage/' . $channel->logo)))
        ? asset('storage/' . $channel->logo)
        : (file_exists(public_path('logo.png'))
            ? asset('logo.png')
            : ($channel->logo_url ?: null));
    $showCompare = (bool) core()->getConfigData('catalog.products.settings.compare_option');
    $showWishlist = (bool) core()->getConfigData('customer.settings.wishlist.wishlist_option');
@endphp

<div class="flex flex-wrap gap-4 px-4 pt-4 pb-4 shadow-sm lg:hidden bg-white border-b border-slate-200">
    <div class="flex items-center justify-between w-full">
        <!-- Left Navigation -->
        <div class="flex items-center gap-x-2">
            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.before') !!}

            <!-- Drawer -->
            <v-mobile-drawer></v-mobile-drawer>

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.logo.before') !!}

            <a
                href="{{ route('shop.home.index') }}"
                class="flex items-center py-1 group"
                aria-label="SOXNSOX - Bamboo Socks"
            >
                @if ($logoUrl)
                    <img
                        src="{{ $logoUrl }}"
                        alt="SOX N SOX - India's Premier Bamboo &amp; Diabetic Socks"
                        class="h-8 sm:h-9 w-auto object-contain max-w-[160px]"
                    />
                @else
                    <div class="flex flex-col">
                        <span class="font-display text-2xl font-black tracking-tight text-[#133b63]">
                            SOX<span class="text-[#f29a38]">N</span>SOX
                        </span>
                        <span class="text-[8px] tracking-[0.25em] uppercase text-[#2ca7a3] -mt-1 font-sans font-bold">
                            Bamboo Socks
                        </span>
                    </div>
                @endif
            </a>

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.logo.after') !!}
        </div>

        <!-- Right Navigation -->
        <div>
            <div class="flex items-center gap-x-1 sm:gap-x-2">
                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.compare.before') !!}

                @if($showCompare)
                    <a
                        href="{{ route('shop.compare.index') }}"
                        aria-label="@lang('shop::app.components.layouts.header.mobile.compare')"
                        class="flex h-10 w-10 items-center justify-center rounded-full text-[#133b63] hover:bg-black/5 hover:text-[#1d5b8f] transition-colors focus:outline-none"
                    >
                        <i class="fa-solid fa-code-compare text-lg"></i>
                    </a>
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.compare.after') !!}

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.mini_cart.before') !!}

                @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    @include('shop::checkout.cart.mini-cart')
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.mini_cart.after') !!}

                <!-- For Large screens -->
                <div class="max-md:hidden">
                    <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                        <x-slot:toggle>
                            <button
                                type="button"
                                class="flex h-10 w-10 items-center justify-center rounded-full text-[#133b63] hover:bg-black/5 hover:text-[#1d5b8f] transition-colors focus:outline-none"
                                aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.profile')"
                            >
                                <i class="fa-regular fa-user text-lg"></i>
                            </button>
                        </x-slot>

                            <!-- Guest Dropdown -->
                            @guest('customer')
                                <x-slot:content>
                                    <div class="grid gap-2.5">
                                        <p class="text-lg font-display font-bold text-[#133b63]">
                                            @lang('shop::app.components.layouts.header.mobile.welcome-guest')
                                        </p>

                                        <p class="text-sm">
                                            @lang('shop::app.components.layouts.header.mobile.dropdown-text')
                                        </p>
                                    </div>

                                    <p class="w-full mt-3 border border-zinc-200"></p>

                                    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.customers_action.before') !!}

                                    <div class="flex gap-3 mt-4">
                                        {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.sign_in_button.before') !!}

                                        <a
                                            href="{{ route('shop.customer.session.create') }}"
                                            class="soxnsox-btn-primary soxnsox-btn-shimmer !py-2.5 !px-5 text-xs uppercase tracking-wider font-bold rounded-full"
                                        >
                                            @lang('shop::app.components.layouts.header.mobile.sign-in')
                                        </a>

                                        <a
                                            href="{{ route('shop.customers.register.index') }}"
                                            class="soxnsox-btn-outline soxnsox-btn-shimmer !py-2.5 !px-5 text-xs uppercase tracking-wider font-bold rounded-full"
                                        >
                                            @lang('shop::app.components.layouts.header.mobile.sign-up')
                                        </a>

                                        {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.sign_in_button.after') !!}
                                    </div>

                                    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.customers_action.after') !!}
                                    </x-slot>
                            @endguest

                                <!-- Customers Dropdown -->
                                @auth('customer')
                                    <x-slot:content class="!p-0">
                                        <div class="grid gap-2.5 p-5 pb-0">
                                            <p class="text-lg font-display font-bold text-[#133b63]" v-pre>
                                        @lang('shop::app.components.layouts.header.mobile.welcome')’
                                                {{ auth()->guard('customer')->user()->first_name }}
                                            </p>

                                            <p class="text-sm">
                                                @lang('shop::app.components.layouts.header.mobile.dropdown-text')
                                            </p>
                                        </div>

                                        <p class="w-full mt-3 border border-zinc-200"></p>

                                        <div class="mt-2.5 grid gap-1 pb-2.5">
                                            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.profile_dropdown.links.before') !!}

                                    <a
                                        class="px-5 py-2 text-base cursor-pointer"
                                        href="{{ route('shop.customers.account.profile.index') }}"
                                    >
                                                @lang('shop::app.components.layouts.header.mobile.profile')
                                            </a>

                                    <a
                                        class="px-5 py-2 text-base cursor-pointer"
                                        href="{{ route('shop.customers.account.orders.index') }}"
                                    >
                                                @lang('shop::app.components.layouts.header.mobile.orders')
                                            </a>

                                            @if ($showWishlist)
                                        <a
                                            class="px-5 py-2 text-base cursor-pointer"
                                            href="{{ route('shop.customers.account.wishlist.index') }}"
                                        >
                                                    @lang('shop::app.components.layouts.header.mobile.wishlist')
                                                </a>
                                            @endif

                                            <!--Customers logout-->
                                            @auth('customer')
                                        <x-shop::form
                                            method="DELETE"
                                            action="{{ route('shop.customer.session.destroy') }}"
                                            id="customerLogout"
                                        />

                                        <a
                                            class="px-5 py-2 text-base cursor-pointer"
                                                    href="{{ route('shop.customer.session.destroy') }}"
                                            onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                        >
                                                    @lang('shop::app.components.layouts.header.mobile.logout')
                                                </a>
                                            @endauth

                                            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.profile_dropdown.links.after') !!}
                                        </div>
                                        </x-slot>
                                @endauth
                    </x-shop::dropdown>
                </div>

                <!-- For Medium and small screen -->
                <div class="md:hidden">
                    @guest('customer')
                        <a
                            href="{{ route('shop.customer.session.create') }}"
                            aria-label="@lang('shop::app.components.layouts.header.mobile.account')"
                            class="flex h-9 w-9 items-center justify-center text-[#133b63]"
                        >
                            <i class="fa-regular fa-user text-lg"></i>
                        </a>
                    @endguest

                    <!-- Customers Dropdown -->
                    @auth('customer')
                        <a
                            href="{{ route('shop.customers.account.index') }}"
                            aria-label="@lang('shop::app.components.layouts.header.mobile.account')"
                            class="flex h-9 w-9 items-center justify-center text-[#133b63]"
                        >
                            <i class="fa-regular fa-user text-lg"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.search.before') !!}

    <!-- Serach Catalog Form -->
    <form action="{{ route('shop.search.index') }}" class="flex items-center w-full">
        <label
            for="mobile-search"
            class="sr-only"
        >
            @lang('shop::app.components.layouts.header.mobile.search')
        </label>

        <div class="relative w-full">
            <div class="pointer-events-none absolute top-3.5 flex items-center text-gray-400 text-sm ltr:left-3.5 rtl:right-3.5">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <input
                type="text"
                class="block w-full rounded-xl border border-['#E3E3E3'] px-11 py-3.5 text-sm font-medium text-gray-900 max-md:rounded-lg max-md:px-10 max-md:py-3 max-md:font-normal max-sm:text-xs"
                name="query"
                value="{{ request('query') }}"
                placeholder="@lang('shop::app.components.layouts.header.mobile.search-text')"
                required
            >

            @if (core()->getConfigData('catalog.products.settings.image_search'))
                @include('shop::search.images.index')
            @endif
        </div>
    </form>

    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.search.after') !!}
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-mobile-drawer-template">
        <x-shop::drawer
            position="left"
            width="340px"
        >
            <x-slot:toggle>
                <button
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-full text-soxnsox-charcoal hover:bg-black/5 hover:text-soxnsox-teal transition-colors focus:outline-none focus:ring-2 focus:ring-soxnsox-teal"
                    aria-label="Open Navigation"
                >
                    <i class="fa-solid fa-bars text-lg cursor-pointer"></i>
                </button>
            </x-slot>

            <x-slot:header>
                <div class="flex items-center justify-between py-1">
                    <a href="{{ route('shop.home.index') }}" class="flex items-center">
                        @if ($logoUrl)
                            <img
                                src="{{ $logoUrl }}"
                                alt="SOX N SOX - India's Premier Bamboo &amp; Diabetic Socks"
                                class="h-8 w-auto object-contain max-w-[120px]"
                            />
                        @else
                            <div class="flex flex-col">
                                <span class="font-display text-2xl font-black tracking-tight text-[#133b63]">
                                    SOX<span class="text-[#f29a38]">N</span>SOX
                                </span>
                                <span class="text-[8px] tracking-[0.25em] uppercase text-[#2ca7a3] -mt-1 font-sans font-bold">
                                    Bamboo Socks
                                </span>
                            </div>
                        @endif
                    </a>
                </div>
            </x-slot>

            <x-slot:content class="!p-0">
                <!-- Primary SOXNSOX Navigation -->
                <nav class="px-6 py-6 border-b border-soxnsox-border/70 space-y-1" aria-label="Mobile Primary Navigation">
                    @php
                        $categoryView = core()->getConfigData('general.design.categories.category_view');
                    @endphp

                    @if ($categoryView === 'custom')
                        @php
                            $customMenuItems = json_decode(core()->getConfigData('general.design.categories.custom_menu_items') ?: '[]', true);
                            
                            $catIds = collect($customMenuItems)->where('type', 'category')->pluck('id')->toArray();
                            $cmsIds = collect($customMenuItems)->where('type', 'cms')->pluck('id')->toArray();
                            
                            $categories = empty($catIds) ? collect() : app(\Webkul\Category\Repositories\CategoryRepository::class)->findWhereIn('id', $catIds)->keyBy('id');
                            $cmsPages = empty($cmsIds) ? collect() : app(\Webkul\CMS\Repositories\PageRepository::class)->query()
                                ->select('cms_pages.*', 'cms_page_translations.url_key')
                                ->join('cms_page_translations', 'cms_pages.id', '=', 'cms_page_translations.cms_page_id')
                                ->whereIn('cms_page_translations.url_key', $cmsIds)
                                ->where('cms_page_translations.locale', core()->getRequestedLocaleCode())
                                ->get()
                                ->keyBy('url_key');
                        @endphp

                        @foreach ($customMenuItems as $item)
                            @if ($item['type'] === 'cms' && isset($cmsPages[$item['id']]))
                                @php $pageTranslation = $cmsPages[$item['id']]->translate(core()->getRequestedLocaleCode()); @endphp
                                @if ($pageTranslation)
                                    <a href="{{ route('shop.cms.page', $pageTranslation->url_key) }}" class="flex items-center justify-between py-3 text-sm font-semibold uppercase tracking-wider {{ request()->is('page/'.$pageTranslation->url_key.'*') || request()->is($pageTranslation->url_key.'*') ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} border-b border-slate-100 transition-colors">
                                        <span>{{ $item['title'] ?? $pageTranslation->page_title }}</span>
                                        <i class="fa-solid fa-chevron-right text-xs text-[#6b7280]"></i>
                                    </a>
                                @endif
                            @elseif ($item['type'] === 'category' && isset($categories[$item['id']]))
                                @php $categoryTranslation = $categories[$item['id']]->translate(core()->getRequestedLocaleCode()); @endphp
                                @if ($categoryTranslation)
                                    @php $categoryUrl = $categoryTranslation->url_path ?: $categoryTranslation->slug; @endphp
                                    <a href="{{ $categoryUrl ? route('shop.product_or_category.index', $categoryUrl) : '#' }}" class="flex items-center justify-between py-3 text-sm font-semibold uppercase tracking-wider {{ request()->is($categoryUrl.'*') ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} border-b border-slate-100 transition-colors">
                                        <span>{!! $item['title'] ?? $categoryTranslation->name !!}</span>
                                        <i class="fa-solid fa-chevron-right text-xs text-[#6b7280]"></i>
                                    </a>
                                @endif
                            @elseif ($item['type'] === 'custom')
                                @php
                                    $targetPath = trim(parse_url($item['url'], PHP_URL_PATH) ?? '', '/');
                                    $isCustomActive = request()->fullUrlIs($item['url'].'*') || ($targetPath && request()->is($targetPath.'*'));
                                @endphp
                                <a href="{{ $item['url'] }}" class="flex items-center justify-between py-3 text-sm font-semibold uppercase tracking-wider {{ $isCustomActive ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} border-b border-slate-100 transition-colors">
                                    <span>{{ $item['title'] }}</span>
                                    <i class="fa-solid fa-chevron-right text-xs text-[#6b7280]"></i>
                                </a>
                            @endif
                        @endforeach
                    @else
                        <a
                            href="{{ route('shop.home.index') }}"
                            class="flex items-center justify-between py-3 text-sm font-semibold uppercase tracking-wider {{ (request()->routeIs('shop.home.index') && request()->is('/')) ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} border-b border-slate-100 transition-colors"
                        >
                            <span>Home</span>
                            <i class="fa-solid fa-chevron-right text-xs text-[#6b7280]"></i>
                        </a>

                        <!-- Products Section -->
                        <div x-data="{ expanded: false }" class="border-b border-slate-100">
                            <div class="flex items-center justify-between py-3">
                                <a
                                    href="{{ route('shop.products.index') }}"
                                    class="text-sm font-semibold uppercase tracking-wider {{ (request()->is('shop*') || request()->is('products*')) ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} transition-colors"
                                >
                                    Products
                                </a>
                                <button
                                    type="button"
                                    @click="expanded = !expanded"
                                    class="p-1 text-slate-400 hover:text-[#133b63] focus:outline-none"
                                    aria-label="Toggle categories"
                                >
                                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': expanded }"></i>
                                </button>
                            </div>

                            <div x-show="expanded" x-collapse class="pl-4 pb-3 space-y-2 border-l-2 border-[#2ca7a3]/30 ml-2">
                                <a href="{{ route('shop.products.index') }}" class="block text-xs font-bold text-[#1d5b8f] py-1">
                                    All Socks &amp; Products &rarr;
                                </a>
                                @php
                                    $mobileCategories = app(\Webkul\Category\Repositories\CategoryRepository::class)->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id);
                                @endphp
                                @foreach ($mobileCategories as $cat)
                                    <a href="{{ route('shop.category.view', $cat->slug) }}" class="block text-xs font-semibold text-[#133b63] hover:text-[#2ca7a3] py-1">
                                        {{ $cat->name }}
                                    </a>
                                    @if ($cat->children && $cat->children->count())
                                        @foreach ($cat->children as $sub)
                                            <a href="{{ route('shop.category.view', $sub->slug) }}" class="block text-xs font-normal text-slate-600 hover:text-[#2ca7a3] py-0.5 pl-3">
                                                {{ $sub->name }}
                                            </a>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- About Us -->
                        <a
                            href="{{ route('shop.cms.page', 'about-us') }}"
                            class="flex items-center justify-between py-3 text-sm font-semibold uppercase tracking-wider {{ (request()->is('page/about-us*') || request()->is('about-us*')) ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} border-b border-slate-100 transition-colors"
                        >
                            <span>About Us</span>
                            <i class="fa-solid fa-chevron-right text-xs text-[#6b7280]"></i>
                        </a>

                        <!-- Why Choose Us -->
                        <a
                            href="{{ route('shop.cms.page', 'why-choose-us') }}"
                            class="flex items-center justify-between py-3 text-sm font-semibold uppercase tracking-wider {{ (request()->is('page/why-choose-us*') || request()->is('why-choose-us*')) ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} border-b border-slate-100 transition-colors"
                        >
                            <span>Why Choose Us</span>
                            <i class="fa-solid fa-chevron-right text-xs text-[#6b7280]"></i>
                        </a>

                        <!-- How It Works -->
                        <a
                            href="{{ route('shop.cms.page', 'how-it-works') }}"
                            class="flex items-center justify-between py-3 text-sm font-semibold uppercase tracking-wider {{ (request()->is('page/how-it-works*') || request()->is('how-it-works*')) ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} border-b border-slate-100 transition-colors"
                        >
                            <span>How It Works</span>
                            <i class="fa-solid fa-chevron-right text-xs text-[#6b7280]"></i>
                        </a>

                        <!-- Contact Us -->
                        <a
                            href="{{ route('shop.home.contact_us') }}"
                            class="flex items-center justify-between py-3 text-sm font-semibold uppercase tracking-wider {{ (request()->routeIs('shop.home.contact_us*') || request()->is('contact-us*') || request()->is('page/contact-us*')) ? 'text-[#f29a38] font-bold' : 'text-[#133b63] hover:text-[#1d5b8f]' }} border-b border-slate-100 transition-colors"
                        >
                            <span>Contact Us</span>
                            <i class="fa-solid fa-chevron-right text-xs text-[#6b7280]"></i>
                        </a>
                    @endif
                </nav>

                <!-- Account Profile Section -->
                <div class="p-6">
                    <div class="grid grid-cols-[auto_1fr] items-center gap-4 rounded-xl border border-soxnsox-border bg-white p-3.5 shadow-sm">
                        <div>
                            @php
                                $mobileCustomer = auth()->guard('customer')->user();
                            @endphp
                            <img
                                src="{{ $mobileCustomer?->avatar_url ?? bagisto_asset('images/user-placeholder.png') }}"
                                class="h-[46px] w-[46px] rounded-full object-cover"
                                alt="{{ $mobileCustomer?->first_name ?? 'User Profile' }}"
                            >
                        </div>

                        @guest('customer')
                            <a
                                href="{{ route('shop.customer.session.create') }}"
                                class="flex items-center text-sm font-semibold text-soxnsox-charcoal hover:text-soxnsox-teal"
                            >
                                @lang('shop::app.components.layouts.header.mobile.login')

                                <i class="fa-solid fa-angles-right text-xs ltr:ml-2 rtl:mr-2 text-soxnsox-teal"></i>
                            </a>
                        @endguest

                        @auth('customer')
                            <div
                                class="flex flex-col justify-between gap-0.5"
                                v-pre
                            >
                                <p class="text-sm font-bold text-soxnsox-charcoal">Hello, {{ auth()->user()?->first_name }}</p>

                                <a href="{{ route('shop.customers.account.profile.index') }}" class="text-xs text-soxnsox-teal font-medium hover:underline inline-flex items-center gap-1">
                                    <span>View Account</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </x-slot>

            <x-slot:footer>
                <!-- Quick Search & Cart Actions -->
                <div class="flex items-center justify-between gap-4 text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                    <a href="{{ route('shop.search.index') }}" class="flex items-center gap-1.5 hover:text-soxnsox-teal transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-sm text-soxnsox-muted"></i>
                        <span>Search</span>
                    </a>

                    <a href="{{ route('shop.checkout.cart.index') }}" class="flex items-center gap-1.5 hover:text-soxnsox-teal transition-colors">
                        <i class="fa-solid fa-bag-shopping text-sm text-soxnsox-muted"></i>
                        <span>Cart</span>
                    </a>
                </div>
            </x-slot>
        </x-shop::drawer>
    </script>

    <script type="module">
        app.component('v-mobile-drawer', {
            template: '#v-mobile-drawer-template',
        });
    </script>
@endPushOnce
