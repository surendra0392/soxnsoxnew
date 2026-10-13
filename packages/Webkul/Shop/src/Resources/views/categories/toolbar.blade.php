{!! view_render_event('bagisto.shop.categories.view.toolbar.before') !!}

<v-toolbar @filter-applied='setFilters("toolbar", $event)'></v-toolbar>

{!! view_render_event('bagisto.shop.categories.view.toolbar.after') !!}

@inject('toolbar' , 'Webkul\Product\Helpers\Toolbar')

@pushOnce('scripts')
    <script
        type="text/x-template"
        id='v-toolbar-template'
    >
        <div>
            <!-- Desktop Toolbar -->
            <div class="flex justify-between max-md:hidden">
                {!! view_render_event('bagisto.shop.categories.toolbar.filter.before') !!}

                <!-- Product Sorting Filters -->
                <x-shop::dropdown
                    class="z-[1]"
                    position="bottom-left"
                >
                    <x-slot:toggle>
                        <!-- Dropdown Toggler -->
                        <button class="flex w-full max-w-[220px] cursor-pointer items-center justify-between gap-3 rounded-full border border-slate-200 bg-white px-5 py-2.5 text-xs font-semibold text-[#133b63] shadow-sm transition-all hover:border-[#2ca7a3] hover:shadow-md focus:border-[#2ca7a3] max-md:w-[110px] max-md:border-0 max-md:px-2.5">
                            @{{ sortLabel ?? "@lang('shop::app.products.sort-by.title')" }}

                            <i
                                class="fa-solid fa-chevron-down text-[10px] text-slate-400"
                                role="presentation"
                            ></i>
                        </button>
                    </x-slot>

                    <!-- Dropdown Content -->
                    <x-slot:menu>
                        <x-shop::dropdown.menu.item
                            v-for="(sort, key) in filters.available.sort"
                            ::class="{'!bg-teal-50 !text-[#2ca7a3] font-bold': sort.value == filters.applied.sort}"
                            @click="apply('sort', sort.value)"
                        >
                            @{{ sort.title }}
                        </x-shop::dropdown.menu.item>
                    </x-slot>
                </x-shop::dropdown>

                {!! view_render_event('bagisto.shop.categories.toolbar.filter.after') !!}

                {!! view_render_event('bagisto.shop.categories.toolbar.pagination.before') !!}

                <!-- Product Pagination Limit -->
                <div class="flex items-center gap-6">
                    <!-- Product Pagination Limit -->
                    <x-shop::dropdown position="bottom-right">
                        <x-slot:toggle>
                            <!-- Dropdown Toggler -->
                            <button class="flex w-full max-w-[140px] cursor-pointer items-center justify-between gap-3 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-[#133b63] shadow-sm transition-all hover:border-[#2ca7a3] hover:shadow-md focus:border-[#2ca7a3] max-md:w-[110px] max-md:border-0 max-md:px-2.5">
                                @{{ filters.applied.limit ?? "@lang('shop::app.categories.toolbar.show')" }}

                                <i
                                    class="fa-solid fa-chevron-down text-[10px] text-slate-400"
                                    role="presentation"
                                ></i>
                            </button>
                        </x-slot>

                        <!-- Dropdown Content -->
                        <x-slot:menu>
                            <x-shop::dropdown.menu.item
                                v-for="(limit, key) in filters.available.limit"
                                ::class="{'!bg-teal-50 !text-[#2ca7a3] font-bold': limit == filters.applied.limit}"
                                @click="apply('limit', limit)"
                            >
                                @{{ limit }}
                            </x-shop::dropdown.menu.item>
                        </x-slot>
                    </x-shop::dropdown>

                    <!-- Listing Mode Switcher -->
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            class="cursor-pointer h-9 w-9 flex items-center justify-center rounded-full border transition-all"
                            aria-label="@lang('shop::app.categories.toolbar.list')"
                            :class="(filters.applied.mode === 'list') ? 'text-white bg-[#133b63] border-[#133b63] shadow-sm' : 'text-slate-500 bg-white border-slate-200 hover:border-[#2ca7a3] hover:text-[#2ca7a3]'"
                            @click="changeMode('list')"
                        >
                            <i class="fa-solid fa-list text-xs"></i>
                        </button>

                        <button
                            type="button"
                            class="cursor-pointer h-9 w-9 flex items-center justify-center rounded-full border transition-all"
                            aria-label="@lang('shop::app.categories.toolbar.grid')"
                            :class="(filters.applied.mode === 'grid') ? 'text-white bg-[#133b63] border-[#133b63] shadow-sm' : 'text-slate-500 bg-white border-slate-200 hover:border-[#2ca7a3] hover:text-[#2ca7a3]'"
                            @click="changeMode('grid')"
                        >
                            <i class="fa-solid fa-grip text-xs"></i>
                        </button>
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.categories.toolbar.pagination.after') !!}
            </div>

            <!-- Mobile Toolbar -->
            <div class="md:hidden">
                <ul>
                    <li
                        class="px-4 py-2.5"
                        :class="{'bg-gray-100': sort.value == filters.applied.sort}"
                        v-for="(sort, key) in filters.available.sort"
                        @click="apply('sort', sort.value)"
                    >
                        @{{ sort.title }}
                    </li>
                </ul>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-toolbar', {
            template: '#v-toolbar-template',

            data() {
                return {
                    filters: {
                        available: {
                            sort: @json($toolbar->getAvailableOrders()),

                            limit: @json($toolbar->getAvailableLimits()),

                            mode: @json($toolbar->getAvailableModes()),
                        },

                        default: {
                            sort: '{{ $toolbar->getOrder([])['value'] }}',

                            limit: '{{ $toolbar->getLimit([]) }}',

                            mode: '{{ $toolbar->getMode([]) }}',
                        },

                        applied: {
                            sort: '{{ $toolbar->getOrder($params ?? [])['value'] }}',

                            limit: '{{ $toolbar->getLimit($params ?? []) }}',

                            mode: '{{ $toolbar->getMode($params ?? []) }}',
                        }
                    }
                };
            },

            created() {
                let queryParams = new URLSearchParams(window.location.search);

                queryParams.forEach((value, filter) => {
                    if (['sort', 'limit', 'mode'].includes(filter)) {
                        this.filters.applied[filter] = value;
                    }
                });
            },

            mounted() {
                this.setFilters();
            },

            computed: {
                sortLabel() {
                    return this.filters.available.sort.find(sort => sort.value === this.filters.applied.sort).title;
                }
            },

            methods: {
                apply(type, value) {
                    this.filters.applied[type] = value;

                    this.setFilters();
                },

                changeMode(value = 'grid') {
                    this.filters.applied['mode'] = value;

                    this.setFilters();
                },

                setFilters() {
                    let filters = {};

                    for (let key in this.filters.applied) {
                        if (this.filters.applied[key] != this.filters.default[key]) {
                            filters[key] = this.filters.applied[key];
                        }
                    }

                    this.$emit('filter-applied', {
                        default: this.filters.default,
                        applied: filters,
                    });
                }
            },
        });
    </script>
@endPushOnce
