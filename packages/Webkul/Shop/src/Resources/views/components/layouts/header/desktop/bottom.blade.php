{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.before') !!}

@php
    $channel = core()->getCurrentChannel();
    $logoUrl = ($channel->logo && file_exists(public_path('storage/' . $channel->logo)))
        ? asset('storage/' . $channel->logo)
        : (file_exists(public_path('logo.png'))
            ? asset('logo.png')
            : ($channel->logo_url ?: null));
@endphp

<div class="site-container flex min-h-[92px] items-center justify-between">
    <!-- Left: Brand Logo -->
    <div class="flex items-center">
        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.logo.before') !!}

        <a
            href="{{ route('shop.home.index') }}"
            class="flex items-center py-2 group"
            aria-label="SOXNSOX - Bamboo Socks"
        >
            @if ($logoUrl)
                <img
                    src="{{ $logoUrl }}"
                    alt="SOX N SOX - India's Premier Bamboo &amp; Diabetic Socks"
                    class="h-10 md:h-12 w-auto object-contain max-w-[220px] transition-transform duration-300 group-hover:scale-[1.02]"
                />
            @else
                <div class="flex flex-col">
                    <span class="font-display text-2xl lg:text-3xl font-extrabold tracking-tight text-[#133b63] group-hover:text-[#1d5b8f] transition-colors">
                        SOX<span class="text-[#f29a38]">N</span>SOX
                    </span>
                    <span class="text-[9px] tracking-[0.28em] uppercase text-[#2ca7a3] -mt-0.5 font-sans font-bold">
                        Bamboo Socks
                    </span>
                </div>
            @endif
        </a>

        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.logo.after') !!}
    </div>

    <!-- Center: Primary Navigation (SOXNSOX Multi-Page Architecture) -->
    <div class="hidden lg:flex items-center gap-x-8">
        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.category.before') !!}

        <nav class="flex items-center gap-6 lg:gap-8" aria-label="Primary Navigation">
            <!-- 1. Products with Dropdown Menu -->
            <div class="relative group py-2">
                <a
                    href="{{ route('shop.products.index') }}"
                    class="soxnsox-nav-link flex items-center gap-1.5 {{ (request()->is('shop*') || request()->is('products*') || request()->routeIs('shop.category.view') || request()->routeIs('shop.products.view*')) ? 'soxnsox-nav-link-active' : '' }}"
                >
                    <span>Products</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-[#f29a38] group-hover:rotate-180 transition-transform duration-200"></i>
                </a>

                <!-- Dropdown Card (Expanded width with single-line typography) -->
                <div class="soxnsox-products-dropdown absolute left-0 top-full pt-2 z-50">
                    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-3.5 space-y-1">
                        <a href="{{ route('shop.products.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold text-[#133b63] hover:bg-[#e9f2fa] hover:text-[#1d5b8f] transition-colors group/item">
                            <span class="whitespace-nowrap">All Socks &amp; Products</span>
                            <i class="fa-solid fa-arrow-right text-[10px] text-[#2ca7a3] transition-transform group-hover/item:translate-x-0.5"></i>
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        @php
                            $headerCategories = app(\Webkul\Category\Repositories\CategoryRepository::class)->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id);
                        @endphp
                        @foreach ($headerCategories as $category)
                            <a href="{{ route('shop.category.view', $category->slug) }}" class="soxnsox-dropdown-item flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-[#133b63] hover:bg-[#e6f8f7] hover:text-[#2ca7a3] transition-all group/item">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 group-hover/item:bg-[#2ca7a3] group-hover/item:scale-125 transition-all flex-shrink-0"></span>
                                <span class="whitespace-nowrap transition-transform group-hover/item:translate-x-0.5">{{ $category->name }}</span>
                            </a>
                            @if ($category->children && $category->children->count())
                                @foreach ($category->children as $subCategory)
                                    <a href="{{ route('shop.category.view', $subCategory->slug) }}" class="soxnsox-dropdown-item flex items-center gap-2 px-3.5 py-1.5 pl-6 rounded-xl text-xs font-medium text-slate-600 hover:bg-[#e6f8f7] hover:text-[#2ca7a3] transition-all group/item">
                                        <span class="w-1 h-1 rounded-full bg-slate-300 group-hover/item:bg-[#2ca7a3] transition-all flex-shrink-0"></span>
                                        <span class="whitespace-nowrap transition-transform group-hover/item:translate-x-0.5">{{ $subCategory->name }}</span>
                                    </a>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 2. About Us -->
            <a href="{{ route('shop.cms.page', 'about-us') }}" class="soxnsox-nav-link {{ (request()->is('page/about-us*') || request()->is('about-us*')) ? 'soxnsox-nav-link-active' : '' }}">
                About Us
            </a>

            <!-- 3. Why Choose Us -->
            <a href="{{ route('shop.cms.page', 'why-choose-us') }}" class="soxnsox-nav-link {{ (request()->is('page/why-choose-us*') || request()->is('why-choose-us*')) ? 'soxnsox-nav-link-active' : '' }}">
                Why Choose Us
            </a>

            <!-- 4. How It Works -->
            <a href="{{ route('shop.cms.page', 'how-it-works') }}" class="soxnsox-nav-link {{ (request()->is('page/how-it-works*') || request()->is('how-it-works*')) ? 'soxnsox-nav-link-active' : '' }}">
                How It Works
            </a>

            <!-- 5. Contact Us -->
            <a href="{{ route('shop.home.contact_us') }}" class="soxnsox-nav-link {{ (request()->routeIs('shop.home.contact_us') || request()->is('contact-us*') || request()->is('page/contact-us*')) ? 'soxnsox-nav-link-active' : '' }}">
                Contact Us
            </a>
        </nav>

        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.category.after') !!}
    </div>

    <!-- Right Utility Icons & Search Popover (8px Spacing) -->
    <div class="soxnsox-header-actions flex items-center gap-2 text-soxnsox-charcoal">
        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.search_bar.before') !!}

        <!-- Search Icon Dropdown Popover -->
        <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}" :close-on-click="false">
            <x-slot:toggle>
                <button
                    type="button"
                    class="soxnsox-header-action-btn flex h-9 w-9 sm:h-9 sm:w-9 items-center justify-center rounded-full text-[#133b63] hover:bg-[#e9f2fa] hover:text-[#1d5b8f] transition-colors focus:outline-none"
                    aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.search')"
                >
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </button>
            </x-slot>

            <x-slot:content class="w-[340px] sm:w-[420px] p-5 bg-white rounded-2xl border border-soxnsox-border shadow-2xl">
                <form
                    action="{{ route('shop.search.index') }}"
                    class="relative flex items-center"
                    role="search"
                    toolname="search_products"
                    tooldescription="{{ trans('shop::app.components.layouts.webmcp.search-products') }}"
                    toolautosubmit
                >
                    <label for="header-search-input" class="sr-only">
                        @lang('shop::app.components.layouts.header.desktop.bottom.search')
                    </label>

                    <div class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 flex items-center text-soxnsox-muted">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </div>

                    <input
                        id="header-search-input"
                        type="text"
                        name="query"
                        value="{{ request('query') }}"
                        toolparamdescription="{{ trans('shop::app.components.layouts.webmcp.search-products-query') }}"
                        class="w-full h-11 pl-10 pr-11 text-xs text-[#133b63] placeholder:text-[#6b7280]/70 bg-[#f5f7fa] border border-soxnsox-border rounded-xl focus:bg-white focus:border-[#2ca7a3] focus:ring-2 focus:ring-[#2ca7a3]/20 transition-all outline-none"
                        minlength="{{ core()->getConfigData('catalog.products.search.min_query_length') }}"
                        maxlength="{{ core()->getConfigData('catalog.products.search.max_query_length') }}"
                        placeholder="Search socks, diabetic, athletic, pack of 6..."
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.search-text')"
                        aria-required="true"
                        pattern="[^\\]+"
                        autocomplete="off"
                        required
                    >

                    <button
                        type="submit"
                        class="hidden"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.submit')"
                    >
                    </button>

                    @if (core()->getConfigData('catalog.products.settings.image_search'))
                        @include('shop::search.images.index')
                    @endif
                </form>

                <!-- Quick / Popular Tags -->
                @php
                    $themeCustomizations = app(\Webkul\Theme\Repositories\ThemeCustomizationRepository::class)->get();
                    $popularTags = $themeCustomizations->where('name', 'SOXNSOX Popular Search Tags')->first();
                @endphp
                @if ($popularTags && isset($popularTags->options['html']))
                    {!! $popularTags->options['html'] !!}
                @endif
            </x-slot>
        </x-shop::dropdown>

        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.search_bar.after') !!}

        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.before') !!}

        @if(core()->getConfigData('catalog.products.settings.compare_option'))
            <a
                href="{{ route('shop.compare.index') }}"
                aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.compare')"
                class="soxnsox-header-action-btn flex h-9 w-9 sm:h-9 sm:w-9 items-center justify-center rounded-full text-[#133b63] hover:bg-[#e9f2fa] hover:text-[#1d5b8f] transition-colors focus:outline-none"
            >
                <i class="fa-solid fa-code-compare text-lg"></i>
            </a>
        @endif

        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.after') !!}

        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.mini_cart.before') !!}

        @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
            @include('shop::checkout.cart.mini-cart')
        @endif

        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.mini_cart.after') !!}

        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile.before') !!}

        <!-- User profile dropdown -->
        <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
            <x-slot:toggle>
                @auth('customer')
                    <button
                        type="button"
                        class="flex h-9 w-9 items-center justify-center rounded-full overflow-hidden ring-2 ring-slate-200 hover:ring-[#133b63] transition-all focus:outline-none"
                        aria-label="{{ auth()->guard('customer')->user()->first_name }}"
                    >
                        <img
                            src="{{ auth()->guard('customer')->user()->avatar_url }}"
                            alt="{{ auth()->guard('customer')->user()->first_name }}"
                            class="h-full w-full object-cover"
                        />
                    </button>
                @else
                    <button
                        type="button"
                        class="soxnsox-header-action-btn flex h-9 w-9 sm:h-9 sm:w-9 items-center justify-center rounded-full text-[#133b63] hover:bg-[#e9f2fa] hover:text-[#1d5b8f] transition-colors focus:outline-none"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.profile')"
                    >
                        <i class="fa-regular fa-user text-lg"></i>
                    </button>
                @endauth
            </x-slot>

            <x-slot:content class="p-4 rounded-soxnsox bg-white border border-soxnsox-border shadow-soxnsox-card">
                <!-- Guest Dropdown -->
                @guest('customer')
                    <div class="grid gap-2">
                        <p class="text-base font-display font-bold text-[#133b63]">
                            @lang('shop::app.components.layouts.header.desktop.bottom.welcome-guest')
                        </p>

                        <p class="text-xs text-soxnsox-muted">
                            @lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                        </p>
                    </div>

                    <div class="my-3 border-t border-soxnsox-border"></div>

                    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.customers_action.before') !!}

                    <div class="flex gap-2">
                        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.sign_in_button.before') !!}

                        <a
                            href="{{ route('shop.customer.session.create') }}"
                            class="soxnsox-btn-primary !px-4 !py-2 text-[11px]"
                        >
                            @lang('shop::app.components.layouts.header.desktop.bottom.sign-in')
                        </a>

                        <a
                            href="{{ route('shop.customers.register.index') }}"
                            class="soxnsox-btn-outline !px-4 !py-2 text-[11px]"
                        >
                            @lang('shop::app.components.layouts.header.desktop.bottom.sign-up')
                        </a>

                        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.sign_up_button.after') !!}
                    </div>

                    @if (core()->getConfigData('sales.eu_withdrawal.general.enabled', core()->getCurrentChannelCode()))
                        <a
                            href="{{ route('shop.eu-withdrawal.guest.lookup') }}"
                            class="mt-4 inline-flex items-center gap-1.5 text-xs font-medium text-navyBlue hover:underline"
                        >
                            @lang('shop::app.eu_withdrawal.guest_dropdown.link')
                        </a>
                    @endif

                    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.customers_action.after') !!}
                @endguest

                <!-- Customers Dropdown -->
                @auth('customer')
                    <div class="flex items-center gap-3 p-1 pb-1">
                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full ring-1 ring-slate-200 shadow-2xs">
                            <img
                                src="{{ auth()->guard('customer')->user()->avatar_url }}"
                                alt="{{ auth()->guard('customer')->user()->first_name }}"
                                class="h-full w-full object-cover"
                            />
                        </div>
                        <div class="min-w-0" v-pre>
                            <p class="text-sm font-display font-bold text-[#133b63] truncate">
                                @lang('shop::app.components.layouts.header.desktop.bottom.welcome')’ {{ auth()->guard('customer')->user()->first_name }}
                            </p>
                            <p class="text-xs text-soxnsox-muted truncate">
                                {{ auth()->guard('customer')->user()->email }}
                            </p>
                        </div>
                    </div>

                    <div class="my-3 border-t border-soxnsox-border"></div>

                    <div class="grid gap-1 pb-1">
                        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile_dropdown.links.before') !!}

                        <a
                            class="px-3 py-1.5 text-xs font-medium text-soxnsox-charcoal hover:text-soxnsox-teal hover:bg-black/5 rounded-md transition-colors"
                            href="{{ route('shop.customers.account.profile.index') }}"
                        >
                            @lang('shop::app.components.layouts.header.desktop.bottom.profile')
                        </a>

                        <a
                            class="px-3 py-1.5 text-xs font-medium text-soxnsox-charcoal hover:text-soxnsox-teal hover:bg-black/5 rounded-md transition-colors"
                            href="{{ route('shop.customers.account.orders.index') }}"
                        >
                            @lang('shop::app.components.layouts.header.desktop.bottom.orders')
                        </a>

                        @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                            <a
                                class="px-3 py-1.5 text-xs font-medium text-soxnsox-charcoal hover:text-soxnsox-teal hover:bg-black/5 rounded-md transition-colors"
                                href="{{ route('shop.customers.account.wishlist.index') }}"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.wishlist')
                            </a>
                        @endif

                        <x-shop::form
                            method="DELETE"
                            action="{{ route('shop.customer.session.destroy') }}"
                            id="customerLogout"
                        />

                        <a
                            class="px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 rounded-md transition-colors"
                            href="{{ route('shop.customer.session.destroy') }}"
                            onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                        >
                            @lang('shop::app.components.layouts.header.desktop.bottom.logout')
                        </a>

                        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile_dropdown.links.after') !!}
                    </div>
                @endauth
            </x-slot>
        </x-shop::dropdown>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile.after') !!}
    </div>
</div>

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.after') !!}
