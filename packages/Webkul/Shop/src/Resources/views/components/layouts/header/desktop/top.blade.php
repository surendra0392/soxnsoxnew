{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.before') !!}

@php
    $offerTitle = core()->getConfigData('general.content.header_offer.title');
    $redirectionTitle = core()->getConfigData('general.content.header_offer.redirection_title');
    $redirectionLink = core()->getConfigData('general.content.header_offer.redirection_link');
@endphp

<v-topbar>
    <!-- Shimmer / SSR Fallback -->
    <div style="background: linear-gradient(90deg, #133b63 0%, #1d5b8f 100%) !important; border-bottom: 1px solid rgba(44, 167, 163, 0.25) !important;">
        <div class="site-container flex items-center justify-between py-2 text-xs" style="color: #f5f7fa !important;">
            <div class="w-20"></div>
            <div class="text-[11px] font-semibold tracking-wider uppercase flex items-center gap-2">
                @if ($offerTitle)
                    <span>{!! $offerTitle !!}</span>
                    @if ($redirectionTitle && $redirectionLink)
                        <a
                            href="{{ $redirectionLink }}"
                            class="ml-1.5 inline-flex items-center gap-1 font-bold text-[#f29a38] hover:text-white underline transition-colors"
                        >
                            <span>{{ $redirectionTitle }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    @endif
                @else
                    <span class="flex items-center gap-2">
                        <span>Free Shipping All Over India On Orders Above ₹499</span>
                        <i class="fa-solid fa-circle text-[4px] text-[#f29a38]"></i>
                        <span>100% Bamboo Comfort</span>
                        <i class="fa-solid fa-circle text-[4px] text-[#2ca7a3]"></i>
                        <span>Doctor-Recommended Diabetic Socks</span>
                    </span>
                @endif
            </div>
            <div class="w-20"></div>
        </div>
    </div>
</v-topbar>

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-topbar-template"
    >
        <div style="background: linear-gradient(90deg, #133b63 0%, #1d5b8f 100%) !important; border-bottom: 1px solid rgba(44, 167, 163, 0.25) !important;">
            <div class="site-container flex items-center justify-between py-2 text-[11px] font-semibold tracking-wider uppercase" style="color: #f5f7fa !important;">
            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.currency_switcher.before') !!}

            <!-- Currency Switcher -->
            <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'left' : 'right' }}">
                <!-- Dropdown Toggler -->
                <x-slot:toggle>
                    <div
                        class="flex cursor-pointer items-center gap-1.5 hover:text-[#f29a38] transition-colors"
                        role="button"
                        tabindex="0"
                        @click="currencyToggler = ! currencyToggler"
                    >
                        <span v-pre>
                            {{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}
                        </span>

                        <i
                            class="fa-solid text-[10px] transition-transform duration-200"
                            :class="currencyToggler ? 'fa-chevron-up' : 'fa-chevron-down'"
                            role="presentation"
                        ></i>
                    </div>
                </x-slot>

                <!-- Dropdown Content -->
                <x-slot:content class="journal-scroll max-h-[500px] !p-0 bg-white text-[#133b63] shadow-lg border border-soxnsox-border rounded-lg">
                    <v-currency-switcher></v-currency-switcher>
                </x-slot>
            </x-shop::dropdown>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.currency_switcher.after') !!}

            <!-- Benefit Ticker / Announcement -->
            <div class="flex items-center gap-2.5 text-[11px] font-semibold tracking-wider uppercase" style="color: #f5f7fa !important;">
                @if ($offerTitle)
                    <span>{!! $offerTitle !!}</span>
                    @if ($redirectionTitle && $redirectionLink)
                        <a
                            href="{{ $redirectionLink }}"
                            class="ml-1.5 inline-flex items-center gap-1 font-bold text-[#f29a38] hover:text-white underline transition-colors"
                        >
                            <span>{{ $redirectionTitle }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    @endif
                @else
                    <span>Free Shipping All Over India Above ₹499</span>
                    <i class="fa-solid fa-circle text-[4px]" style="color: #f29a38 !important;"></i>
                    <span>100% Bamboo Fiber</span>
                    <i class="fa-solid fa-circle text-[4px]" style="color: #2ca7a3 !important;"></i>
                    <span>Doctor-Recommended Diabetic Socks</span>
                @endif
            </div>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.locale_switcher.before') !!}

            <!-- Locales Switcher -->
            <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                <x-slot:toggle>
                    <div
                        class="flex cursor-pointer items-center gap-1.5 hover:text-white transition-colors"
                        role="button"
                        tabindex="0"
                        @click="localeToggler = ! localeToggler"
                    >
                        <span v-pre>
                            {{ core()->getCurrentChannel()->locales()->orderBy('name')->where('code', app()->getLocale())->value('name') ?? 'EN' }}
                        </span>

                        <i
                            class="fa-solid text-[10px] transition-transform duration-200"
                            :class="localeToggler ? 'fa-chevron-up' : 'fa-chevron-down'"
                            role="presentation"
                        ></i>
                    </div>
                </x-slot>
            
                <x-slot:content class="journal-scroll max-h-[500px] !p-0 bg-white text-soxnsox-charcoal shadow-soxnsox-card border border-soxnsox-border rounded-soxnsox">
                    <v-locale-switcher></v-locale-switcher>
                </x-slot>
            </x-shop::dropdown>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.locale_switcher.after') !!}
            </div>
        </div>
    </script>

    <script
        type="text/x-template"
        id="v-currency-switcher-template"
    >
        <div class="my-2.5 grid gap-1 overflow-auto max-md:my-0 sm:max-h-[500px]">
            <span
                class="cursor-pointer px-5 py-2 text-base hover:bg-gray-100"
                v-for="currency in currencies"
                :class="{'bg-gray-100': currency.code == '{{ core()->getCurrentCurrencyCode() }}'}"
                @click="change(currency)"
            >
                @{{ currency.symbol + ' ' + currency.code }}
            </span>
        </div>
    </script>

    <script
        type="text/x-template"
        id="v-locale-switcher-template"
    >
        <div class="my-2.5 grid gap-1 overflow-auto max-md:my-0 sm:max-h-[500px]">
            <span
                class="flex cursor-pointer items-center gap-2.5 px-5 py-2 text-base hover:bg-gray-100"
                :class="{'bg-gray-100': locale.code == '{{ app()->getLocale() }}'}"
                v-for="locale in locales"
                @click="change(locale)"                  
            >
                <img
                    :src="locale.logo_url || '{{ bagisto_asset('images/default-language.svg') }}'"
                    :alt="locale.name"
                    width="24"
                    height="16"
                />

                @{{ locale.name }}
            </span>
        </div>
    </script>

    <script type="module">
        app.component('v-topbar', {
            template: '#v-topbar-template',

            data() {
                return {
                    localeToggler: '',

                    currencyToggler: '',
                };
            },
        });

        app.component('v-currency-switcher', {
            template: '#v-currency-switcher-template',

            data() {
                return {
                    currencies: @json(core()->getCurrentChannel()->currencies),
                };
            },

            methods: {
                change(currency) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('currency', currency.code);

                    window.location.href = url.href;
                }
            }
        });

        app.component('v-locale-switcher', {
            template: '#v-locale-switcher-template',

            data() {
                return {
                    locales: @json(core()->getCurrentChannel()->locales()->orderBy('name')->get()),
                };
            },

            methods: {
                change(locale) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('locale', locale.code);

                    window.location.href = url.href;
                }
            }
        });
    </script>
@endPushOnce