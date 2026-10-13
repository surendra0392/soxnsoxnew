<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="@lang('shop::app.checkout.cart.index.cart') | SOXNSOX" />
    <meta name="description" content="Review and manage items in your SOXNSOX shopping cart." />
    <meta name="robots" content="noindex, nofollow" />
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.cart.index.cart') | SOXNSOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-screen">
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-soxnsox-muted">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#1d5b8f] transition-colors">Home</a>
                <span class="text-soxnsox-border">/</span>
                <span class="text-soxnsox-charcoal font-semibold">Shopping Cart</span>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="site-container pt-4 pb-8 sm:pt-6 sm:pb-10">
            <div class="space-y-2">
                <div class="soxnsox-badge-teal text-[10px] sm:text-xs tracking-wider uppercase inline-flex items-center gap-2">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Your Selection</span>
                </div>
                <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63]">
                    Shopping Cart
                </h1>
                <div class="soxnsox-decorative-line mt-2"></div>
            </div>
        </div>

        <!-- Cart Main Container -->
        <main class="site-container pb-20">
            <v-cart ref="vCart">
                <!-- Cart Shimmer Effect -->
                <x-shop::shimmer.checkout.cart :count="3" />
            </v-cart>
        </main>
    </div>

    @if (core()->getConfigData('sales.checkout.shopping_cart.cross_sell'))
        {!! view_render_event('bagisto.shop.checkout.cart.cross_sell_carousel.before') !!}

        <!-- Cross-sell Product Carousel -->
        <x-shop::products.carousel
            :title="trans('shop::app.checkout.cart.index.cross-sell.title')"
            :src="route('shop.api.checkout.cart.cross-sell.index')"
        />

        {!! view_render_event('bagisto.shop.checkout.cart.cross_sell_carousel.after') !!}
    @endif

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-cart-template"
        >
            <div>
                <!-- Cart Shimmer Effect -->
                <template v-if="isLoading">
                    <x-shop::shimmer.checkout.cart :count="3" />
                </template>

                <!-- Cart Information -->
                <template v-else>
                    <div
                        class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start"
                        v-if="cart?.items?.length"
                    >
                        <!-- Left Column: Cart Items List -->
                        <div class="flex-1 w-full space-y-6">
                            <!-- Complimentary Free Shipping Progress Banner -->
                            <div class="rounded-2xl bg-[#e6f8f7] border border-[#b6e6e3] p-4 flex items-center gap-3.5 shadow-sm text-xs sm:text-sm font-semibold text-[#208a86]" v-if="parseFloat(cart.sub_total || 0) >= 499">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2ca7a3] text-white">
                                    <i class="fa-solid fa-truck-fast text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0 space-y-1">
                                    <div class="flex items-center justify-between">
                                        <p class="font-bold flex items-center gap-1.5"><i class="fa-solid fa-gift text-[#208a86]"></i> You unlocked Complimentary Express Shipping!</p>
                                        <span class="text-xs font-bold uppercase tracking-wider text-[#2ca7a3]">FREE</span>
                                    </div>
                                    <div class="w-full mt-1.5 bg-[#b6e6e3] h-2 rounded-full overflow-hidden">
                                        <div style="background-color: #2ca7a3; height: 100%; width: 100%; border-radius: 9999px; transition: width 0.5s ease-out;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-white border border-[#e5e7eb] p-4 space-y-2.5 shadow-sm text-xs sm:text-sm" v-else>
                                <div class="flex items-center justify-between gap-3 text-[#133b63] font-medium">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-truck-fast text-[#1d5b8f] text-sm"></i>
                                        <span>Add <strong class="text-[#1d5b8f] font-bold">₹@{{ (499 - parseFloat(cart.sub_total || 0)).toFixed(2) }}</strong> more for <strong class="text-[#133b63]">Complimentary Express Shipping</strong></span>
                                    </div>
                                    <span class="text-xs font-bold text-[#1d5b8f] shrink-0 px-2.5 py-0.5 rounded-full bg-[#e9f2fa]">@{{ Math.round((parseFloat(cart.sub_total || 0) / 499) * 100) }}%</span>
                                </div>
                                <div class="w-full bg-[#e5e7eb] h-2 rounded-full overflow-hidden">
                                    <div style="background: linear-gradient(90deg, #1d5b8f 0%, #2ca7a3 100%); height: 100%; border-radius: 9999px; transition: width 0.5s ease-out;" :style="'width: ' + Math.min(100, Math.round((parseFloat(cart.sub_total || 0) / 499) * 100)) + '%'"></div>
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.cart_mass_actions.before') !!}

                            <!-- Cart Items Card -->
                            <div class="rounded-3xl border border-soxnsox-border/80 bg-white p-6 sm:p-8 shadow-soxnsox-subtle space-y-6">
                                <!-- Mass Action / Select All Header -->
                                <div class="flex items-center justify-between border-b border-soxnsox-border/60 pb-4">
                                    <div class="flex select-none items-center gap-2.5">
                                        <input
                                            type="checkbox"
                                            id="select-all"
                                            class="h-4 w-4 rounded border-soxnsox-border text-soxnsox-teal focus:ring-soxnsox-teal cursor-pointer"
                                            v-model="allSelected"
                                            @change="selectAll"
                                        >

                                        <label
                                            for="select-all"
                                            class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-soxnsox-charcoal cursor-pointer"
                                        >
                                            @{{ "@lang('shop::app.checkout.cart.index.items-selected')".replace(':count', selectedItemsCount) }}
                                        </label>
                                    </div>

                                    <div v-if="selectedItemsCount" class="flex items-center gap-3">
                                        <button
                                            type="button"
                                            class="text-xs font-semibold uppercase tracking-wider text-red-600 hover:text-red-700 transition-colors"
                                            @click="removeSelectedItems"
                                        >
                                            @lang('shop::app.checkout.cart.index.remove')
                                        </button>

                                        @if (auth()->guard()->check())
                                            <span class="text-soxnsox-border">|</span>

                                            <button
                                                type="button"
                                                class="text-xs font-semibold uppercase tracking-wider text-soxnsox-teal hover:text-soxnsox-navy transition-colors"
                                                @click="moveToWishlistSelectedItems"
                                            >
                                                @lang('shop::app.checkout.cart.index.move-to-wishlist')
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                {!! view_render_event('bagisto.shop.checkout.cart.cart_mass_actions.after') !!}

                                {!! view_render_event('bagisto.shop.checkout.cart.item.listing.before') !!}

                                <!-- Cart Items List -->
                                <div class="divide-y divide-soxnsox-border/60">
                                    <div
                                        class="py-6 first:pt-2 last:pb-2 flex flex-col sm:flex-row gap-5 items-start justify-between"
                                        v-for="item in cart?.items"
                                    >
                                        <div class="flex gap-4 sm:gap-5 items-start flex-1 min-w-0">
                                            <!-- Checkbox -->
                                            <div class="pt-2 select-none">
                                                <input
                                                    type="checkbox"
                                                    :id="'item_' + item.id"
                                                    class="h-4 w-4 rounded border-soxnsox-border text-soxnsox-teal focus:ring-soxnsox-teal cursor-pointer"
                                                    v-model="item.selected"
                                                    @change="updateAllSelected"
                                                >
                                            </div>

                                            {!! view_render_event('bagisto.shop.checkout.cart.item_image.before') !!}

                                            <!-- Item Image -->
                                            <a
                                                :href="'{{ route('shop.products.view', ['category' => 'socks', 'slug' => ':slug']) }}'.replace(':slug', item.product_url_key)"
                                                class="shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-[#f8fafc] border border-soxnsox-border/70 overflow-hidden flex items-center justify-center"
                                            >
                                                <img
                                                    :src="item.base_image.small_image_url"
                                                    class="w-full h-full object-cover"
                                                    :alt="item.name"
                                                />
                                            </a>

                                            {!! view_render_event('bagisto.shop.checkout.cart.item_image.after') !!}

                                            <!-- Item Details -->
                                            <div class="flex-1 min-w-0 space-y-2">
                                                {!! view_render_event('bagisto.shop.checkout.cart.item_name.before') !!}

                                                <h3 class="font-display text-base sm:text-lg font-bold text-[#133b63] leading-snug">
                                                    <a
                                                        :href="'{{ route('shop.products.view', ['category' => 'socks', 'slug' => ':slug']) }}'.replace(':slug', item.product_url_key)"
                                                        class="hover:text-[#1d5b8f] transition-colors"
                                                    >
                                                        @{{ item.name }}
                                                    </a>
                                                </h3>

                                                {!! view_render_event('bagisto.shop.checkout.cart.item_name.after') !!}

                                                <!-- Price Display (Sale vs Regular Price) -->
                                                <div class="flex flex-wrap items-center gap-2 pt-0.5">
                                                    <span class="font-bold text-sm sm:text-base text-[#133b63]">
                                                        <template v-if="displayTax.prices == 'including_tax'">
                                                            @{{ item.formatted_price_incl_tax }}
                                                        </template>
                                                        <template v-else>
                                                            @{{ item.formatted_price }}
                                                        </template>
                                                    </span>

                                                    <span class="text-xs text-[#9ca3af] line-through font-normal" v-if="item.has_discount">
                                                        @{{ item.formatted_regular_price }}
                                                    </span>

                                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-[#e9f2fa] text-[#1d5b8f]" v-if="item.has_discount">
                                                        Save @{{ item.formatted_unit_discount }}
                                                    </span>
                                                </div>

                                                <!-- Weight & Options Variations -->
                                                <div class="flex flex-wrap items-center gap-1.5 pt-1 text-[11px] text-[#4b5563]">
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-[#f8fafc] border border-[#e5e7eb] font-medium"
                                                        v-if="item.formatted_weight"
                                                    >
                                                        <span class="text-[#9ca3af]">Weight:</span>
                                                        <span class="font-semibold text-[#133b63]">@{{ item.formatted_weight }}</span>
                                                    </span>

                                                    <template v-if="item.options.length">
                                                        <template v-for="attribute in item.options">
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-[#f8fafc] border border-[#e5e7eb] font-medium">
                                                                <span class="text-[#9ca3af]">@{{ attribute.attribute_name }}:</span>
                                                                <span class="font-semibold text-[#133b63]">@{{ attribute.option_label }}</span>
                                                            </span>
                                                        </template>
                                                    </template>
                                                </div>

                                                <!-- Quantity Changer & Actions (Mobile) -->
                                                <div class="pt-2 flex sm:hidden items-center justify-between">
                                                    <x-shop::quantity-changer
                                                        v-if="item.can_change_qty"
                                                        ::key="'qty-' + item.id + '-' + refreshKey"
                                                        class="h-8 max-w-[130px] px-2 py-0.5 rounded-lg text-xs"
                                                        name="quantity"
                                                        ::value="item?.quantity"
                                                        :removable="true"
                                                        @change="updateItem($event, item)"
                                                        @remove="removeItem(item.id)"
                                                    />

                                                    <button
                                                        type="button"
                                                        class="text-soxnsox-muted hover:text-red-600 transition-colors p-1"
                                                        title="@lang('shop::app.checkout.cart.index.remove')"
                                                        @click="removeItem(item.id)"
                                                    >
                                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quantity & Total (Desktop) -->
                                        <div class="hidden sm:flex flex-col items-end justify-between gap-4 self-stretch">
                                            <div class="text-right">
                                                <span class="font-display text-lg font-bold text-[#133b63]">
                                                    <template v-if="displayTax.subtotal == 'including_tax'">
                                                        @{{ item.formatted_total_incl_tax }}
                                                    </template>
                                                    <template v-else>
                                                        @{{ item.formatted_total }}
                                                    </template>
                                                </span>
                                            </div>

                                            <div class="flex items-center gap-3">
                                                <x-shop::quantity-changer
                                                    v-if="item.can_change_qty"
                                                    ::key="'qty-' + item.id + '-' + refreshKey"
                                                    class="h-9 max-w-[140px] px-3 py-1 rounded-xl text-xs"
                                                    name="quantity"
                                                    ::value="item?.quantity"
                                                    :removable="true"
                                                    @change="updateItem($event, item)"
                                                    @remove="removeItem(item.id)"
                                                />

                                                <button
                                                    type="button"
                                                    class="flex h-9 w-9 items-center justify-center rounded-xl text-soxnsox-muted hover:text-red-600 hover:bg-red-50 transition-colors"
                                                    title="@lang('shop::app.checkout.cart.index.remove')"
                                                    @click="removeItem(item.id)"
                                                >
                                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Order Summary -->
                        @include('shop::checkout.cart.summary')
                    </div>

                    <!-- Clean Empty Cart State -->
                    <div
                        class="rounded-3xl border border-soxnsox-border/80 bg-white p-10 sm:p-16 lg:p-20 text-center max-w-2xl mx-auto shadow-soxnsox-subtle space-y-6 my-10"
                        v-else
                    >
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#f8fafc] border border-soxnsox-border text-3xl text-[#1d5b8f]">
                            <i class="fa-solid fa-bag-shopping text-2xl text-[#1d5b8f]"></i>
                        </div>

                        <div class="space-y-2">
                            <h2 class="font-display text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                                @lang('shop::app.checkout.cart.index.empty-product')
                            </h2>
                            <div class="soxnsox-decorative-line-center mt-2.5"></div>
                            <p class="text-xs sm:text-sm text-soxnsox-muted leading-relaxed max-w-md mx-auto pt-1">
                                Explore the SOXNSOX collection and discover India's finest bamboo and diabetic socks.
                            </p>
                        </div>

                        <div class="pt-2">
                            <a
                                href="{{ route('shop.search.index') }}"
                                class="soxnsox-btn-primary soxnsox-btn-shimmer inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold px-8 py-3.5 shadow-soxnsox-card active:scale-95 transition-all duration-300"
                            >
                                <span>@lang('shop::app.checkout.cart.index.continue-shopping')</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </script>

        <script type="module">
            app.component("v-cart", {
                template: '#v-cart-template',

                data() {
                    return  {
                        cart: null,
                        allSelected: false,
                        applied: {
                            quantity: {},
                        },
                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                        },
                        isLoading: true,
                        refreshKey: 0,
                    }
                },

                computed: {
                    selectedItemsCount() {
                        return this.cart?.items?.filter(item => item.selected).length ?? 0;
                    },
                },

                mounted() {
                    this.getCart();
                },

                methods: {
                    getCart() {
                        this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                            .then(response => {
                                this.cart = response.data.data;
                                this.isLoading = false;

                                if (response.data.message) {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: response.data.message });
                                }

                                this.refreshKey++;
                                this.updateAllSelected();
                            })
                            .catch(error => {
                                this.isLoading = false;
                            });
                    },

                    selectAll() {
                        for (let item of this.cart.items) {
                            item.selected = this.allSelected;
                        }
                    },

                    updateAllSelected() {
                        this.allSelected = Boolean(this.cart?.items?.length) && this.cart.items.every(item => item.selected);
                    },

                    updateItem(qty, item) {
                        this.isLoading = true;

                        let qtyData = {};
                        qtyData[item.id] = qty;

                        this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty: qtyData })
                            .then(response => {
                                this.cart = response.data.data;
                                this.isLoading = false;
                                this.refreshKey++;
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                this.$emitter.emit('update-mini-cart', response.data.data);
                            })
                            .catch(error => {
                                this.isLoading = false;
                                this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                            });
                    },

                    removeItem(itemId) {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                this.isLoading = true;

                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                                        '_method': 'DELETE',
                                        'cart_item_id': itemId,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;
                                        this.isLoading = false;
                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                        this.$emitter.emit('update-mini-cart', response.data.data);
                                    })
                                    .catch(error => {
                                        this.isLoading = false;
                                        this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                                    });
                            }
                        });
                    },

                    removeSelectedItems() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                this.isLoading = true;

                                const selectedItemsIds = this.cart.items
                                    .filter(item => item.selected)
                                    .map(item => item.id);

                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy_selected') }}', {
                                        '_method': 'DELETE',
                                        'ids': selectedItemsIds,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;
                                        this.isLoading = false;
                                        this.allSelected = false;
                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                        this.$emitter.emit('update-mini-cart', response.data.data);
                                    })
                                    .catch(error => {
                                        this.isLoading = false;
                                        this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                                    });
                            }
                        });
                    },

                    moveToWishlistSelectedItems() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                const selectedItemsIds = this.cart.items
                                    .filter(item => item.selected)
                                    .map(item => item.id);

                                this.$axios.post('{{ route('shop.api.checkout.cart.move_to_wishlist') }}', {
                                        'ids': selectedItemsIds,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;
                                        this.allSelected = false;
                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                        this.$emitter.emit('update-mini-cart', response.data.data);
                                    })
                                    .catch(error => {
                                        this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                                    });
                            },
                        });
                    },

                    setCart(cart) {
                        this.cart = cart;
                        this.refreshKey++;
                    },
                }
            });
        </script>
    @endPushOnce
</x-shop::layouts>
