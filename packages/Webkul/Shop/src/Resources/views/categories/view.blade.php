<!-- SEO Meta Content -->
@push('meta')
    @php
        $categoryTitle = trim($category->meta_title) != '' ? $category->meta_title : $category->name . ' | SOX N SOX Bamboo Socks';
        $categoryDesc  = trim($category->meta_description) != '' ? $category->meta_description : \Illuminate\Support\Str::limit(strip_tags($category->description), 160, '');
        $categoryKeys  = trim($category->meta_keywords) != '' ? $category->meta_keywords : 'bamboo socks, diabetic socks, seamless socks, soxnsox';
        $categoryImage = $category->banner_url ?: asset('images/hero-slide-1.webp');
    @endphp

    <meta name="title" content="{{ $categoryTitle }}" />
    <meta name="description" content="{{ $categoryDesc }}" />
    <meta name="keywords" content="{{ $categoryKeys }}" />
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $categoryTitle }}" />
    <meta name="twitter:description" content="{{ $categoryDesc }}" />
    <meta name="twitter:image" content="{{ $categoryImage }}" />
    <meta name="twitter:image:alt" content="{{ $category->name }} Bamboo Socks" />

    <meta property="og:type" content="product.group" />
    <meta property="og:title" content="{{ $categoryTitle }}" />
    <meta property="og:description" content="{{ $categoryDesc }}" />
    <meta property="og:url" content="{{ url('/' . $category->slug) }}" />
    <meta property="og:image" content="{{ $categoryImage }}" />
    <meta property="og:image:alt" content="{{ $category->name }} Bamboo Socks" />

    <!-- BreadcrumbList Schema.org -->
    @php
        $categoryBreadcrumbSchema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type'    => 'ListItem',
                    '@id'      => url('/') . '#breadcrumb-home',
                    'position' => 1,
                    'name'     => 'Home',
                    'item'     => url('/'),
                ],
                [
                    '@type'    => 'ListItem',
                    '@id'      => url('/' . $category->slug) . '#breadcrumb-category',
                    'position' => 2,
                    'name'     => $category->name,
                    'item'     => url('/' . $category->slug),
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($categoryBreadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    @if (core()->getConfigData('catalog.rich_snippets.categories.enable') ?? true)
        <script type="application/ld+json">
            {!! app('Webkul\Product\Helpers\SEO')->getCategoryJsonLd($category) !!}
        </script>
    @endif
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ trim($category->meta_title) != "" ? $category->meta_title : $category->name }}
    </x-slot>

    @if (core()->getConfigData('general.general.breadcrumbs.shop'))
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-soxnsox-muted">
                <a href="{{ route('shop.home.index') }}" class="hover:text-soxnsox-teal transition-colors">Home</a>
                <span class="text-soxnsox-border">/</span>
                <span class="text-soxnsox-charcoal font-semibold">{{ $category->name }}</span>
            </nav>
        </div>
    @endif

    {!! view_render_event('bagisto.shop.categories.view.banner_path.before') !!}

    <!-- Hero Image -->
    @if ($category->banner_path)
        <div class="site-container mt-4 sm:mt-6">
            <x-shop::media.images.lazy
                class="aspect-[4/1] max-h-full max-w-full rounded-xl"
                src="{{ $category->banner_url }}"
                alt="{{ $category->name }}"
                width="1320"
                height="300"
            />
        </div>
    @endif

    {!! view_render_event('bagisto.shop.categories.view.banner_path.after') !!}

    {!! view_render_event('bagisto.shop.categories.view.description.before') !!}

    @if (in_array($category->display_mode, [null, 'description_only', 'products_and_description']))
        <section class="site-container pt-6 pb-8 sm:pt-10 sm:pb-12 text-center max-w-3xl mx-auto space-y-3 reveal-on-scroll reveal-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-[0.14em] bg-teal-50 border border-[#2ca7a3]/20 text-[#2ca7a3]">
                <i class="fa-solid fa-feather text-[10px]"></i> 100% Pure Bamboo Collection
            </span>

            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] leading-tight">
                {{ $category->name }}
            </h1>

            <div class="h-1 w-16 bg-gradient-to-r from-[#2ca7a3] to-[#f29a38] rounded-full mx-auto my-2"></div>

            @if ($category->description)
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed mx-auto max-w-2xl pt-1">
                    {!! $category->description !!}
                </div>
            @endif
        </section>
    @endif

    {!! view_render_event('bagisto.shop.categories.view.description.after') !!}

    @if (in_array($category->display_mode, [null, 'products_only', 'products_and_description']))
        <!-- Category Vue Component -->
        <v-category>
            <!-- Category Shimmer Effect -->
            <x-shop::shimmer.categories.view />
        </v-category>
    @endif

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-category-template"
        >
            <div class="site-container pb-16 sm:pb-24">
                <div class="flex items-start gap-10 max-lg:gap-5 md:mt-10">
                    <!-- Product Listing Filters -->
                    @include('shop::categories.filters')

                    <!-- Product Listing Container -->
                    <div class="flex-1" id="product-listing-container">
                        <!-- Desktop Product Listing Toolbar -->
                        <div class="max-md:hidden">
                            @include('shop::categories.toolbar')
                        </div>

                        <!-- Product List Card Container -->
                        <div
                            class="mt-8 grid grid-cols-1 gap-6"
                            v-if="(filters.toolbar.applied.mode ?? filters.toolbar.default.mode) === 'list'"
                        >
                            <!-- Product Card Shimmer Effect -->
                            <template v-if="isLoading">
                                <x-shop::shimmer.products.cards.list count="12" />
                            </template>

                            <!-- Product Card Listing -->
                            {!! view_render_event('bagisto.shop.categories.view.list.product_card.before') !!}

                            <template v-else>
                                <template v-if="products.length">
                                    <x-shop::products.card
                                        ::mode="'list'"
                                        v-for="product in products"
                                    />
                                </template>

                                <!-- Empty Products Container -->
                                <template v-else>
                                    <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                        <img
                                            class="max-md:h-[100px] max-md:w-[100px]"
                                            src="{{ bagisto_asset('images/thank-you.png') }}"
                                            alt="@lang('shop::app.categories.view.empty')"
                                            loading="lazy"
                                            decoding="async"
                                        />

                                        <p
                                            class="text-xl max-md:text-sm"
                                            role="heading"
                                        >
                                            @lang('shop::app.categories.view.empty')
                                        </p>
                                    </div>
                                </template>
                            </template>

                            {!! view_render_event('bagisto.shop.categories.view.list.product_card.after') !!}
                        </div>

                        <!-- Product Grid Card Container -->
                        <div v-else class="mt-8 max-md:mt-5">
                            <!-- Product Card Shimmer Effect -->
                            <template v-if="isLoading">
                                <div class="grid grid-cols-3 gap-8 max-1060:grid-cols-2 max-md:justify-items-center max-md:gap-x-4">
                                    <x-shop::shimmer.products.cards.grid count="12" />
                                </div>
                            </template>

                            {!! view_render_event('bagisto.shop.categories.view.grid.product_card.before') !!}

                            <!-- Product Card Listing -->
                            <template v-else>
                                <template v-if="products.length">
                                    <div class="grid grid-cols-3 gap-8 max-1060:grid-cols-2 max-md:justify-items-center max-md:gap-x-4">
                                        <x-shop::products.card
                                            ::mode="'grid'"
                                            v-for="product in products"
                                        />
                                    </div>
                                </template>

                                <!-- Empty Products Container -->
                                <template v-else>
                                    <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                        <img
                                            class="max-md:h-[100px] max-md:w-[100px]"
                                            src="{{ bagisto_asset('images/thank-you.png') }}"
                                            alt="@lang('shop::app.categories.view.empty')"
                                            loading="lazy"
                                            decoding="async"
                                        />

                                        <p
                                            class="text-xl max-md:text-sm"
                                            role="heading"
                                        >
                                            @lang('shop::app.categories.view.empty')
                                        </p>
                                    </div>
                                </template>
                            </template>

                            {!! view_render_event('bagisto.shop.categories.view.grid.product_card.after') !!}
                        </div>

                        {!! view_render_event('bagisto.shop.categories.view.load_more_button.before') !!}

                        <!-- Results Summary & Numbered Pagination Bar -->
                        <div v-if="!isLoading && meta.total && meta.total > 0" class="mt-12 pt-8 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Showing Count -->
                            <p class="text-xs sm:text-sm font-medium text-slate-500">
                                Showing <span class="font-bold text-[#133b63]">@{{ meta.from ?? 1 }}</span> - <span class="font-bold text-[#133b63]">@{{ meta.to ?? products.length }}</span> of <span class="font-bold text-[#133b63]">@{{ meta.total }}</span> socks
                            </p>

                            <!-- Numbered Page Pills -->
                            <nav v-if="meta.last_page > 1" class="flex items-center gap-1.5" aria-label="Product Pagination">
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

                        {!! view_render_event('bagisto.shop.categories.view.grid.load_more_button.after') !!}
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-category', {
                template: '#v-category-template',

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

                        document.body.style.overflow ='scroll';

                        this.isLoading = true;

                        this.$axios.get("{{ route('shop.api.products.index', ['category_id' => $category->id]) }}", {
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
                        if (! this.links.next) {
                            return;
                        }

                        this.loader = true;

                        this.$axios.get(this.links.next)
                            .then(response => {
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
