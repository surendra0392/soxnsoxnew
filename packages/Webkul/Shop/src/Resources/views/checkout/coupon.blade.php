<!-- Coupon Vue Component -->
<v-coupon 
    :cart="cart"
    @coupon-applied="getCart"
    @coupon-removed="getCart"
>
</v-coupon>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-coupon-template"
    >
        <div class="flex justify-between text-right">
            <p class="text-base max-md:font-normal max-sm:text-sm">
                @{{ cart.coupon_code ? "@lang('shop::app.checkout.coupon.applied')" : "@lang('shop::app.checkout.coupon.discount')" }}
            </p>

            {!! view_render_event('bagisto.shop.checkout.cart.coupon.before') !!}

            <p class="text-base font-medium max-sm:text-sm">
                <!-- Apply Coupon Form -->
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <!-- Apply coupon form -->
                    <form @submit="handleSubmit($event, applyCoupon)">
                        {!! view_render_event('bagisto.shop.checkout.cart.coupon.coupon_form_controls.before') !!}

                        <!-- Apply coupon modal -->
                        <x-shop::modal ref="couponModel">
                            <!-- Modal Toggler -->
                            <x-slot:toggle>
                                <span 
                                    class="cursor-pointer text-xs font-semibold uppercase tracking-wider text-[#1d5b8f] hover:text-[#133b63] transition-colors underline underline-offset-4"
                                    role="button"
                                    tabindex="0"
                                    v-if="! cart.coupon_code"
                                >
                                    @lang('shop::app.checkout.coupon.apply')
                                </span>
                            </x-slot>

                            <!-- Modal Header -->
                            <x-slot:header class="max-md:p-5">
                                <h2 class="font-display text-2xl font-extrabold text-[#133b63] max-md:text-base">
                                    @lang('shop::app.checkout.coupon.apply')
                                </h2>
                            </x-slot>

                            <!-- Modal Content -->
                            <x-slot:content class="!px-4">
                                <x-shop::form.control-group class="!mb-0">
                                    <x-shop::form.control-group.control
                                        type="text"
                                        class="w-full h-11 px-4 text-sm text-[#133b63] placeholder:text-[#6b7280]/70 bg-[#f5f7fa] border border-slate-200 rounded-xl focus:bg-white focus:border-[#1d5b8f] focus:ring-1 focus:ring-[#1d5b8f] transition-all outline-none"
                                        name="code"
                                        rules="required"
                                        :placeholder="trans('shop::app.checkout.coupon.enter-your-code')"
                                    />

                                    <x-shop::form.control-group.error
                                        class="flex"
                                        control-name="code"
                                    />
                                </x-shop::form.control-group>
                            </x-slot>

                            <!-- Modal Footer -->
                            <x-slot:footer>
                                <!-- Coupon Form Action Container -->
                                <div class="flex flex-wrap items-center gap-4 max-md:justify-between">
                                    <div class="flex items-center gap-4 max-md:block">
                                        <p class="text-sm font-medium text-zinc-500 max-md:text-left max-md:text-xs">
                                            @lang('shop::app.checkout.coupon.subtotal')
                                        </p>

                                        <p class="font-display text-3xl font-extrabold text-[#133b63] max-md:text-lg">
                                            @{{ cart.formatted_sub_total }}
                                        </p>
                                    </div>

                                    <x-shop::button
                                        class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 h-12 flex-auto text-xs uppercase tracking-widest font-semibold flex items-center justify-center shadow-soxnsox-card px-8 rounded-full transition-all"
                                        :title="trans('shop::app.checkout.coupon.button-title')"
                                        ::loading="isStoring"
                                        ::disabled="isStoring"
                                    />
                                </div>
                            </x-slot>
                        </x-shop::modal>

                        {!! view_render_event('bagisto.shop.checkout.cart.coupon.coupon_form_controls.after') !!}
                    </form>
                </x-shop::form>

                <!-- Applied Coupon Information Container -->
                <span
                    class="inline-flex items-center gap-2"
                    v-if="cart.coupon_code"
                >
                    <span
                        class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-0.5 text-sm font-semibold text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 max-sm:text-xs"
                        :title="'@lang('shop::app.checkout.coupon.applied')'"
                    >
                        @{{ cart.coupon_code }}
                    </span>

                    <button
                        type="button"
                        class="cursor-pointer text-sm text-gray-400 transition-colors hover:text-red-500 p-0.5"
                        title="@lang('shop::app.checkout.coupon.remove')"
                        @click="destroyCoupon"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </span>
            </p>

            {!! view_render_event('bagisto.shop.checkout.cart.coupon.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-coupon', {
            template: '#v-coupon-template',
            
            props: ['cart'],

            data() {
                return {
                    isStoring: false,
                }
            },

            methods: {
                applyCoupon(params, { resetForm }) {
                    this.isStoring = true;

                    this.$axios.post("{{ route('shop.api.checkout.cart.coupon.apply') }}", params)
                        .then((response) => {
                            this.isStoring = false;

                            this.$emit('coupon-applied');
                  
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            this.$refs.couponModel.toggle();

                            resetForm();
                        })
                        .catch((error) => {
                            this.isStoring = false;

                            this.$refs.couponModel.toggle();

                            if ([400, 422].includes(error.response.request.status)) {
                                this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });

                                resetForm();

                                return;
                            }

                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                        });
                },

                destroyCoupon() {
                    this.$axios.delete("{{ route('shop.api.checkout.cart.coupon.remove') }}", {
                            '_token': "{{ csrf_token() }}"
                        })
                        .then((response) => {
                            this.$emit('coupon-removed');

                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch(error => console.log(error));
                },
            }
        })
    </script>
@endPushOnce