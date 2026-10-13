<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="@lang('shop::app.customers.reset-password.title') | SOXNSOX" />
    <meta name="description" content="Set a new password for your SOXNSOX account to continue shopping premium bamboo socks." />
@endPush

<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.reset-password.title') | SOXNSOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-[calc(100vh-80px)]">
        <main class="site-container py-12 sm:py-16">
            <!-- Form Container Card -->
            <div class="max-w-md mx-auto rounded-3xl border border-soxnsox-border/80 bg-white p-8 sm:p-10 shadow-soxnsox-subtle space-y-6">
                <!-- Header -->
                <div class="space-y-2 text-center">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#e9f2fa] text-[#1d5b8f] text-[10px] sm:text-xs font-semibold tracking-widest uppercase">
                        <i class="fa-solid fa-lock text-xs"></i>
                        <span>New Password</span>
                    </div>

                    <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-[#133b63]">
                        @lang('shop::app.customers.reset-password.title')
                    </h1>

                    <div class="soxnsox-decorative-line-center"></div>
                </div>

                {!! view_render_event('bagisto.shop.customers.reset_password.before') !!}

                <!-- Reset Password Form -->
                <x-shop::form :action="route('shop.customers.reset_password.store')">
                    <x-shop::form.control-group.control
                        type="hidden"
                        name="token"
                        :value="$token"
                    />

                    {!! view_render_event('bagisto.shop.customers.reset_password_form_controls.before') !!}

                    <div class="space-y-4">
                        <!-- Email -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                @lang('shop::app.customers.reset-password.email')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="email"
                                class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                id="email"
                                name="email"
                                rules="required|email"
                                :value="old('email')"
                                :label="trans('shop::app.customers.reset-password.email')"
                                placeholder="email@example.com"
                                :aria-label="trans('shop::app.customers.reset-password.email')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="email" />
                        </x-shop::form.control-group>

                        <!-- Password -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                @lang('shop::app.customers.reset-password.password')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="password"
                                class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                name="password"
                                rules="required|min:6"
                                value=""
                                :label="trans('shop::app.customers.reset-password.password')"
                                :placeholder="trans('shop::app.customers.reset-password.password')"
                                ref="password"
                                :aria-label="trans('shop::app.customers.reset-password.password')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="password" />
                        </x-shop::form.control-group>

                        <!-- Confirm Password -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                @lang('shop::app.customers.reset-password.confirm-password')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="password"
                                class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-[#1d5b8f] focus:ring-[#1d5b8f]"
                                name="password_confirmation"
                                rules="confirmed:@password"
                                value=""
                                :label="trans('shop::app.customers.reset-password.confirm-password')"
                                :placeholder="trans('shop::app.customers.reset-password.confirm-password')"
                                :aria-label="trans('shop::app.customers.reset-password.confirm-password')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="password_confirmation" />
                        </x-shop::form.control-group>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button
                                class="soxnsox-btn-primary soxnsox-btn-shimmer h-12 w-full text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 shadow-soxnsox-card active:scale-95 transition-all duration-300"
                                type="submit"
                            >
                                <span>@lang('shop::app.customers.reset-password.submit-btn-title')</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.reset_password_form_controls.after') !!}
                </x-shop::form>

                {!! view_render_event('bagisto.shop.customers.reset_password.after') !!}
            </div>
        </main>
    </div>
</x-shop::layouts>
