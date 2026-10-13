<!-- Mini Cart Vue Component -->
<v-mini-cart>
    <button
        type="button"
        class="soxnsox-header-action-btn flex h-9 w-9 sm:h-9 sm:w-9 items-center justify-center rounded-full text-[#133b63] hover:bg-[#e9f2fa] hover:text-[#1d5b8f] transition-colors relative cursor-pointer focus:outline-none"
        aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
    >
        <span class="relative inline-flex items-center justify-center">
            <i class="fa-solid fa-bag-shopping text-lg" role="presentation"></i>
        </span>
    </button>
</v-mini-cart>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-mini-cart-template"
    >
        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.before') !!}

        @if (core()->getConfigData('sales.checkout.mini_cart.display_mini_cart'))
            <x-shop::drawer ref="miniCartDrawer">
                <!-- Drawer Toggler -->
                <x-slot:toggle>
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.before') !!}

                    <button
                        type="button"
                        class="soxnsox-header-action-btn flex h-9 w-9 sm:h-9 sm:w-9 items-center justify-center rounded-full text-[#133b63] hover:bg-[#e9f2fa] hover:text-[#1d5b8f] transition-colors relative cursor-pointer focus:outline-none"
                        aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
                        @click="getCart"
                    >
                        <span class="relative inline-flex items-center justify-center">
                            <i class="fa-solid fa-bag-shopping text-lg" role="presentation"></i>

                            @if (core()->getConfigData('sales.checkout.my_cart.summary') == 'display_item_quantity')
                                <span
                                    class="absolute flex items-center justify-center rounded-full bg-[#f29a38] text-white text-[10px] font-bold leading-none pointer-events-none"
                                    style="top: -6px; right: -8px; min-width: 17px; height: 17px; padding: 0 4px;"
                                    v-if="cart?.items_qty && cart.items_qty > 0"
                                >
                                    @{{ cart.items_qty }}
                                </span>
                            @else
                                <span
                                    class="absolute flex items-center justify-center rounded-full bg-[#f29a38] text-white text-[10px] font-bold leading-none pointer-events-none"
                                    style="top: -6px; right: -8px; min-width: 17px; height: 17px; padding: 0 4px;"
                                    v-if="cart?.items_count && cart.items_count > 0"
                                >
                                    @{{ cart.items_count }}
                                </span>
                            @endif
                        </span>
                    </button>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.after') !!}
                </x-slot>

                <!-- Drawer Header -->
                <x-slot:header>
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.header.before') !!}

                    <div class="space-y-1">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e9f2fa] text-[#1d5b8f] text-[10px] font-semibold tracking-widest uppercase">
                            <i class="fa-solid fa-bag-shopping text-xs"></i>
                            <span>SOXNSOX Cart</span>
                        </div>
                        <h2 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]">
                            @lang('shop::app.checkout.cart.mini-cart.shopping-cart')
                            <span class="text-sm font-sans font-normal text-soxnsox-muted" v-if="cart?.items_count">
                                (@{{ cart.items_count }} @{{ cart.items_count === 1 ? 'item' : 'items' }})
                            </span>
                        </h2>

                        @if ($offerInfo = core()->getConfigData('sales.checkout.mini_cart.offer_info'))
                            <div class="mt-2.5 p-2.5 rounded-xl bg-[#f8fafc] border border-soxnsox-border text-xs text-[#1d5b8f] font-medium">
                                {!! $offerInfo !!}
                            </div>
                        @endif

                        <!-- Dynamic Complimentary Shipping Progress Bar -->
                        <div class="pt-2" v-if="cart?.items?.length">
                            <!-- Unlocked -->
                            <div class="p-2.5 rounded-xl bg-[#e6f8f7] border border-[#b6e6e3] flex items-center justify-between text-[11px] font-bold text-[#208a86]" v-if="parseFloat(cart.sub_total || 0) >= 499">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-truck-fast text-xs"></i>
                                    <i class="fa-solid fa-gift text-xs"></i>
                                    Complimentary Shipping Unlocked!
                                </span>
                                <span class="text-[10px] uppercase tracking-wider bg-[#2ca7a3] text-white px-2 py-0.5 rounded-full">FREE</span>
                            </div>

                            <!-- In Progress -->
                            <div class="p-3 rounded-xl bg-white border border-[#e5e7eb] space-y-2 text-[11px] shadow-sm" v-else>
                                <div class="flex items-center justify-between text-[#133b63] font-medium">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-truck-fast text-[#1d5b8f] text-xs"></i>
                                        <span>Add <strong class="text-[#1d5b8f] font-bold">₹@{{ (499 - parseFloat(cart.sub_total || 0)).toFixed(0) }}</strong> for <strong>Free Shipping</strong></span>
                                    </span>
                                    <span class="text-[10px] font-bold text-[#1d5b8f] px-2 py-0.5 rounded-full bg-[#e9f2fa]">@{{ Math.round((parseFloat(cart.sub_total || 0) / 499) * 100) }}%</span>
                                </div>
                                <div class="w-full bg-[#e5e7eb] h-1.5 rounded-full overflow-hidden">
                                    <div style="background: linear-gradient(90deg, #1d5b8f 0%, #2ca7a3 100%); height: 100%; border-radius: 9999px; transition: width 0.5s ease-out;" :style="'width: ' + Math.min(100, Math.round((parseFloat(cart.sub_total || 0) / 499) * 100)) + '%'"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.header.after') !!}
                </x-slot>

                <!-- Drawer Content -->
                <x-slot:content>
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.before') !!}

                    <!-- Cart Item Listing -->
                    <div
                        class="p-4 sm:p-5 space-y-3.5"
                        v-if="cart?.items?.length"
                    >
                        <div
                            class="p-3.5 sm:p-4 rounded-2xl bg-white border border-[#e5e7eb] shadow-sm flex gap-3.5 sm:gap-4 items-start transition-all hover:border-[#1d5b8f]/30"
                            v-for="item in cart?.items"
                        >
                            <!-- Cart Item Image -->
                            {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.image.before') !!}

                            <a
                                :href="'{{ route('shop.products.view', ['category' => 'socks', 'slug' => ':slug']) }}'.replace(':slug', item.product_url_key)"
                                class="shrink-0 w-20 h-20 sm:w-22 sm:h-22 rounded-xl bg-[#f8fafc] border border-[#e5e7eb] overflow-hidden flex items-center justify-center p-1"
                            >
                                <img
                                    :src="item.base_image.small_image_url"
                                    class="w-full h-full object-cover rounded-lg"
                                    :alt="item.name"
                                />
                            </a>

                            {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.image.after') !!}

                            <!-- Cart Item Information -->
                            <div class="flex-1 min-w-0 flex flex-col justify-between self-stretch">
                                <div class="space-y-1">
                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.name.before') !!}

                                    <a
                                        :href="'{{ route('shop.products.view', ['category' => 'socks', 'slug' => ':slug']) }}'.replace(':slug', item.product_url_key)"
                                        class="font-display text-sm sm:text-[15px] font-bold text-[#133b63] hover:text-[#1d5b8f] transition-colors line-clamp-2 leading-snug"
                                    >
                                        @{{ item.name }}
                                    </a>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.name.after') !!}

                                    <!-- Price Display (Sale vs Regular Price) -->
                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.price.before') !!}

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

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.price.after') !!}

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
                                </div>

                                <!-- Quantity Controls & Line Actions -->
                                <div class="pt-3 flex items-center justify-between gap-3 border-t border-[#e5e7eb]/70 mt-2.5">
                                    <x-shop::quantity-changer
                                        v-if="item.can_change_qty"
                                        ::key="'qty-' + item.id + '-' + refreshKey"
                                        class="h-8 max-w-[96px] px-2 py-0.5 rounded-lg text-xs bg-[#f8fafc] border-[#e5e7eb]"
                                        name="quantity"
                                        ::value="item?.quantity"
                                        @change="updateItem($event, item)"
                                    />

                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold text-[#133b63]">
                                            @{{ item.formatted_total }}
                                        </span>

                                        <button
                                            type="button"
                                            class="text-[#9ca3af] hover:text-red-600 transition-colors p-1"
                                            title="@lang('shop::app.checkout.cart.mini-cart.remove')"
                                            @click="removeItem(item.id)"
                                        >
                                            <i class="fa-regular fa-trash-can text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty Cart Section -->
                    <div
                        class="py-20 text-center space-y-4 px-6"
                        v-else
                    >
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#f8fafc] border border-[#e5e7eb] text-3xl text-[#1d5b8f]">
                            <i class="fa-solid fa-bag-shopping text-2xl text-[#1d5b8f]"></i>
                        </div>

                        <div class="space-y-1.5">
                            <h3 class="font-display text-xl font-extrabold text-[#133b63]">
                                @lang('shop::app.checkout.cart.mini-cart.empty-cart')
                            </h3>
                            <p class="text-xs text-soxnsox-muted leading-relaxed max-w-xs mx-auto">
                                Explore bamboo and doctor-approved diabetic socks crafted for 24h comfort.
                            </p>
                        </div>

                        <div class="pt-3">
                            <a
                                href="{{ route('shop.search.index') }}"
                                class="soxnsox-btn-primary soxnsox-btn-shimmer inline-flex items-center gap-2 text-[11px] uppercase tracking-widest font-semibold px-6 py-3 shadow-soxnsox-card active:scale-95 transition-all duration-300"
                            >
                                <span>Explore Bamboo Socks</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.after') !!}
                </x-slot>

                <!-- Drawer Footer -->
                <x-slot:footer>
                    <div
                        v-if="cart?.items?.length"
                        class="p-4 sm:p-6 bg-white border-t border-soxnsox-border/70 space-y-4"
                    >
                        <!-- Subtotal & Discount Breakdown -->
                        <div class="space-y-2" v-if="! isLoading">
                            {!! view_render_event('bagisto.shop.checkout.mini-cart.subtotal.before') !!}

                            <!-- MRP / Regular Subtotal Row (When discount exists) -->
                            <div class="flex items-center justify-between text-xs text-[#64748b]" v-if="cart.has_discount">
                                <span>Original Subtotal (MRP)</span>
                                <span class="line-through font-medium">@{{ cart.formatted_regular_sub_total }}</span>
                            </div>

                            <!-- Discount Savings Row -->
                            <div class="flex items-center justify-between text-xs font-semibold text-[#208a86]" v-if="cart.has_discount">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-tag text-xs"></i>
                                    Discount Savings
                                </span>
                                <span>- @{{ cart.formatted_total_discount }}</span>
                            </div>

                            <!-- Subtotal Row -->
                            <div class="flex items-center justify-between pt-1 border-t border-[#e5e7eb]/60">
                                <div class="space-y-0.5">
                                    <span class="text-xs font-bold uppercase tracking-wider text-soxnsox-charcoal block">
                                        @lang('shop::app.checkout.cart.mini-cart.subtotal')
                                    </span>
                                    <span class="text-[11px] text-soxnsox-muted block">
                                        Taxes & shipping calculated at checkout
                                    </span>
                                </div>

                                <div class="text-right">
                                    <span class="font-display text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                                        <template v-if="displayTax.subtotal == 'including_tax'">
                                            @{{ cart.formatted_sub_total_incl_tax }}
                                        </template>
                                        <template v-else>
                                            @{{ cart.formatted_sub_total }}
                                        </template>
                                    </span>
                                </div>
                            </div>

                            <!-- Savings Callout Banner -->
                            <div class="mt-2 p-2.5 rounded-xl bg-[#e6f8f7] border border-[#b6e6e3] flex items-center justify-between text-xs font-semibold text-[#208a86]" v-if="cart.has_discount">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-tag text-[#208a86]"></i> Total Savings on this Order:</span>
                                <span>@{{ cart.formatted_total_discount }}</span>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.mini-cart.subtotal.after') !!}
                        </div>

                        <!-- Loading State Spinner -->
                        <div class="flex justify-center py-4" v-else>
                            <i class="fa-solid fa-spinner fa-spin text-2xl text-[#1d5b8f]"></i>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2.5 pt-1">
                            {!! view_render_event('bagisto.shop.checkout.mini-cart.continue_to_checkout.before') !!}

                            <a
                                href="{{ route('shop.checkout.onepage.index') }}"
                                class="soxnsox-btn-primary soxnsox-btn-shimmer h-12 w-full text-xs uppercase tracking-widest font-semibold flex items-center justify-center gap-2 shadow-soxnsox-card active:scale-95 transition-all duration-300"
                            >
                                <span>@lang('shop::app.checkout.cart.mini-cart.continue-to-checkout')</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>

                            {!! view_render_event('bagisto.shop.checkout.mini-cart.continue_to_checkout.after') !!}

                            <a
                                href="{{ route('shop.checkout.cart.index') }}"
                                class="soxnsox-btn-outline soxnsox-btn-shimmer h-11 w-full text-xs uppercase tracking-widest font-semibold flex items-center justify-center gap-2 active:scale-95 transition-all duration-300"
                            >
                                <span>@lang('shop::app.checkout.cart.mini-cart.view-cart')</span>
                            </a>
                        </div>
                    </div>
                </x-slot>
            </x-shop::drawer>

        @else
            <a href="{{ route('shop.checkout.onepage.index') }}">
                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.before') !!}

                <span class="relative">
                    <i
                        class="fa-solid fa-bag-shopping cursor-pointer text-xl sm:text-2xl text-soxnsox-charcoal hover:text-[#1d5b8f] transition-colors"
                        role="button"
                        aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
                        tabindex="0"
                    ></i>

                    <span
                        class="absolute -top-2 -right-2.5 flex h-4 min-w-4 px-1 items-center justify-center rounded-full bg-[#f29a38] text-white text-[10px] font-bold"
                        v-if="cart?.items_count"
                    >
                        @{{ cart.items_count }}
                    </span>
                </span>

                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.after') !!}
            </a>
        @endif

        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.after') !!}
    </script>

    <script type="module">
        app.component("v-mini-cart", {
            template: '#v-mini-cart-template',

            data() {
                return  {
                    cart: null,
                    displayTax: {
                        prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                        subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                    },
                    isLoading: false,
                    refreshKey: 0,
                }
            },

            mounted() {
                this.getCart();

                /**
                 * To Do: Need to handle this with event emitter.
                 */
                this.$emitter.on('update-mini-cart', (cart) => {
                    this.cart = cart;
                    this.refreshKey++;
                });

                this.$emitter.on('open-mini-cart', () => {
                    if (this.$refs.miniCartDrawer) {
                        this.$refs.miniCartDrawer.open();
                    }
                });
            },

            methods: {
                getCart() {
                    this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                        .then(response =>  {
                            this.cart = response.data.data;
                            this.refreshKey++;
                        })
                        .catch(error => {});
                },

                updateItem(qty, item) {
                    this.isLoading = true;

                    let qtyData = {};
                    qtyData[item.id] = qty;

                    this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty: qtyData })
                        .then(response => {
                            this.cart = response.data.data;
                            this.isLoading = false;
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch(error => {
                            this.isLoading = false;
                            this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                        });
                },

                removeItem(itemId) {
                    this.isLoading = true;

                    this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                            '_method': 'DELETE',
                            'cart_item_id': itemId,
                        })
                        .then(response => {
                            this.cart = response.data.data;
                            this.isLoading = false;
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch(error => {
                            this.isLoading = false;
                            this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                        });
                },
            }
        });
    </script>
@endpushOnce
