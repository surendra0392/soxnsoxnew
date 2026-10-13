<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="@lang('shop::app.customers.signup-form.page-title') | SOXNSOX" />
    <meta name="description" content="Create your SOX N SOX customer account to manage orders, saved addresses, and enjoy faster footwear checkout." />
@endPush

<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.signup-form.page-title') | SOXNSOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-[calc(100vh-80px)]">
        <main class="site-container py-12 sm:py-16">
            <!-- Form Container Card -->
            <div class="max-w-lg mx-auto rounded-3xl border border-slate-200 bg-white p-8 sm:p-10 shadow-sm space-y-6">
                <!-- Header -->
                <div class="space-y-2 text-center">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#e9f2fa] text-[#1d5b8f] text-[10px] sm:text-xs font-semibold tracking-widest uppercase">
                        <i class="fa-solid fa-user-plus text-xs"></i>
                        <span>Join SOX N SOX</span>
                    </div>

                    <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-[#133b63]">
                        @lang('shop::app.customers.signup-form.page-title')
                    </h1>

                    <div class="soxnsox-decorative-line-center mt-2.5"></div>

                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed pt-1">
                        @lang('shop::app.customers.signup-form.form-signup-text')
                    </p>
                </div>

                {!! view_render_event('bagisto.shop.customers.signup.before') !!}

                <!-- Registration Form -->
                <x-shop::form :action="route('shop.customers.register.store')">
                    {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

                    <div class="space-y-4">
                        <!-- First & Last Name Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- First Name -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                    @lang('shop::app.customers.signup-form.first-name')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                    name="first_name"
                                    rules="required"
                                    :value="old('first_name')"
                                    :label="trans('shop::app.customers.signup-form.first-name')"
                                    :placeholder="trans('shop::app.customers.signup-form.first-name')"
                                    :aria-label="trans('shop::app.customers.signup-form.first-name')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="first_name" />
                            </x-shop::form.control-group>

                            <!-- Last Name -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                    @lang('shop::app.customers.signup-form.last-name')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                    name="last_name"
                                    rules="required"
                                    :value="old('last_name')"
                                    :label="trans('shop::app.customers.signup-form.last-name')"
                                    :placeholder="trans('shop::app.customers.signup-form.last-name')"
                                    :aria-label="trans('shop::app.customers.signup-form.last-name')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="last_name" />
                            </x-shop::form.control-group>
                        </div>

                        <!-- Email -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                @lang('shop::app.customers.signup-form.email')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="email"
                                class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                name="email"
                                rules="required|email"
                                :value="old('email')"
                                :label="trans('shop::app.customers.signup-form.email')"
                                placeholder="email@example.com"
                                :aria-label="trans('shop::app.customers.signup-form.email')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="email" />
                        </x-shop::form.control-group>

                        <!-- Password -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                @lang('shop::app.customers.signup-form.password')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="password"
                                class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                id="password"
                                name="password"
                                rules="required|min:6"
                                :value="old('password')"
                                :label="trans('shop::app.customers.signup-form.password')"
                                :placeholder="trans('shop::app.customers.signup-form.password')"
                                :aria-label="trans('shop::app.customers.signup-form.password')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="password" />
                        </x-shop::form.control-group>

                        <!-- Confirm Password -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                @lang('shop::app.customers.signup-form.confirm-pass')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="password"
                                class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-[#133b63] focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                id="password_confirmation"
                                name="password_confirmation"
                                rules="confirmed:@password"
                                :value="old('password_confirmation')"
                                :label="trans('shop::app.customers.signup-form.confirm-pass')"
                                :placeholder="trans('shop::app.customers.signup-form.confirm-pass')"
                                :aria-label="trans('shop::app.customers.signup-form.confirm-pass')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="password_confirmation" />
                        </x-shop::form.control-group>

                        <!-- Subscribe to Newsletter -->
                        @if (core()->getConfigData('customer.settings.create_new_account_options.news_letter'))
                            <div class="flex items-center gap-2 pt-1 text-xs text-[#6b7280]">
                                <input
                                    type="checkbox"
                                    name="is_subscribed"
                                    id="is-subscribed"
                                    class="h-4 w-4 rounded border-slate-200 text-[#1d5b8f] focus:ring-[#1d5b8f] cursor-pointer"
                                >
                                <label for="is-subscribed" class="cursor-pointer select-none">
                                    @lang('shop::app.customers.signup-form.subscribe-to-newsletter')
                                </label>
                            </div>
                        @endif

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
                                class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 h-12 w-full text-xs uppercase tracking-widest font-semibold flex items-center justify-center gap-2 shadow-sm transition-all"
                                type="submit"
                            >
                                <span>@lang('shop::app.customers.signup-form.button-title')</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.signup_form_controls.after') !!}
                </x-shop::form>

                {!! view_render_event('bagisto.shop.customers.signup.after') !!}

                <!-- Sign In Link -->
                <div class="pt-4 border-t border-slate-200 text-center text-xs text-[#6b7280]">
                    <span>@lang('shop::app.customers.signup-form.account-exists')</span>
                    <a
                        href="{{ route('shop.customer.session.index') }}"
                        class="ml-1 text-[#1d5b8f] hover:text-[#133b63] font-semibold transition-colors"
                    >
                        @lang('shop::app.customers.signup-form.sign-in-button')
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-shop::layouts>
