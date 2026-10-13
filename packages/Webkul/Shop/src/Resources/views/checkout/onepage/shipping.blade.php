{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.before') !!}

<v-shipping-methods
    :methods="shippingMethods"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Shipping Method Shimmer Effect -->
    <x-shop::shimmer.checkout.onepage.shipping-method />
</v-shipping-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-shipping-methods-template"
    >
        <div>
            <template v-if="! methods">
                <!-- Shipping Method Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.shipping-method />
            </template>

            <template v-else>
                <!-- Shipping Step Card -->
                <div class="rounded-3xl border border-[#e5e7eb] bg-white p-6 sm:p-8 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-[#e5e7eb]/60 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#1d5b8f] text-white text-xs font-bold font-mono shadow-xs">
                                02
                            </span>
                            <h2 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]">
                                @lang('shop::app.checkout.onepage.shipping.shipping-method')
                            </h2>
                        </div>
                    </div>

                    <div class="space-y-3 pt-1">
                        <template v-for="method in methods">
                            {!! view_render_event('bagisto.shop.checkout.onepage.shipping_method.before') !!}

                            <div
                                class="relative select-none"
                                v-for="rate in method.rates"
                            >
                                <input 
                                    type="radio"
                                    name="shipping_method"
                                    :id="rate.method"
                                    :value="rate.method"
                                    class="peer hidden"
                                    :checked="selectedMethod === rate.method"
                                    @change="store(rate.method)"
                                >

                                <label 
                                    class="flex items-center justify-between gap-4 cursor-pointer rounded-2xl border-2 border-soxnsox-border bg-white p-5 peer-checked:border-soxnsox-teal peer-checked:bg-[#f8fafc] peer-checked:ring-1 peer-checked:ring-soxnsox-teal transition-all hover:border-soxnsox-teal/50"
                                    :for="rate.method"
                                >
                                    <div class="flex items-center gap-3.5">
                                        <div 
                                            class="h-5 w-5 rounded-full border-2 border-soxnsox-border flex items-center justify-center transition-colors"
                                            :class="{'!border-soxnsox-teal !bg-soxnsox-teal text-white': selectedMethod === rate.method}"
                                        >
                                            <i v-if="selectedMethod === rate.method" class="fa-solid fa-check text-[10px] text-white"></i>
                                        </div>

                                        <div class="space-y-0.5">
                                            <p class="text-sm font-bold text-soxnsox-charcoal">
                                                @{{ rate.method_title }}
                                            </p>
                                            
                                            <p class="text-xs text-soxnsox-muted leading-relaxed" v-if="rate.method_description">
                                                @{{ rate.method_description }}
                                            </p>
                                            <p class="text-xs text-[#1d5b8f] font-medium" v-else>
                                                Calculated automatically for your delivery address
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-right shrink-0">
                                        <span class="font-display text-base font-extrabold text-[#133b63]" v-if="parseFloat(rate.price || rate.base_price || 0) > 0">
                                            @{{ rate.base_formatted_price }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#e9f2fa] text-xs font-bold text-[#1d5b8f] uppercase tracking-wider" v-else>
                                            FREE
                                        </span>
                                    </div>
                                </label>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.onepage.shipping_method.after') !!}
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-shipping-methods', {
            template: '#v-shipping-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['processing', 'processed'],

            data() {
                return {
                    selectedMethod: null,
                };
            },

            mounted() {
                this.autoSelectRate();
            },

            watch: {
                methods: {
                    handler() {
                        this.autoSelectRate();
                    },
                    deep: true,
                }
            },

            methods: {
                autoSelectRate() {
                    if (! this.methods) return;

                    let allRates = [];
                    for (let key in this.methods) {
                        if (this.methods[key]?.rates) {
                            allRates.push(...this.methods[key].rates);
                        }
                    }

                    if (allRates.length >= 1) {
                        let freeRate = allRates.find(r => parseFloat(r.price || r.base_price || 0) === 0);
                        let targetRate = freeRate || allRates[0];

                        this.selectedMethod = targetRate.method;
                        this.store(targetRate.method);
                    }
                },

                store(selectedMethod) {
                    this.selectedMethod = selectedMethod;
                    this.$emit('processing', 'payment');

                    this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {    
                            shipping_method: selectedMethod,
                        })
                        .then(response => {
                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            } else {
                                this.$emit('processed', response.data.payment_methods);
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'shipping');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
