<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="@lang('shop::app.customers.forgot-password.title') | SOXNSOX" />
    <meta name="description" content="Reset your SOXNSOX account password securely to regain access to your orders and account settings." />
@endPush

<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.forgot-password.title') | SOXNSOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-[calc(100vh-80px)]">
        <main class="site-container py-12 sm:py-16">
            <!-- Form Container Card -->
            <div class="max-w-md mx-auto rounded-3xl border border-soxnsox-border/80 bg-white p-8 sm:p-10 shadow-soxnsox-subtle space-y-6">
                <!-- Header -->
                <div class="space-y-2 text-center">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#e9f2fa] text-[#1d5b8f] text-[10px] sm:text-xs font-semibold tracking-widest uppercase">
                        <i class="fa-solid fa-key text-xs"></i>
                        <span>Account Recovery</span>
                    </div>

                    <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-[#133b63]">
                        @lang('shop::app.customers.forgot-password.title')
                    </h1>

                    <div class="soxnsox-decorative-line-center"></div>

                    <p class="text-xs sm:text-sm text-soxnsox-muted leading-relaxed">
                        @lang('shop::app.customers.forgot-password.forgot-password-text')
                    </p>
                </div>

                {!! view_render_event('bagisto.shop.customers.forget_password.before') !!}

                <!-- Forgot Password Form -->
                <x-shop::form :action="route('shop.customers.forgot_password.store')">
                    {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.before') !!}

                    <div class="space-y-4">
                        <!-- Email -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                @lang('shop::app.customers.login-form.email')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="email"
                                class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                name="email"
                                rules="required|email"
                                value=""
                                :label="trans('shop::app.customers.login-form.email')"
                                placeholder="email@example.com"
                                :aria-label="trans('shop::app.customers.login-form.email')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="email" />
                        </x-shop::form.control-group>

                        <!-- Captcha if configured -->
                        @if (core()->getConfigData('customer.captcha.credentials.status'))
                            <x-shop::form.control-group class="mt-4">
                                {!! \Webkul\Customer\Facades\Captcha::render() !!}
                                <x-shop::form.control-group.error control-name="recaptcha_token" />
                            </x-shop::form.control-group>
                        @endif

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button
                                class="soxnsox-btn-primary soxnsox-btn-shimmer h-12 w-full text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 shadow-soxnsox-card active:scale-95 transition-all duration-300"
                                type="submit"
                            >
                                <span>@lang('shop::app.customers.forgot-password.submit')</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.email.after') !!}
                </x-shop::form>

                {!! view_render_event('bagisto.shop.customers.forget_password.after') !!}

                <!-- Back to Sign In Link -->
                <div class="pt-4 border-t border-soxnsox-border/60 text-center text-xs text-soxnsox-muted">
                    <a
                        href="{{ route('shop.customer.session.index') }}"
                        class="text-[#1d5b8f] hover:text-[#133b63] font-semibold transition-colors inline-flex items-center gap-1.5"
                    >
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>@lang('shop::app.customers.forgot-password.back')</span>
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-shop::layouts>
