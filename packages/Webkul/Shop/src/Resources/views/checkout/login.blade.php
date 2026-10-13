<!-- Checkout Login Vue JS Component -->
<v-checkout-login>
    <div class="flex items-center">
        <button
            type="button"
            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#e9f2fa] text-xs font-bold uppercase tracking-wider text-[#1d5b8f] hover:bg-[#1d5b8f] hover:text-white transition-all cursor-pointer shadow-xs border border-[#1d5b8f]/10"
        >
            <i class="fa-solid fa-user text-xs"></i>
            <span>@lang('shop::app.checkout.login.title')</span>
        </button>
    </div>
</v-checkout-login>

@pushOnce('scripts')
    {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}

    <script
        type="text/x-template"
        id="v-checkout-login-template"
    >
        <div>
            <div class="flex items-center">
                <button
                    type="button"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#e9f2fa] text-xs font-bold uppercase tracking-wider text-[#1d5b8f] hover:bg-[#1d5b8f] hover:text-white transition-all cursor-pointer shadow-xs border border-[#1d5b8f]/10"
                    @click="$refs.loginModel.open()"
                >
                    <i class="fa-solid fa-user text-xs"></i>
                    <span>@lang('shop::app.checkout.login.title')</span>
                </button>
            </div>

            <!-- Login Form -->
            <x-shop::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                {!! view_render_event('bagisto.shop.checkout.login.before') !!}

                <!-- Login form -->
                <form @submit="handleSubmit($event, login)">
                    {!! view_render_event('bagisto.shop.checkout.login.form_controls.before') !!}

                    <!-- Login modal -->
                    <x-shop::modal
                        ref="loginModel"
                        panel-class="max-w-[480px] !rounded-3xl !shadow-2xl !bg-white !border !border-slate-200 overflow-hidden"
                    >
                        <!-- Modal Header -->
                        <x-slot:header class="!bg-white !border-b !border-slate-200/80 !px-6 sm:!px-8 !py-5 sm:!py-6">
                            <div class="flex flex-col gap-1 text-left">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e9f2fa] w-fit text-[11px] font-bold uppercase tracking-wider text-[#1d5b8f]">
                                    <i class="fa-solid fa-user text-[11px]"></i>
                                    <span>SOX N SOX CUSTOMER</span>
                                </div>

                                <h2 class="font-display text-2xl font-extrabold text-[#133b63] tracking-tight mt-1">
                                    @lang('shop::app.checkout.login.title')
                                </h2>

                                <p class="text-xs text-[#6b7280]">
                                    Sign in for saved addresses, loyalty perks & faster checkout.
                                </p>
                            </div>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content class="!bg-white !px-6 sm:!px-8 !pt-5 !pb-2 space-y-4">
                            <!-- Email -->
                            <x-shop::form.control-group class="!mb-0">
                                <x-shop::form.control-group.label class="required !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                    @lang('shop::app.checkout.login.email')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="email"
                                    name="email"
                                    rules="required|email"
                                    class="!mb-0 w-full !h-12 !px-4 !rounded-xl !border !border-slate-200 !bg-white hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 !text-sm !text-[#133b63] placeholder:!text-[#6b7280] transition-all outline-none"
                                    :label="trans('shop::app.checkout.login.email')"
                                    placeholder="email@example.com"
                                    :aria-label="trans('shop::app.checkout.login.email')"
                                    aria-required="true"
                                    ::rules="rules"
                                />

                                <x-shop::form.control-group.error control-name="email" />
                            </x-shop::form.control-group>

                            <!-- Password -->
                            <x-shop::form.control-group class="!mb-0">
                                <div class="flex items-center justify-between !mb-1.5">
                                    <x-shop::form.control-group.label class="required !mt-0 !mb-0 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                        @lang('shop::app.checkout.login.password')
                                    </x-shop::form.control-group.label>

                                    <a
                                        href="{{ route('shop.customers.forgot_password.create') }}"
                                        target="_blank"
                                        class="text-xs text-[#1d5b8f] font-semibold hover:underline"
                                    >
                                        @lang('shop::app.customers.login-form.forgot-pass')
                                    </a>
                                </div>

                                <div class="relative">
                                    <x-shop::form.control-group.control
                                        ::type="showPassword ? 'text' : 'password'"
                                        name="password"
                                        id="password"
                                        rules="required|min:6"
                                        class="!mb-0 w-full !h-12 !pl-4 !pr-11 !rounded-xl !border !border-slate-200 !bg-white hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 !text-sm !text-[#133b63] placeholder:!text-[#6b7280] transition-all outline-none"
                                        :label="trans('shop::app.checkout.login.password')"
                                        :placeholder="trans('shop::app.checkout.login.password')"
                                        :aria-label="trans('shop::app.checkout.login.password')"
                                        aria-required="true"
                                        ::rules="rules"
                                    />

                                    <button
                                        type="button"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-[#6b7280] hover:text-[#133b63] transition-colors p-1"
                                        @click="showPassword = !showPassword"
                                        tabindex="-1"
                                    >
                                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-[15px]"></i>
                                    </button>
                                </div>

                                <x-shop::form.control-group.error control-name="password" />
                            </x-shop::form.control-group>

                            <!-- Captcha -->
                            @if (core()->getConfigData('customer.captcha.credentials.status'))
                                <x-shop::form.control-group class="mt-4">
                                    {!! \Webkul\Customer\Facades\Captcha::render() !!}

                                    <x-shop::form.control-group.error control-name="recaptcha_token" />
                                </x-shop::form.control-group>
                            @endif
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer class="!mt-0 !bg-white !px-6 sm:!px-8 !pt-3 !pb-6 sm:!pb-8 !border-t-0 space-y-4">
                            <div>
                                <x-shop::button
                                    class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 h-12 w-full !rounded-full text-xs uppercase tracking-widest font-bold shadow-sm flex items-center justify-center gap-2 transition-all"
                                    :title="trans('shop::app.checkout.login.title')"
                                    ::loading="isStoring"
                                    ::disabled="isStoring"
                                />
                            </div>

                            <div class="text-center text-xs text-[#6b7280]">
                                <span>@lang('shop::app.customers.login-form.new-customer')</span>
                                <a
                                    href="{{ route('shop.customers.register.index') }}"
                                    target="_blank"
                                    class="font-bold text-[#1d5b8f] hover:underline ml-1"
                                >
                                    @lang('shop::app.customers.login-form.create-your-account')
                                </a>
                            </div>
                        </x-slot>
                    </x-shop::modal>

                    {!! view_render_event('bagisto.shop.checkout.login.form_controls.after') !!}
                </form>
            </x-shop::form>

            {!! view_render_event('bagisto.shop.checkout.login.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-checkout-login', {
            template: '#v-checkout-login-template',

            data() {
                return {
                    isStoring: false,
                    showPassword: false,
                }
            },

            methods: {
                login(params, {
                    resetForm,
                    setErrors
                }) {
                    this.isStoring = true;

                    const captchaResponse = document.querySelector('[name="recaptcha_token"]')?.value

                    params['recaptcha_token'] = captchaResponse;

                    this.$axios.post("{{ route('shop.api.customers.session.create') }}", params)
                        .then((response) => {
                            this.isStoring = false;

                            window.location.reload();
                        })
                        .catch((error) => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);

                                return;
                            }

                            this.$emitter.emit('add-flash', {
                                type: 'error',
                                message: error.response.data.message
                            });
                        });
                },
            }
        })
    </script>
@endPushOnce
