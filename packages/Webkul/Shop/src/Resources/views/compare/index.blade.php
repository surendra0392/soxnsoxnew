<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.compare.title')"/>

    <meta name="keywords" content="@lang('shop::app.compare.title')"/>
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.compare.title') | SOXNSOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-screen">
        <!-- Breadcrumb -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-[#6b7280]">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#133b63] transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <span class="text-[#133b63] font-semibold">@lang('shop::app.compare.title')</span>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="site-container pt-4 pb-8 sm:pt-6 sm:pb-10">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#e9f2fa] text-[#1d5b8f] text-[10px] sm:text-xs font-semibold tracking-widest uppercase">
                    <i class="fa-solid fa-code-compare text-xs"></i>
                    <span>Side-by-Side Analysis</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63] font-display">
                    @lang('shop::app.compare.title')
                </h1>
                <div class="soxnsox-decorative-line"></div>
            </div>
        </div>

        <!-- Compare Component -->
        <main class="site-container pb-20">
            <v-compare>
                <!-- Shimmer Effect -->
                <x-shop::shimmer.compare :attributeCount="count($comparableAttributes)" />
            </v-compare>
        </main>
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-compare-template"
        >
            <div>
                {!! view_render_event('bagisto.shop.customers.account.compare.before') !!}

                <div v-if="! isLoading">
                    <div class="flex items-center justify-end mb-6" v-if="items.length">
                        {!! view_render_event('bagisto.shop.customers.account.compare.remove_all.before') !!}

                        <button
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-soxnsox-border bg-white text-xs font-semibold text-soxnsox-muted hover:text-red-600 hover:border-red-200 transition-colors"
                            @click="removeAll"
                        >
                            <i class="fa-regular fa-trash-can text-xs"></i>
                            @lang('shop::app.compare.delete-all')
                        </button>

                        {!! view_render_event('bagisto.shop.customers.account.compare.remove_all.after') !!}
                    </div>

                    <div
                        class="journal-scroll mt-6 grid overflow-auto rounded-3xl border border-soxnsox-border bg-white p-6 shadow-soxnsox-subtle"
                        v-if="items.length"
                    >
                        <template v-for="attribute in comparableAttributes">
                            <!-- Product Card -->
                            <div
                                class="flex max-w-full items-center border-b border-soxnsox-border/60 py-4"
                                v-if="attribute.code == 'product'"
                            >
                                {!! view_render_event('bagisto.shop.customers.account.compare.attribute_name.before') !!}

                                <div class="min-w-[240px] max-w-full font-display font-bold text-[#133b63] text-base">
                                    <p class="text-sm font-semibold uppercase tracking-wider text-soxnsox-muted">
                                        @{{ attribute.name ?? attribute.admin_name }}
                                    </p>
                                </div>

                                {!! view_render_event('bagisto.shop.customers.account.compare.attribute_name.after') !!}

                                <div class="flex gap-4 border-soxnsox-border/60 ltr:border-l-[1px] rtl:border-r-[1px] pl-6">
                                    <div
                                        class="relative w-[280px] max-w-[280px] px-2"
                                        v-for="product in items"
                                    >
                                        <button
                                            class="absolute top-2 right-2 z-[1] flex h-7 w-7 cursor-pointer items-center justify-center rounded-full border border-soxnsox-border bg-white text-soxnsox-muted hover:text-red-600 shadow-sm transition-colors"
                                            @click="remove(product.id)"
                                            title="Remove"
                                        >
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>

                                        <x-shop::products.card class="[&_.fa-code-compare]:hidden [&_button:has(.fa-code-compare)]:hidden" />
                                    </div>
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.customers.account.compare.comparable_attribute.before') !!}

                            <!-- Comparable Attributes -->
                            <div
                                class="flex max-w-full items-center border-b border-soxnsox-border/60 py-4"
                                v-else
                            >
                                <div class="min-w-[240px] max-w-full">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-soxnsox-muted">
                                        @{{ attribute.name ?? attribute.admin_name }}
                                    </p>
                                </div>

                                <div class="flex gap-4 border-soxnsox-border/60 ltr:border-l-[1px] rtl:border-r-[1px] pl-6">
                                    <div
                                        class="w-[280px] max-w-[280px] px-2"
                                        v-for="(product, index) in items"
                                    >
                                        <p
                                            class="text-sm text-soxnsox-charcoal leading-relaxed"
                                            v-html="product[attribute.code] ?? '—'"
                                        >
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.customers.account.compare.comparable_attribute.after') !!}
                        </template>
                    </div>

                    <!-- Clean Empty Compare State -->
                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-10 sm:p-16 lg:p-20 text-center max-w-2xl mx-auto shadow-sm space-y-6 my-10"
                        v-else
                    >
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#e9f2fa] border border-[#1d5b8f]/20 text-2xl text-[#1d5b8f]">
                            <i class="fa-solid fa-code-compare"></i>
                        </div>

                        <div class="space-y-2">
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                                @lang('shop::app.compare.empty-text')
                            </h2>
                            <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed max-w-md mx-auto">
                                Add bamboo socks or diabetic styles to compare knit density, cushioning, and features side-by-side.
                            </p>
                        </div>

                        <div class="pt-2">
                            <a
                                href="{{ url('/products') }}"
                                class="soxnsox-btn-primary inline-flex h-12 items-center justify-center px-8 text-xs uppercase tracking-widest font-semibold gap-2 shadow-sm"
                            >
                                <span>Explore Bamboo Socks</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div v-else>
                    <!---- Shimmer Effect -->
                    <x-shop::shimmer.compare :attributeCount="count($comparableAttributes)" />
                </div>

                {!! view_render_event('bagisto.shop.customers.account.compare.after') !!}
            </div>
        </script>

        <script type="module">
            app.component("v-compare", {
                template: '#v-compare-template',

                data() {
                    return  {
                        comparableAttributes: [
                            ...[{'code': 'product', 'name': 'Product'}],
                            ...@json($comparableAttributes)
                        ],

                        items: [],

                        isCustomer: '{{ auth()->guard('customer')->check() }}',

                        isLoading: true,
                    }
                },

                mounted() {
                    this.getItems();
                },

                methods: {
                    getItems() {
                        let productIds = [];

                        if (! this.isCustomer) {
                            productIds = this.getStorageValue('compare_items');
                        }

                        this.$axios.get("{{ route('shop.api.compare.index') }}", {
                                params: {
                                    product_ids: productIds,
                                },
                            })
                            .then(response => {
                                this.isLoading = false;

                                this.items = response.data.data;
                            })
                            .catch(error => {});
                    },

                    remove(productId) {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                if (! this.isCustomer) {
                                    const index = this.items.findIndex((item) => item.id === productId);

                                    this.items.splice(index, 1);

                                    let items = this.getStorageValue()
                                        .filter(item => item != productId);

                                    localStorage.setItem('compare_items', JSON.stringify(items));

                                    return;
                                }

                                this.$axios.post("{{ route('shop.api.compare.destroy') }}", {
                                        '_method': 'DELETE',
                                        'product_id': productId,
                                    })
                                    .then(response => {
                                        this.items = response.data.data;

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    })
                                    .catch(error => {
                                        this.$emitter.emit('add-flash', { type: 'error', message: response.data.message });
                                    });
                            }
                        });
                    },

                    removeAll() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                if (! this.isCustomer) {
                                    localStorage.removeItem('compare_items');

                                    this.items = [];

                                    this.$emitter.emit('add-flash', { type: 'success', message:  "@lang('shop::app.compare.remove-all-success')" });

                                    return;
                                }

                                this.$axios.post("{{ route('shop.api.compare.destroy_all') }}", {
                                        '_method': 'DELETE',
                                    })
                                    .then(response => {
                                        this.items = [];

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                    })
                                    .catch(error => {});
                            }
                        });
                    },

                    getStorageValue() {
                        let value = localStorage.getItem('compare_items');

                        if (! value) {
                            return [];
                        }

                        return JSON.parse(value);
                    },
                }
            });
        </script>
    @endpushOnce
</x-shop::layouts>
