@props([
    'product' => null,
])

@php
    $productJson = null;
    if ($product instanceof \Webkul\Product\Contracts\Product) {
        $productJson = json_encode(new \Webkul\Shop\Http\Resources\ProductCardResource($product));
    } elseif (is_array($product)) {
        $productJson = json_encode($product);
    }
@endphp

<v-product-card
    {{ $attributes }}
    @if ($productJson)
        :product="{{ $productJson }}"
    @else
        :product="product"
    @endif
>
</v-product-card>

@pushOnce('scripts')
    <style>
        .soxnsox-action-btn {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(226, 232, 240, 0.9) !important;
            color: #133b63 !important;
            box-shadow: 0 4px 12px rgba(19, 59, 99, 0.08) !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .soxnsox-action-btn:hover {
            background: #133b63 !important;
            border-color: #133b63 !important;
            color: #ffffff !important;
            transform: scale(1.12) !important;
            box-shadow: 0 8px 20px rgba(19, 59, 99, 0.25) !important;
        }
        .soxnsox-action-btn:hover svg {
            stroke: #ffffff !important;
        }
        .soxnsox-action-btn:hover i {
            color: #ffffff !important;
        }
        .soxnsox-action-btn:hover span {
            color: #ffffff !important;
        }
    </style>

    <script
        type="text/x-template"
        id="v-product-card-template"
    >
        <!-- Grid Card -->
        <div
            class="group relative flex flex-col justify-between w-full rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 transition-all duration-500 ease-out hover:border-[#2ca7a3] hover:shadow-[0_24px_50px_-12px_rgba(19,59,99,0.18)] hover:-translate-y-2 overflow-hidden"
            v-if="mode != 'list'"
        >
            <!-- Top Subtle Gradient Glow on Hover -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#2ca7a3] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>

            <div>
                <!-- Image Stage with Light Shimmer Sheen on Hover -->
                <div class="relative w-full aspect-square overflow-hidden bg-[#f8fafc] shrink-0 before:absolute before:inset-0 before:-translate-x-full group-hover:before:translate-x-full before:bg-gradient-to-r before:from-transparent before:via-white/30 before:to-transparent before:transition-transform before:duration-1000 before:pointer-events-none before:z-[3]">
                    {!! view_render_event('bagisto.shop.components.products.card.image.before') !!}

                    <!-- Product Image -->
                    <a
                        :href="product.url || ('{{ route('shop.products.view', [':cat', ':slug']) }}'.replace(':cat', product.category_slug || 'socks').replace(':slug', product.url_key))"
                        :aria-label="product.name"
                        class="block w-full h-full"
                    >
                        <x-shop::media.images.lazy
                            class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-108"
                            ::src="product.base_image?.medium_image_url"
                            ::srcset="product.base_image ? `
                                ${product.base_image.small_image_url} 150w,
                                ${product.base_image.medium_image_url} 300w,
                            ` : ''"
                            sizes="(max-width: 768px) 150px, (max-width: 1200px) 300px, 600px"
                            ::key="product.id"
                            ::index="product.id"
                            width="291"
                            height="300"
                            ::alt="product.name"
                        />
                    </a>

                    {!! view_render_event('bagisto.shop.components.products.card.image.after') !!}

                    <!-- Brand Badges (Top-Left) -->
                    <div
                        class="absolute flex flex-col gap-1.5 z-[2] pointer-events-none"
                        style="top: 0.85rem; left: 0.85rem; right: auto;"
                    >
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider text-white shadow-md backdrop-blur-md"
                            style="background: linear-gradient(135deg, #f29a38 0%, #e07a2f 100%); box-shadow: 0 4px 12px rgba(242,154,56,0.35);"
                            v-if="product.on_sale"
                        >
                            <i class="fa-solid fa-fire text-[8px]"></i>
                            Special Offer
                        </span>

                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider text-white shadow-md backdrop-blur-md"
                            style="background: linear-gradient(135deg, #2ca7a3 0%, #1e8380 100%); box-shadow: 0 4px 12px rgba(44,167,163,0.35);"
                            v-else-if="product.is_new"
                        >
                            <i class="fa-solid fa-leaf text-[8px]"></i>
                            100% Bamboo
                        </span>

                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider bg-white/95 text-[#133b63] shadow-sm border border-slate-200/80 backdrop-blur-md"
                            v-else
                        >
                            <span class="w-1.5 h-1.5 rounded-full bg-[#2ca7a3] animate-pulse"></span>
                            Premium
                        </span>
                    </div>

                    <!-- Quick Floating Actions (Top-Right) -->
                    <div
                        class="absolute flex flex-col gap-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 z-[2] max-lg:opacity-100"
                        style="top: 0.85rem; right: 0.85rem; left: auto;"
                    >
                        @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                            <button
                                type="button"
                                class="soxnsox-action-btn flex h-8 w-8 items-center justify-center rounded-full shadow-md"
                                aria-label="@lang('shop::app.components.products.card.add-to-wishlist')"
                                :class="product.is_wishlist ? '!text-rose-500 !bg-rose-50 !border-rose-200' : ''"
                                @click="addToWishlist()"
                            >
                                <i :class="product.is_wishlist ? 'fa-solid fa-heart text-xs text-rose-500' : 'fa-regular fa-heart text-xs'"></i>
                            </button>
                        @endif

                        @if (core()->getConfigData('catalog.products.settings.compare_option'))
                            <button
                                type="button"
                                class="soxnsox-action-btn flex h-8 w-8 items-center justify-center rounded-full shadow-md"
                                aria-label="@lang('shop::app.components.products.card.add-to-compare')"
                                title="@lang('shop::app.components.products.card.add-to-compare')"
                                @click="addToCompare(product.id)"
                            >
                                <i class="fa-solid fa-code-compare text-xs"></i>
                            </button>
                        @endif

                        <button
                            type="button"
                            class="soxnsox-action-btn flex h-8 w-8 items-center justify-center rounded-full shadow-md"
                            aria-label="Quick View"
                            title="Quick View"
                            @click="openQuickView()"
                        >
                            <i class="fa-solid fa-eye text-xs text-[#133b63]"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Information Section -->
                <div class="p-4 sm:p-5 flex flex-col gap-2">
                    {!! view_render_event('bagisto.shop.components.products.card.name.before') !!}

                    <!-- Eyebrow: Category & Micro Rating Badge -->
                    <div class="flex items-center justify-between gap-2 text-[10px]">
                        <span v-if="product.category_name" class="font-extrabold uppercase tracking-[0.14em] text-[#2ca7a3] line-clamp-1">
                            @{{ product.category_name }}
                        </span>
                        <span v-else class="font-extrabold uppercase tracking-[0.14em] text-[#2ca7a3]">
                            Pure Bamboo
                        </span>

                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200/60 text-amber-700 font-bold text-[10px] shrink-0">
                            <i class="fa-solid fa-star text-[9px] text-[#f29a38]"></i><span>4.9</span>
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="font-display text-[15px] sm:text-base font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors leading-snug tracking-tight min-h-[2.5rem] sm:min-h-[2.75rem]">
                        <a :href="product.url || ('{{ route('shop.products.view', [':cat', ':slug']) }}'.replace(':cat', product.category_slug || 'socks').replace(':slug', product.url_key))">
                            @{{ product.name }}
                        </a>
                    </h3>

                    {!! view_render_event('bagisto.shop.components.products.card.name.after') !!}

                    <!-- Feature Micro-Chips -->
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-medium">
                            <i class="fa-solid fa-feather text-[9px] text-[#2ca7a3]"></i> Soft
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-medium">
                            <i class="fa-solid fa-shield-halved text-[9px] text-[#2ca7a3]"></i> Seamless
                        </span>
                    </div>

                    <!-- Pricing Strip -->
                    {!! view_render_event('bagisto.shop.components.products.card.price.before') !!}

                    <div class="flex items-baseline gap-2 pt-0.5">
                        <template v-if="product.special_price">
                            <span class="text-lg font-extrabold text-[#133b63] tracking-tight">
                                @{{ product.special_price }}
                            </span>
                            <span class="text-xs text-slate-400 line-through font-normal">
                                @{{ product.regular_price }}
                            </span>
                            <span
                                v-if="product.discount_percent > 0"
                                class="text-[10px] font-extrabold tracking-wider text-[#2ca7a3] px-2 py-0.5 rounded-full ml-auto bg-[#e6f8f7] border border-[#2ca7a3]/30"
                            >
                                @{{ product.discount_percent }}% OFF
                            </span>
                        </template>
                        <template v-else>
                            <span class="text-lg font-extrabold text-[#133b63] tracking-tight">
                                @{{ product.formatted_price || product.regular_price || product.min_price }}
                            </span>
                        </template>
                    </div>

                    {!! view_render_event('bagisto.shop.components.products.card.price.after') !!}
                </div>
            </div>

            <!-- Action Button -->
            <div class="px-4 pb-4 sm:px-5 sm:pb-5">
                @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.before') !!}

                    <button
                        class="soxnsox-btn-shimmer w-full h-11 text-xs font-bold uppercase tracking-[0.12em] rounded-full flex items-center justify-center gap-2 transition-all duration-300 active:scale-95 disabled:opacity-50 text-white shadow-md hover:shadow-xl hover:brightness-105"
                        style="background: linear-gradient(135deg, #f29a38 0%, #e07a2f 100%); box-shadow: 0 4px 14px rgba(242,154,56,0.3);"
                        :disabled="! product.is_saleable || isAddingToCart"
                        @click="addToCart()"
                    >
                        <i class="fa-solid fa-bag-shopping text-xs transition-transform duration-300 group-hover:scale-110" v-if="! isAddingToCart"></i>
                        <svg v-else class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span v-if="! product.is_saleable">Out of Stock</span>
                        <span v-else-if="product.type === 'configurable'">Select Options</span>
                        <span v-else-if="! isAddingToCart">Add To Bag</span>
                        <span v-else>Adding...</span>
                    </button>

                    {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.after') !!}
                @endif
            </div>
        </div>

        <!-- List Card -->
        <div
            class="group relative flex gap-6 p-4 sm:p-5 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 transition-all duration-500 ease-out hover:border-[#2ca7a3] hover:shadow-[0_20px_45px_-10px_rgba(19,59,99,0.14)] hover:-translate-y-1 max-sm:flex-wrap items-center overflow-hidden"
            v-else
        >
            <!-- Top Subtle Gradient Glow on Hover -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#2ca7a3] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>

            <!-- Image Stage with Light Shimmer Sheen on Hover -->
            <div class="relative w-full max-w-[180px] sm:max-w-[200px] aspect-square overflow-hidden rounded-xl sm:rounded-2xl bg-[#f8fafc] shrink-0 before:absolute before:inset-0 before:-translate-x-full group-hover:before:translate-x-full before:bg-gradient-to-r before:from-transparent before:via-white/30 before:to-transparent before:transition-transform before:duration-1000 before:pointer-events-none before:z-[3]">
                {!! view_render_event('bagisto.shop.components.products.card.image.before') !!}

                <a
                    :href="product.url || ('{{ route('shop.products.view', [':cat', ':slug']) }}'.replace(':cat', product.category_slug || 'socks').replace(':slug', product.url_key))"
                    :aria-label="product.name"
                    class="block w-full h-full"
                >
                    <x-shop::media.images.lazy
                        class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-106"
                        ::src="product.base_image?.medium_image_url"
                        ::key="product.id"
                        ::index="product.id"
                        width="291"
                        height="300"
                        ::alt="product.name"
                    />
                </a>

                {!! view_render_event('bagisto.shop.components.products.card.image.after') !!}

                <div
                    class="absolute flex flex-col gap-1 z-[2]"
                    style="top: 0.75rem; left: 0.75rem; right: auto;"
                >
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider text-white shadow-md backdrop-blur-md"
                        style="background: linear-gradient(135deg, #f29a38 0%, #e07a2f 100%);"
                        v-if="product.on_sale"
                    >
                        <i class="fa-solid fa-fire text-[8px]"></i>
                        Special Offer
                    </span>

                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider text-white shadow-md backdrop-blur-md"
                        style="background: linear-gradient(135deg, #2ca7a3 0%, #1e8380 100%);"
                        v-else-if="product.is_new"
                    >
                        <i class="fa-solid fa-leaf text-[8px]"></i>
                        100% Bamboo
                    </span>
                </div>
            </div>

            <!-- List Details -->
            <div class="flex flex-1 flex-col justify-between h-full space-y-3">
                <div class="space-y-1.5">
                    <!-- Eyebrow: Category & Reviews -->
                    <div class="flex items-center justify-between gap-2 text-[10px]">
                        <span v-if="product.category_name" class="font-extrabold uppercase tracking-[0.14em] text-[#2ca7a3]">
                            @{{ product.category_name }}
                        </span>
                        <span v-else class="font-extrabold uppercase tracking-[0.14em] text-[#2ca7a3]">
                            Pure Bamboo
                        </span>

                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200/60 text-amber-700 font-bold text-[10px] shrink-0">
                            <i class="fa-solid fa-star text-[9px] text-[#f29a38]"></i><span>4.9 (Verified)</span>
                        </span>
                    </div>

                    <h3 class="font-display text-lg sm:text-xl font-bold text-[#133b63] group-hover:text-[#2ca7a3] transition-colors leading-snug">
                        <a :href="product.url || ('{{ route('shop.products.view', [':cat', ':slug']) }}'.replace(':cat', product.category_slug || 'socks').replace(':slug', product.url_key))">
                            @{{ product.name }}
                        </a>
                    </h3>

                    <p v-if="product.short_description" class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                        @{{ product.short_description }}
                    </p>

                    <div class="flex items-center gap-1.5 pt-1">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-medium">
                            <i class="fa-solid fa-feather text-[9px] text-[#2ca7a3]"></i> Soft
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-medium">
                            <i class="fa-solid fa-shield-halved text-[9px] text-[#2ca7a3]"></i> Seamless
                        </span>
                    </div>
                </div>

                <!-- Price and Cart Button Row -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-4">
                    <div class="flex items-baseline gap-2">
                        <template v-if="product.special_price">
                            <span class="text-xl font-extrabold text-[#133b63]">
                                @{{ product.special_price }}
                            </span>
                            <span class="text-xs text-slate-400 line-through font-normal">
                                @{{ product.regular_price }}
                            </span>
                        </template>
                        <template v-else>
                            <span class="text-xl font-extrabold text-[#133b63]">
                                @{{ product.formatted_price || product.regular_price || product.min_price }}
                            </span>
                        </template>
                    </div>

                    <div class="flex items-center gap-2">
                        @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                            <button
                                class="soxnsox-btn-shimmer h-11 px-6 text-xs font-bold uppercase tracking-[0.12em] rounded-full flex items-center gap-2 text-white shadow-md hover:shadow-xl hover:brightness-105 transition-all duration-300 active:scale-95"
                                style="background: linear-gradient(135deg, #f29a38 0%, #e07a2f 100%); box-shadow: 0 4px 14px rgba(242,154,56,0.3);"
                                :disabled="! product.is_saleable || isAddingToCart"
                                @click="addToCart()"
                            >
                                <i class="fa-solid fa-bag-shopping text-xs"></i>
                                <span v-if="! product.is_saleable">Out of Stock</span>
                                <span v-else-if="product.type === 'configurable'">Select Options</span>
                                <span v-else-if="! isAddingToCart">Add To Bag</span>
                                <span v-else>Adding...</span>
                            </button>
                        @endif

                        @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                            <button
                                type="button"
                                class="soxnsox-action-btn flex h-9 w-9 items-center justify-center rounded-full shadow-sm"
                                aria-label="@lang('shop::app.components.products.card.add-to-wishlist')"
                                :class="product.is_wishlist ? '!text-rose-500 !bg-rose-50 !border-rose-200' : ''"
                                @click="addToWishlist()"
                            >
                                <i :class="product.is_wishlist ? 'fa-solid fa-heart text-xs text-rose-500' : 'fa-regular fa-heart text-xs'"></i>
                            </button>
                        @endif

                        @if (core()->getConfigData('catalog.products.settings.compare_option'))
                            <button
                                type="button"
                                class="soxnsox-action-btn flex h-9 w-9 items-center justify-center rounded-full shadow-sm"
                                aria-label="@lang('shop::app.components.products.card.add-to-compare')"
                                title="@lang('shop::app.components.products.card.add-to-compare')"
                                @click="addToCompare(product.id)"
                            >
                                <i class="fa-solid fa-code-compare text-xs"></i>
                            </button>
                        @endif

                        <button
                            type="button"
                            class="soxnsox-action-btn flex h-9 w-9 items-center justify-center rounded-full shadow-sm"
                            aria-label="Quick View"
                            title="Quick View"
                            @click="openQuickView()"
                        >
                            <i class="fa-solid fa-eye text-xs text-[#133b63]"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-product-card', {
            template: '#v-product-card-template',

            props: ['mode', 'product'],

            data() {
                return {
                    isCustomer: '{{ auth()->guard('customer')->check() }}',

                    isAddingToCart: false,
                }
            },

            methods: {
                openQuickView() {
                    this.$emitter.emit('open-quick-view', this.product);
                },

                addToWishlist() {
                    if (this.isCustomer) {
                        this.$axios.post(`{{ route('shop.api.customers.account.wishlist.store') }}`, {
                                product_id: this.product.id
                            })
                            .then(response => {
                                this.product.is_wishlist = ! this.product.is_wishlist;

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                            })
                            .catch(error => {});
                        } else {
                            window.location.href = "{{ route('shop.customer.session.index')}}";
                        }
                },

                addToCompare(productId) {
                    if (this.isCustomer) {
                        this.$axios.post('{{ route("shop.api.compare.store") }}', {
                                'product_id': productId
                            })
                            .then(response => {
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                            })
                            .catch(error => {
                                if ([400, 422].includes(error.response.status)) {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.data.message });

                                    return;
                                }

                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message});
                            });

                        return;
                    }

                    let items = this.getStorageValue() ?? [];

                    if (items.length) {
                        if (! items.includes(productId)) {
                            items.push(productId);

                            localStorage.setItem('compare_items', JSON.stringify(items));

                            this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.components.products.card.add-to-compare-success')" });
                        } else {
                            this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.components.products.card.already-in-compare')" });
                        }
                    } else {
                        localStorage.setItem('compare_items', JSON.stringify([productId]));

                        this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.components.products.card.add-to-compare-success')" });
                    }
                },

                getStorageValue(key) {
                    let value = localStorage.getItem('compare_items');

                    if (! value) {
                        return [];
                    }

                    return JSON.parse(value);
                },

                addToCart() {
                    if (this.product.type === 'configurable') {
                        this.openQuickView();
                        return;
                    }

                    this.isAddingToCart = true;

                    this.$axios.post('{{ route("shop.api.checkout.cart.store") }}', {
                            'quantity': 1,
                            'product_id': this.product.id,
                        })
                        .then(response => {
                            if (response.data.message) {
                                this.$emitter.emit('update-mini-cart', response.data.data );

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                this.$emitter.emit('open-mini-cart');
                            } else {
                                this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                            }

                            this.isAddingToCart = false;
                        })
                        .catch(error => {
                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });

                            if (error.response.data.redirect_uri) {
                                window.location.href = error.response.data.redirect_uri;
                            }

                            this.isAddingToCart = false;
                        });
                },
            },
        });
    </script>
@endpushOnce
