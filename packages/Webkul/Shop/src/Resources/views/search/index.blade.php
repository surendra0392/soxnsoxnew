<?php
    $searchTitle = $suggestion ?? $query;
    $title = $searchTitle ? trans('shop::app.search.title', ['query' => $searchTitle]) : trans('shop::app.search.results');
    $searchInstead = $suggestion ? $query : null;
?>

<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="{{ $title }} | SOX N SOX" />
    <meta name="description" content="Search SOX N SOX's collection of ultra-soft bamboo socks, diabetic footcare socks, and athletic packs." />
    <meta name="robots" content="noindex, follow" />
@endPush

<x-shop::layouts :has-feature="false">
    <!-- Page Title -->
    <x-slot:title>
        {{ $title }} | SOX N SOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-screen">
        @if (core()->getConfigData('general.general.breadcrumbs.shop'))
            <!-- Breadcrumbs -->
            <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
                <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                    <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                    <span class="text-slate-300">/</span>
                    <span class="text-[#133b63] font-semibold">Search</span>
                </nav>
            </div>
        @endif

        <!-- Search Hero Section -->
        <section class="site-container pt-6 pb-8 sm:pt-10 sm:pb-12 text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-[10px] sm:text-xs font-bold tracking-widest uppercase">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                <span>Search Catalog</span>
            </div>

            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] leading-tight">
                @if ($query)
                    Search results for <span class="text-[#f29a38]">"{{ $query }}"</span>
                @else
                    Search SOX N SOX
                @endif
            </h1>

            <div class="soxnsox-decorative-line-center"></div>

            <!-- Interactive Search Box -->
            <div class="max-w-2xl mx-auto pt-2">
                <form
                    action="{{ route('shop.search.index') }}"
                    method="GET"
                    class="group relative flex items-center bg-white border border-slate-200 rounded-full shadow-sm hover:border-[#2ca7a3] focus-within:border-[#2ca7a3] focus-within:ring-4 focus-within:ring-[#2ca7a3]/15 transition-all p-1.5 sm:p-2"
                    role="search"
                >
                    <label for="search-page-input" class="sr-only">Search SOX N SOX socks</label>

                    <div class="flex-shrink-0 pl-3.5 sm:pl-4 pr-1.5 text-[#6b7280] group-focus-within:text-[#2ca7a3] transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-magnifying-glass text-base sm:text-lg"></i>
                    </div>

                    <input
                        id="search-page-input"
                        type="text"
                        name="query"
                        value="{{ $query }}"
                        class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none text-sm sm:text-base text-[#133b63] placeholder:text-[#6b7280]/70 py-2 sm:py-2.5 px-3 font-medium"
                        placeholder="Search bamboo socks, diabetic, ankle, pack of 6..."
                        aria-label="Search SOX N SOX socks"
                        autocomplete="off"
                        required
                    >

                    <button
                        type="submit"
                        class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 flex-shrink-0 !rounded-full px-6 sm:px-8 py-2.5 sm:py-3 text-[11px] sm:text-xs font-bold uppercase tracking-wider text-white shadow-md flex items-center justify-center gap-1.5 transition-all"
                    >
                        <span>Search</span>
                    </button>
                </form>
            </div>

            <!-- Popular Search Suggestions -->
            <div class="pt-2 flex items-center justify-center gap-2 flex-wrap text-xs text-[#6b7280]">
                <span class="font-bold text-[#133b63] mr-1">Popular:</span>
                <a href="{{ route('shop.search.index', ['query' => 'Diabetic']) }}" class="px-3 py-1 rounded-full bg-white border border-slate-200 hover:bg-[#e6f8f7] hover:border-[#2ca7a3] hover:text-[#2ca7a3] transition-colors font-medium">Diabetic Socks</a>
                <a href="{{ route('shop.search.index', ['query' => 'Bamboo']) }}" class="px-3 py-1 rounded-full bg-white border border-slate-200 hover:bg-[#e6f8f7] hover:border-[#2ca7a3] hover:text-[#2ca7a3] transition-colors font-medium">Bamboo Socks</a>
                <a href="{{ route('shop.search.index', ['query' => 'Ankle']) }}" class="px-3 py-1 rounded-full bg-white border border-slate-200 hover:bg-[#e6f8f7] hover:border-[#2ca7a3] hover:text-[#2ca7a3] transition-colors font-medium">Ankle Socks</a>
                <a href="{{ route('shop.search.index', ['query' => 'Crew']) }}" class="px-3 py-1 rounded-full bg-white border border-slate-200 hover:bg-[#e6f8f7] hover:border-[#2ca7a3] hover:text-[#2ca7a3] transition-colors font-medium">Crew Socks</a>
                <a href="{{ route('shop.search.index', ['query' => 'Pack of 6']) }}" class="px-3 py-1 rounded-full bg-white border border-slate-200 hover:bg-[#e6f8f7] hover:border-[#2ca7a3] hover:text-[#2ca7a3] transition-colors font-medium">Pack of 6</a>
                <a href="{{ route('shop.search.index', ['query' => 'Men']) }}" class="px-3 py-1 rounded-full bg-white border border-slate-200 hover:bg-[#e6f8f7] hover:border-[#2ca7a3] hover:text-[#2ca7a3] transition-colors font-medium">Men's</a>
                <a href="{{ route('shop.search.index', ['query' => 'Women']) }}" class="px-3 py-1 rounded-full bg-white border border-slate-200 hover:bg-[#e6f8f7] hover:border-[#2ca7a3] hover:text-[#2ca7a3] transition-colors font-medium">Women's</a>
            </div>

            @if ($searchInstead)
                <form
                    action="{{ route('shop.search.index', ['suggest' => false]) }}"
                    class="flex max-w-[445px] items-center justify-center mx-auto pt-2"
                    role="search"
                >
                    <input
                        type="text"
                        name="query"
                        class="hidden"
                        value="{{ $searchInstead }}"
                    >

                    <input
                        type="text"
                        name="suggest"
                        class="hidden"
                        value="0"
                    >

                    <p class="text-xs text-[#6b7280]" v-pre>
                        {{ trans('shop::app.search.suggest') }}
                        <button
                            type="submit"
                            class="text-[#2ca7a3] font-semibold underline underline-offset-2 hover:text-[#133b63]"
                        >
                            {{ $searchInstead }}
                        </button>
                    </p>
                </form>
            @endif
        </section>

        <!-- Product Search Results Vue Component -->
        <main class="site-container pb-20">
            <v-search>
                <x-shop::shimmer.categories.view />
            </v-search>
        </main>
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-search-template"
        >
            <div>
                <div class="flex items-start gap-8 lg:gap-10">
                    <!-- Product Listing Filters (Sidebar) -->
                    @include('shop::categories.filters')

                    <!-- Product Listing Container -->
                    <div class="flex-1" id="product-listing-container">
                        <!-- Desktop Product Listing Toolbar (Sorting, Layout Mode) -->
                        <div class="max-md:hidden">
                            @include('shop::categories.toolbar')
                        </div>

                        <!-- Product List Mode Card Container -->
                        <div
                            class="mt-8 grid grid-cols-1 gap-6"
                            v-if="(filters.toolbar.applied.mode ?? filters.toolbar.default.mode) === 'list'"
                        >
                            <!-- Shimmer Effect -->
                            <template v-if="isLoading">
                                <x-shop::shimmer.products.cards.list count="12" />
                            </template>

                            <!-- Product List Cards -->
                            <template v-else>
                                <template v-if="products.length">
                                    <x-shop::products.card
                                        ::mode="'list'"
                                        v-for="product in products"
                                    />
                                </template>

                                <!-- Empty State -->
                                <template v-else>
                                     <div class="rounded-3xl border border-slate-200 bg-white p-8 sm:p-14 text-center max-w-xl mx-auto shadow-sm space-y-5 my-12">
                                         <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-2xl">
                                             <i class="fa-solid fa-magnifying-glass text-2xl opacity-60"></i>
                                         </div>

                                         <div class="space-y-2">
                                             <h3 class="text-2xl font-bold text-[#133b63]">
                                                 No Socks Found
                                             </h3>
                                             <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed max-w-md mx-auto">
                                                 We couldn't find any products matching your search. Try checking for typos or searching for <em>Diabetic</em>, <em>Ankle</em>, or <em>Bamboo</em>.
                                             </p>
                                         </div>

                                         <div class="pt-2">
                                             <a
                                                 href="{{ route('shop.product_or_category.index', 'products') }}"
                                                 class="soxnsox-btn-primary inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold px-6 py-3"
                                             >
                                                 <span>Explore All Socks</span>
                                                 <i class="fa-solid fa-arrow-right text-xs"></i>
                                             </a>
                                         </div>
                                     </div>
                                 </template>
                            </template>
                        </div>

                        <!-- Product Grid Mode Card Container -->
                        <div v-else>
                            <!-- Shimmer Effect -->
                            <template v-if="isLoading">
                                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                                    <x-shop::shimmer.products.cards.grid count="12" />
                                </div>
                            </template>

                            <!-- Product Grid Cards -->
                            <template v-else>
                                <template v-if="products.length">
                                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                                        <x-shop::products.card
                                            ::mode="'grid'"
                                            v-for="product in products"
                                            :navigation-link="route('shop.search.index')"
                                        />
                                    </div>
                                </template>

                                <!-- Empty State -->
                                <template v-else>
                                    <div class="rounded-3xl border border-slate-200 bg-white p-8 sm:p-14 text-center max-w-xl mx-auto shadow-sm space-y-5 my-12">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#e6f8f7] text-[#2ca7a3] text-2xl">
                                            <i class="fa-solid fa-magnifying-glass text-2xl opacity-60"></i>
                                        </div>

                                        <div class="space-y-2">
                                            <h3 class="text-2xl font-bold text-[#133b63]">
                                                 No Socks Found
                                            </h3>
                                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed max-w-md mx-auto">
                                                We couldn't find any products matching your search. Try checking for typos or searching for <em>Diabetic</em>, <em>Ankle</em>, or <em>Bamboo</em>.
                                            </p>
                                        </div>

                                        <div class="pt-2">
                                            <a
                                                href="{{ route('shop.product_or_category.index', 'products') }}"
                                                class="soxnsox-btn-primary inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold px-6 py-3"
                                            >
                                                <span>Explore All Socks</span>
                                                <i class="fa-solid fa-arrow-right text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>

                        <!-- Results Summary & Numbered Pagination Bar -->
                        <div v-if="!isLoading && meta.total && meta.total > 0" class="mt-12 pt-8 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Showing Count -->
                            <p class="text-xs sm:text-sm font-medium text-slate-500">
                                Showing <span class="font-bold text-[#133b63]">@{{ meta.from ?? 1 }}</span> - <span class="font-bold text-[#133b63]">@{{ meta.to ?? products.length }}</span> of <span class="font-bold text-[#133b63]">@{{ meta.total }}</span> socks
                            </p>

                            <!-- Numbered Page Pills -->
                            <nav v-if="meta.last_page > 1" class="flex items-center gap-1.5" aria-label="Search Pagination">
                                <!-- Previous Button -->
                                <button
                                    type="button"
                                    :disabled="page <= 1"
                                    @click="changePage(page - 1)"
                                    class="h-10 px-3.5 inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white text-xs font-semibold text-[#133b63] shadow-xs transition-all hover:border-[#2ca7a3] hover:text-[#2ca7a3] hover:bg-teal-50/40 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:border-slate-200 disabled:hover:text-[#133b63] disabled:hover:bg-white active:scale-95"
                                    aria-label="Previous page"
                                >
                                    <i class="fa-solid fa-chevron-left text-[11px]"></i>
                                    <span class="hidden sm:inline">Prev</span>
                                </button>

                                <!-- Page Numbers -->
                                <template v-for="pageNum in paginationPages" :key="pageNum">
                                    <span v-if="pageNum === '...'" class="px-2 text-slate-400 font-bold select-none text-xs">...</span>
                                    <button
                                        v-else
                                        type="button"
                                        @click="changePage(pageNum)"
                                        :class="pageNum === page 
                                            ? 'h-10 w-10 inline-flex items-center justify-center rounded-full bg-[#133b63] text-white font-bold text-xs shadow-md border border-[#133b63] cursor-default' 
                                            : 'h-10 w-10 inline-flex items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 font-semibold text-xs shadow-xs transition-all hover:border-[#2ca7a3] hover:text-[#2ca7a3] hover:bg-teal-50/40 active:scale-95'"
                                    >
                                        @{{ pageNum }}
                                    </button>
                                </template>

                                <!-- Next Button -->
                                <button
                                    type="button"
                                    :disabled="page >= meta.last_page"
                                    @click="changePage(page + 1)"
                                    class="h-10 px-3.5 inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white text-xs font-semibold text-[#133b63] shadow-xs transition-all hover:border-[#2ca7a3] hover:text-[#2ca7a3] hover:bg-teal-50/40 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:border-slate-200 disabled:hover:text-[#133b63] disabled:hover:bg-white active:scale-95"
                                    aria-label="Next page"
                                >
                                    <span class="hidden sm:inline">Next</span>
                                    <i class="fa-solid fa-chevron-right text-[11px]"></i>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-search', {
                template: '#v-search-template',

                data() {
                    return {
                        isMobile: window.innerWidth <= 767,

                        isLoading: true,

                        isDrawerActive: {
                            toolbar: false,

                            filter: false,
                        },

                        filters: {
                            toolbar: {
                                default: {},

                                applied: {},
                            },

                            filter: {},
                        },

                        products: [],

                        links: {},

                        meta: {},

                        page: 1,

                        loader: false,

                        isMounted: false,
                    }
                },

                created() {
                    let urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('page')) {
                        let pageVal = parseInt(urlParams.get('page'));
                        if (pageVal > 0) {
                            this.page = pageVal;
                        }
                    }
                },

                mounted() {
                    this.isMounted = true;

                    window.addEventListener('popstate', () => {
                        let urlParams = new URLSearchParams(window.location.search);
                        let pageFromUrl = urlParams.has('page') ? parseInt(urlParams.get('page')) : 1;
                        if (pageFromUrl > 0 && pageFromUrl !== this.page) {
                            this.page = pageFromUrl;
                            this.getProducts();
                        }
                    });
                },

                computed: {
                    queryParams() {
                        let queryParams = Object.assign({}, this.filters.filter, this.filters.toolbar.applied);

                        delete queryParams.page;

                        if (this.page > 1) {
                            queryParams.page = this.page;
                        }

                        return this.removeJsonEmptyValues(queryParams);
                    },

                    queryString() {
                        return this.jsonToQueryString(this.queryParams);
                    },

                    paginationPages() {
                        if (!this.meta.last_page || this.meta.last_page <= 1) {
                            return [];
                        }

                        const current = this.page;
                        const last = this.meta.last_page;
                        const delta = 1;
                        const range = [];
                        const rangeWithDots = [];
                        let l;

                        for (let i = 1; i <= last; i++) {
                            if (i === 1 || i === last || (i >= current - delta && i <= current + delta)) {
                                range.push(i);
                            }
                        }

                        for (let i of range) {
                            if (l) {
                                if (i - l === 2) {
                                    rangeWithDots.push(l + 1);
                                } else if (i - l !== 1) {
                                    rangeWithDots.push('...');
                                }
                            }
                            rangeWithDots.push(i);
                            l = i;
                        }

                        return rangeWithDots;
                    },
                },

                watch: {
                    queryParams() {
                        this.getProducts();
                    },

                    queryString() {
                        const newUrl = this.queryString ? '?' + this.queryString : window.location.pathname;
                        window.history.pushState({}, '', newUrl);
                    },
                },

                methods: {
                    setFilters(type, filters) {
                        if (type === 'filter') {
                            if (this.isMounted) {
                                this.page = 1;
                            }
                        } else if (type === 'toolbar') {
                            if (
                                this.isMounted &&
                                ((filters.applied?.sort !== this.filters.toolbar.applied?.sort) ||
                                (filters.applied?.limit !== this.filters.toolbar.applied?.limit))
                            ) {
                                this.page = 1;
                            }
                        }

                        this.filters[type] = filters;
                    },

                    clearFilters(type, filters) {
                        this.page = 1;
                        this.filters[type] = {};
                    },

                    getProducts() {
                        this.isDrawerActive = {
                            toolbar: false,

                            filter: false,
                        };

                        this.isLoading = true;

                        this.$axios.get(("{{ route('shop.api.products.index') }}"), {
                            params: this.queryParams
                        })
                            .then(response => {
                                this.isLoading = false;

                                this.products = response.data.data;

                                this.links = response.data.links || {};

                                this.meta = response.data.meta || {};

                                if (this.meta.current_page) {
                                    this.page = this.meta.current_page;
                                }
                            }).catch(error => {
                                this.isLoading = false;
                                console.log(error);
                            });
                    },

                    changePage(pageNumber) {
                        pageNumber = parseInt(pageNumber);

                        if (isNaN(pageNumber) || pageNumber < 1 || (this.meta.last_page && pageNumber > this.meta.last_page) || pageNumber === this.page) {
                            return;
                        }

                        this.page = pageNumber;

                        this.getProducts();

                        this.$nextTick(() => {
                            const grid = document.querySelector('#product-listing-container') || this.$el;
                            if (grid) {
                                const yOffset = -90;
                                const y = grid.getBoundingClientRect().top + window.pageYOffset + yOffset;
                                window.scrollTo({ top: y, behavior: 'smooth' });
                            }
                        });
                    },

                    loadMoreProducts() {
                        if (this.links.next) {
                            this.loader = true;

                            this.$axios.get(this.links.next).then(response => {
                                this.loader = false;

                                this.products = [...this.products, ...response.data.data];

                                this.links = response.data.links || {};

                                this.meta = response.data.meta || {};

                                if (this.meta.current_page) {
                                    this.page = this.meta.current_page;
                                }
                            }).catch(error => {
                                this.loader = false;
                                console.log(error);
                            });
                        }
                    },

                    removeJsonEmptyValues(params) {
                        Object.keys(params).forEach(function (key) {
                            if ((! params[key] && params[key] !== undefined)) {
                                delete params[key];
                            }

                            if (Array.isArray(params[key])) {
                                params[key] = params[key].join(',');
                            }
                        });

                        return params;
                    },

                    jsonToQueryString(params) {
                        let parameters = new URLSearchParams();

                        for (const key in params) {
                            parameters.append(key, params[key]);
                        }

                        return parameters.toString();
                    }
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
