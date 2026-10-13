<x-admin::layouts>
    <!-- Title of the page -->
    <x-slot:title>
        @lang('admin::app.configuration.index.title')
    </x-slot>

    @php
        /**
         * Helper icon mapping for all system configuration items.
         * Returns modern, crisp SVG icon paths and styling.
         */
        $getSectionIcon = function($fullKey) {
            return match($fullKey) {
                'general.general' => '<i class="fa-solid fa-gear text-xl"></i>',
                'general.content' => '<i class="fa-solid fa-newspaper text-xl"></i>',
                'general.design' => '<i class="fa-solid fa-palette text-xl"></i>',
                'general.exchange_rates' => '<i class="fa-solid fa-money-bill-transfer text-xl"></i>',
                'general.sitemap' => '<i class="fa-solid fa-sitemap text-xl"></i>',
                'general.gdpr' => '<i class="fa-solid fa-user-shield text-xl"></i>',
                'magic_ai.general' => '<i class="fa-solid fa-wand-magic-sparkles text-xl"></i>',
                'magic_ai.providers' => '<i class="fa-solid fa-microchip text-xl"></i>',
                'magic_ai.admin_features' => '<i class="fa-solid fa-robot text-xl"></i>',
                'magic_ai.storefront_features' => '<i class="fa-solid fa-shop text-xl"></i>',
                'catalog.products' => '<i class="fa-solid fa-boxes-stacked text-xl"></i>',
                'catalog.rich_snippets' => '<i class="fa-solid fa-code text-xl"></i>',
                'catalog.inventory' => '<i class="fa-solid fa-warehouse text-xl"></i>',
                'customer.address' => '<i class="fa-solid fa-location-dot text-xl"></i>',
                'customer.captcha' => '<i class="fa-solid fa-shield-halved text-xl"></i>',
                'customer.settings' => '<i class="fa-solid fa-users-gear text-xl"></i>',
                'emails.configure' => '<i class="fa-solid fa-envelope-open-text text-xl"></i>',
                'emails.general' => '<i class="fa-solid fa-bell text-xl"></i>',
                'sales.shipping' => '<i class="fa-solid fa-truck-fast text-xl"></i>',
                'sales.shipping_zones' => '<i class="fa-solid fa-globe text-xl"></i>',
                'sales.payment_methods' => '<i class="fa-solid fa-credit-card text-xl"></i>',
                'sales.order_settings' => '<i class="fa-solid fa-cart-shopping text-xl"></i>',
                'sales.invoice_settings' => '<i class="fa-solid fa-file-invoice-dollar text-xl"></i>',
                'sales.taxes' => '<i class="fa-solid fa-percent text-xl"></i>',
                'sales.checkout' => '<i class="fa-solid fa-bag-shopping text-xl"></i>',
                'sales.rma' => '<i class="fa-solid fa-rotate-left text-xl"></i>',
                'sales.eu_withdrawal' => '<i class="fa-solid fa-scale-balanced text-xl"></i>',
                'cache_management.general' => '<i class="fa-solid fa-bolt text-xl"></i>',
                default => '<i class="fa-solid fa-circle-info text-xl"></i>'
            };
        };

        $getSectionSubtitle = function($item) {
            $key = $item->getKey();
            return match($key) {
                'general' => 'Store defaults, localization, branding, and compliance.',
                'magic_ai' => 'AI models, prompts, automations, and intelligent features.',
                'catalog' => 'Products display, rich snippets, and stock rules.',
                'customer' => 'Customer profiles, authentication, captchas, and addresses.',
                'emails' => 'SMTP mail transport, notifications, and customer alerts.',
                'sales' => 'Payment gateways, shipping methods, taxes, and checkout.',
                'cache_management' => 'System performance, route caches, and view compilers.',
                default => $item->getInfo() !== $item->getName() ? $item->getInfo() : 'Manage configuration settings and options.'
            };
        };
    @endphp

    <!-- Heading & Search Bar -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                @lang('admin::app.configuration.index.title')
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Manage global store settings, service integrations, and system parameters.
            </p>
        </div>

        <!-- Configuration Search Bar Vue Component -->
        <v-configuration-search>
            <div class="relative flex w-full sm:w-[380px] lg:w-[440px] items-center">
                <i class="icon-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                <input
                    type="text"
                    class="block w-full rounded-[12px] border border-slate-200 bg-white py-2 pl-10 pr-4 text-sm text-slate-800 placeholder:text-slate-400 transition-all hover:border-slate-300 focus:border-[#133b63] focus:ring-2 focus:ring-[#133b63]/20 shadow-xs"
                    placeholder="@lang('admin::app.configuration.index.search')"
                >
            </div>
        </v-configuration-search>
    </div>

    <!-- Page Content Sections -->
    <div class="space-y-10">
        @foreach (system_config()->getItems() as $item)
            @php
                $children = $item->getChildren();
                $childCount = count($children);
            @endphp

            <div class="space-y-4">
                <!-- Section Header -->
                <div class="flex items-center justify-between border-b border-slate-200/80 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#133b63]/10 text-[#133b63] font-semibold text-xs shadow-xs">
                            {{ substr($item->getName(), 0, 2) }}
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 tracking-tight">
                                {{ $item->getName() }}
                            </h2>
                            <p class="text-xs text-slate-500">
                                {{ $getSectionSubtitle($item) }}
                            </p>
                        </div>
                    </div>

                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 border border-slate-200">
                        {{ $childCount }} {{ $childCount === 1 ? 'module' : 'modules' }}
                    </span>
                </div>

                <!-- Section Cards Grid -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($children as $key => $child)
                        @php
                            $routePath = $item->getKey() . '/' . $key;
                            $fullKey = $item->getKey() . '.' . $key;
                            $url = $routePath === 'sales/shipping_zones' 
                                ? route('admin.settings.shipping.zones.index') 
                                : route('admin.configuration.index', $routePath);
                        @endphp

                        <a
                            href="{{ $url }}"
                            class="group relative flex flex-col justify-between rounded-[16px] border border-slate-200/90 bg-white p-5 shadow-xs transition-all duration-200 hover:-translate-y-0.5 hover:border-[#133b63]/40 hover:shadow-md hover:shadow-[#133b63]/5 hover:bg-slate-50/40 cursor-pointer"
                        >
                            <div>
                                <!-- Top Row: Icon Badge & Direction Indicator -->
                                <div class="flex items-start justify-between">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-[12px] bg-[#133b63]/[0.08] text-[#133b63] transition-all duration-200 group-hover:bg-[#133b63] group-hover:text-white group-hover:shadow-sm">
                                        {!! $getSectionIcon($fullKey) !!}
                                    </div>

                                    <div class="flex h-7 w-7 items-center justify-center rounded-full text-slate-300 transition-all duration-200 group-hover:translate-x-0.5 group-hover:text-[#133b63] group-hover:bg-[#133b63]/10">
                                        <i class="fa-solid fa-chevron-right text-xs"></i>
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div class="mt-4">
                                    <h3 class="text-[15px] font-semibold tracking-tight text-slate-900 transition-colors duration-200 group-hover:text-[#133b63] leading-snug">
                                        {{ $child->getName() }}
                                    </h3>

                                    <p class="mt-1.5 text-xs leading-relaxed text-slate-500 line-clamp-2">
                                        {{ $child->getInfo() }}
                                    </p>
                                </div>
                            </div>

                            <!-- Bottom Status / Tagline indicator -->
                            <div class="mt-4 flex items-center gap-1.5 pt-3 border-t border-slate-100 text-[11px] font-medium text-slate-400 group-hover:text-[#133b63] transition-colors">
                                <span>Configure</span>
                                <span class="text-xs">→</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-configuration-search-template">
            <div class="relative flex w-full sm:w-[380px] lg:w-[440px] items-center">
                <i class="icon-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                <input
                    type="text"
                    class="peer block w-full rounded-[12px] border border-slate-200 bg-white py-2 pl-10 pr-4 text-sm text-slate-800 placeholder:text-slate-400 transition-all hover:border-slate-300 focus:border-[#133b63] focus:ring-2 focus:ring-[#133b63]/20 shadow-xs"
                    :class="{'border-[#133b63] ring-2 ring-[#133b63]/20': isDropdownOpen}"
                    placeholder="@lang('admin::app.configuration.index.search')"
                    v-model.lazy="searchTerm"
                    @click="searchTerm.length >= 2 ? isDropdownOpen = true : {}"
                    v-debounce="500"
                >

                <div
                    class="absolute top-12 z-50 w-full rounded-[14px] border border-slate-200 bg-white p-1.5 shadow-xl"
                    v-if="isDropdownOpen"
                >
                    <template v-if="isLoading">
                        <x-admin::shimmer.header.mega-search.categories />
                    </template>

                    <template v-else>
                        <div class="grid max-h-[360px] overflow-y-auto journal-scroll">
                            <a
                                :href="category.url"
                                class="flex items-center justify-between rounded-lg px-3.5 py-2.5 text-sm font-medium text-slate-700 hover:bg-[#133b63]/10 hover:text-[#133b63] transition-all"
                                v-for="category in searchedResults.data"
                            >
                                <span>@{{ category.title }}</span>
                                <span class="text-xs text-slate-400">→</span>
                            </a>

                            <div
                                class="p-4 text-center text-sm font-medium text-slate-500"
                                v-if="searchedResults.data.length === 0"
                            >
                                @lang('admin::app.configuration.index.no-result-found')
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-configuration-search', {
                template: '#v-configuration-search-template',

                data() {
                    return {
                        isDropdownOpen: false,

                        isLoading: false,

                        searchTerm: '',

                        searchedResults: [],
                    };
                },

                watch: {
                    searchTerm(newVal, oldVal) {
                        this.search();
                    },
                },

                created() {
                    window.addEventListener('click', this.handleFocusOut);
                },

                beforeDestroy() {
                    window.removeEventListener('click', this.handleFocusOut);
                },

                methods: {
                    search() {
                        if (this.searchTerm.length <= 1) {
                            this.searchedResults = [];

                            this.isDropdownOpen = false;

                            return;
                        }

                        this.isDropdownOpen = true;

                        this.isLoading = true;

                        this.$axios.get("{{ route('admin.configuration.search') }}", {
                                params: {query: this.searchTerm}
                            })
                            .then((response) => {
                                this.searchedResults = response.data;

                                this.isLoading = false;
                            })
                            .catch((error) => {});
                    },

                    handleFocusOut(e) {
                        if (! this.$el.contains(e.target)) {
                            this.isDropdownOpen = false;
                        }
                    },
                },
            });
        </script>
    @endpushOnce
</x-admin::layouts>
