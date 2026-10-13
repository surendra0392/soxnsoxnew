<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="@lang('shop::app.checkout.onepage.index.checkout') | SOXNSOX" />
    <meta name="description" content="Complete your SOXNSOX order with secure 256-bit encrypted checkout." />
    <meta name="robots" content="noindex, nofollow" />
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.onepage.index.checkout') | SOXNSOX
    </x-slot>

    @php
        $channel = core()->getCurrentChannel();
        $logoUrl = ($channel->logo && file_exists(public_path('storage/' . $channel->logo)))
            ? asset('storage/' . $channel->logo)
            : (file_exists(public_path('logo.png'))
                ? asset('logo.png')
                : ($channel->logo_url ?: null));
    @endphp

    <!-- Focused Secure Checkout Top Bar -->
    <header class="border-b border-[#e5e7eb] sticky top-0 z-30 shadow-sm bg-white">
        <div class="site-container h-16 sm:h-20 flex items-center justify-between">
            <!-- Logo -->
            <a
                href="{{ route('shop.home.index') }}"
                class="flex items-center py-2 group"
                aria-label="SOXNSOX - Bamboo Socks"
            >
                @if ($logoUrl)
                    <img
                        src="{{ $logoUrl }}"
                        alt="{{ config('app.name', 'SOXNSOX') }}"
                        class="h-9 sm:h-11 w-auto object-contain max-w-[180px] transition-transform duration-300 group-hover:scale-[1.02]"
                    />
                @else
                    <div class="flex flex-col">
                        <span class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-[#133b63] group-hover:text-[#1d5b8f] transition-colors">
                            SOX<span class="text-[#f29a38]">N</span>SOX
                        </span>
                        <span class="text-[8px] sm:text-[9px] tracking-[0.25em] uppercase text-[#2ca7a3] -mt-0.5 font-sans font-bold">
                            Bamboo Socks
                        </span>
                    </div>
                @endif
            </a>

            <!-- Center Trust Badge (Desktop) -->
            <div class="hidden md:flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#1d5b8f] bg-[#e9f2fa] border border-[#cbe2f5] px-4 py-1.5 rounded-full shadow-xs">
                <i class="fa-solid fa-lock text-xs text-[#1d5b8f]"></i>
                <span>Secure 256-Bit SSL Checkout</span>
            </div>

            <!-- Right: Return to Cart & Auth -->
            <div class="flex items-center gap-3 sm:gap-4">
                <a
                    href="{{ route('shop.checkout.cart.index') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63] hover:text-[#1d5b8f] transition-colors"
                >
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Back to Cart</span>
                </a>

                @guest('customer')
                    <span class="text-slate-300 hidden sm:inline">|</span>
                    <div class="block">
                        @include('shop::checkout.login')
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <div class="bg-[#f5f7fa] min-h-[calc(100vh-80px)]">
        <!-- Breadcrumbs -->
        <div class="site-container pt-4 pb-2 sm:pt-6 sm:pb-3">
            <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[11px] sm:text-xs uppercase tracking-[0.14em] text-soxnsox-muted">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#1d5b8f] transition-colors">Home</a>
                <span class="text-soxnsox-border">/</span>
                <a href="{{ route('shop.checkout.cart.index') }}" class="hover:text-[#1d5b8f] transition-colors">Cart</a>
                <span class="text-soxnsox-border">/</span>
                <span class="text-soxnsox-charcoal font-semibold">Checkout</span>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="site-container pt-4 pb-6 sm:pt-6 sm:pb-8">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#e9f2fa] text-[#1d5b8f] text-[10px] sm:text-xs font-semibold tracking-widest uppercase">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Order Placement</span>
                </div>
                <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#133b63]">
                    Checkout
                </h1>
                <div class="soxnsox-decorative-line"></div>
            </div>
        </div>

        <!-- Checkout Vue Component -->
        <main class="site-container pb-20">
            <v-checkout>
                <!-- Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage />
            </v-checkout>
        </main>
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-checkout-template"
        >
            <template v-if="! cart">
                <!-- Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage />
            </template>

            <template v-else>
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">
                    <!-- Steps Container (Left Column) -->
                    <div
                        class="flex-1 w-full space-y-6"
                        id="steps-container"
                    >
                        <!-- Mobile Order Summary (Collapsible/Preview on Small Screens) -->
                        <div class="block lg:hidden">
                            @include('shop::checkout.onepage.summary')
                        </div>

                        <!-- Step 1: Address -->
                        <template v-if="['address', 'shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.address')
                        </template>

                        <!-- Step 2: Shipping Methods -->
                        <template v-if="cart.have_stockable_items && ['shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.shipping')
                        </template>

                        <!-- Step 3: Payment Methods -->
                        <template v-if="['payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.payment')
                        </template>
                    </div>

                    <!-- Desktop Order Summary (Right Sticky Column) -->
                    <div class="hidden lg:block w-[380px] xl:w-[420px] shrink-0 sticky top-28 space-y-4">
                        @include('shop::checkout.onepage.summary')

                        <!-- Place Order Button -->
                        <div v-if="canPlaceOrder" class="pt-2">
                            <template v-if="(selectedPaymentMethod || cart.payment_method) == 'paypal_smart_button'">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                                <v-paypal-smart-button></v-paypal-smart-button>

                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else>
                                <x-shop::button
                                    type="button"
                                    class="soxnsox-btn-primary h-12 w-full text-xs uppercase tracking-widest font-semibold flex items-center justify-center gap-2 shadow-soxnsox-card"
                                    :title="trans('shop::app.checkout.onepage.summary.place-order')"
                                    ::disabled="isPlacingOrder"
                                    ::loading="isPlacingOrder"
                                    @click="placeOrder"
                                />
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </script>

        <script type="module">
            app.component('v-checkout', {
                template: '#v-checkout-template',

                data() {
                    return {
                        cart: null,

                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },

                        isPlacingOrder: false,
                        currentStep: 'address',
                        shippingMethods: null,
                        paymentMethods: null,
                        selectedPaymentMethod: null,
                        canPlaceOrder: false,
                    }
                },

                mounted() {
                    this.getCart();
                },

                methods: {
                    getCart() {
                        this.$axios.get("{{ route('shop.checkout.onepage.summary') }}")
                            .then(response => {
                                this.cart = response.data.data;
                                this.scrollToCurrentStep();
                            })
                            .catch(error => {});
                    },

                    stepForward(step) {
                        this.currentStep = step;

                        if (step == 'review') {
                            this.canPlaceOrder = true;
                            return;
                        }

                        this.canPlaceOrder = false;

                        if (this.currentStep == 'shipping') {
                            this.shippingMethods = null;
                        } else if (this.currentStep == 'payment') {
                            this.paymentMethods = null;
                        }
                    },

                    stepProcessed(data) {
                        if (this.currentStep == 'shipping') {
                            this.shippingMethods = data;
                        } else if (this.currentStep == 'payment') {
                            this.paymentMethods = data;
                        }

                        this.getCart();
                    },

                    scrollToCurrentStep() {
                        let container = document.getElementById('steps-container');

                        if (! container) {
                            return;
                        }

                        container.scrollIntoView({
                            behavior: 'smooth',
                            block: 'end'
                        });
                    },

                    setSelectedPaymentMethod(method) {
                        this.selectedPaymentMethod = method;
                    },

                    placeOrder() {
                        if ((this.selectedPaymentMethod || this.cart.payment_method) == 'paypal_smart_button') {
                            return;
                        }

                        this.isPlacingOrder = true;

                        this.$axios.post('{{ route('shop.checkout.onepage.orders.store') }}')
                            .then(response => {
                                if (response.data.data.redirect) {
                                    window.location.href = response.data.data.redirect_url;
                                } else {
                                    window.location.href = '{{ route('shop.checkout.onepage.success') }}';
                                }

                                this.isPlacingOrder = false;
                            })
                            .catch(error => {
                                this.isPlacingOrder = false;
                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                    }
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
