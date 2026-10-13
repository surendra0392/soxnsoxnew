{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.before') !!}

<v-payment-methods
    :methods="paymentMethods"
    @payment-method-selected="setSelectedPaymentMethod"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <x-shop::shimmer.checkout.onepage.payment-method />
</v-payment-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-payment-methods-template"
    >
        <div>
            <template v-if="! methods">
                <!-- Payment Method shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.payment-method />
            </template>
    
            <template v-else>
                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.before') !!}

                <!-- Payment Step Card -->
                <div class="rounded-3xl border border-[#e5e7eb] bg-white p-6 sm:p-8 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-[#e5e7eb]/60 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#1d5b8f] text-white text-xs font-bold font-mono shadow-xs">
                                03
                            </span>
                            <h2 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]">
                                @lang('shop::app.checkout.onepage.payment.payment-method')
                            </h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <div 
                            class="relative cursor-pointer select-none"
                            v-for="(payment, index) in methods"
                        >
                            {!! view_render_event('bagisto.shop.checkout.payment-method.before') !!}

                            <input 
                                type="radio" 
                                name="payment[method]" 
                                :value="payment.payment"
                                :id="payment.method"
                                class="peer hidden"
                                @change="store(payment)"
                            >

                            <label 
                                :for="payment.method" 
                                class="block cursor-pointer rounded-2xl border border-soxnsox-border bg-white p-5 peer-checked:border-soxnsox-teal peer-checked:bg-[#f8fafc] peer-checked:ring-1 peer-checked:ring-soxnsox-teal transition-all hover:border-soxnsox-teal/50"
                            >
                                <div class="flex items-start gap-4">
                                    <div class="shrink-0 w-10 h-10 rounded-xl bg-white border border-soxnsox-border/60 flex items-center justify-center p-1.5" v-if="payment.image">
                                        <img
                                            class="max-h-full max-w-full object-contain"
                                            :src="payment.image"
                                            :alt="payment.method_title"
                                        />
                                    </div>

                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold text-soxnsox-charcoal">
                                            @{{ payment.method_title }}
                                        </p>

                                        <p class="text-xs text-soxnsox-muted leading-relaxed" v-if="payment.description">
                                            @{{ payment.description }}
                                        </p>
                                    </div>
                                </div>
                            </label>

                            {!! view_render_event('bagisto.shop.checkout.payment-method.after') !!}
                        </div>
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.after') !!}
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-payment-methods', {
            template: '#v-payment-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['payment-method-selected', 'processing', 'processed'],

            methods: {
                store(selectedMethod) {
                    this.$emit('payment-method-selected', selectedMethod.method);

                    this.$emit('processing', 'review');

                    this.$axios.post("{{ route('shop.checkout.onepage.payment_methods.store') }}", {
                            payment: selectedMethod
                        })
                        .then(response => {
                            this.$emit('processed', response.data.cart);

                            // Used in mobile view. 
                            if (window.innerWidth <= 768) {
                                window.scrollTo({
                                    top: document.body.scrollHeight,
                                    behavior: 'smooth'
                                });
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'payment');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
