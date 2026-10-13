<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.profile.edit.edit-profile')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="profile.edit" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <!-- Main Card Container -->
    <div class="flex-1 w-full rounded-3xl border border-soxnsox-border/80 bg-white p-6 sm:p-8 shadow-soxnsox-subtle space-y-6">
        <div class="flex items-center justify-between border-b border-soxnsox-border/60 pb-4">
            <div class="flex items-center gap-3">
                <!-- Back Button -->
                <a
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-soxnsox-border text-soxnsox-charcoal hover:bg-black/5 transition-colors"
                    href="{{ route('shop.customers.account.profile.index') }}"
                >
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>

                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e9f2fa] text-[#2ca7a3] text-[9px] font-semibold tracking-wider uppercase">
                        <i class="fa-solid fa-feather text-[10px]"></i>
                        <span>Settings</span>
                    </div>
                    <h1 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]">
                        @lang('shop::app.customers.account.profile.edit.edit-profile')
                    </h1>
                </div>
            </div>
        </div>
    
        {!! view_render_event('bagisto.shop.customers.account.profile.edit.before', ['customer' => $customer]) !!}

        <!-- Profile Edit Form -->
        <x-shop::form
            :action="route('shop.customers.account.profile.update')"
            enctype="multipart/form-data"
        >
            {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.before', ['customer' => $customer]) !!}
    
            <div class="space-y-4">
                <!-- Image -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.control
                        type="image"
                        class="mb-0 rounded-xl !p-0 text-gray-700"
                        name="image[]"
                        :label="trans('Image')"
                        :is-multiple="false"
                        accepted-types="image/*"
                        :src="$customer->image_url"
                    />

                    <x-shop::form.control-group.error control-name="image[]" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.image.after', ['customer' => $customer]) !!}

                <!-- First & Last Name Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                            @lang('shop::app.customers.account.profile.edit.first-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="first_name"
                            rules="required"
                            class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                            :value="old('first_name') ?? $customer->first_name"
                            :label="trans('shop::app.customers.account.profile.edit.first-name')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.first-name')"
                        />

                        <x-shop::form.control-group.error control-name="first_name" />
                    </x-shop::form.control-group>

                    <!-- Last Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                            @lang('shop::app.customers.account.profile.edit.last-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="last_name"
                            rules="required"
                            class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                            :value="old('last_name') ?? $customer->last_name"
                            :label="trans('shop::app.customers.account.profile.edit.last-name')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.last-name')"
                        />

                        <x-shop::form.control-group.error control-name="last_name" />
                    </x-shop::form.control-group>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.last_name.after') !!}

                <!-- Email & Phone Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Email -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                            @lang('shop::app.customers.account.profile.edit.email')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="email"
                            rules="required|email"
                            class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                            :value="old('email') ?? $customer->email"
                            :label="trans('shop::app.customers.account.profile.edit.email')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.email')"
                        />

                        <x-shop::form.control-group.error control-name="email" />
                    </x-shop::form.control-group>

                    <!-- Phone -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="{{ core()->isPhoneNumberRequired() ? 'required' : '' }} text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                            @lang('shop::app.customers.account.profile.edit.phone')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="phone"
                            rules="{{ core()->isPhoneNumberRequired() ? 'required' : '' }}|phone"
                            class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                            :value="old('phone') ?? $customer->phone"
                            :label="trans('shop::app.customers.account.profile.edit.phone')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.phone')"
                        />

                        <x-shop::form.control-group.error control-name="phone" />
                    </x-shop::form.control-group>
                </div>

                <!-- Gender & DOB Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Gender -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="{{ core()->isGenderRequired() ? 'required' : '' }} text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                            @lang('shop::app.customers.account.profile.edit.gender')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="select"
                            name="gender"
                            class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                            rules="{{ core()->isGenderRequired() ? 'required' : '' }}"
                            :value="old('gender') ?? $customer->gender"
                            :label="trans('shop::app.customers.account.profile.edit.gender')"
                        >
                            <option value="">@lang('shop::app.customers.account.profile.edit.select-gender')</option>
                            <option value="Other">@lang('shop::app.customers.account.profile.edit.other')</option>
                            <option value="Male">@lang('shop::app.customers.account.profile.edit.male')</option>
                            <option value="Female">@lang('shop::app.customers.account.profile.edit.female')</option>
                        </x-shop::form.control-group.control>

                        <x-shop::form.control-group.error control-name="gender" />
                    </x-shop::form.control-group>

                    <!-- DOB -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="{{ core()->isDOBRequired() ? 'required' : '' }} text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                            @lang('shop::app.customers.account.profile.edit.dob')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="date"
                            name="date_of_birth"
                            class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                            rules="{{ core()->isDOBRequired() ? 'required' : '' }}"
                            :value="old('date_of_birth') ?? $customer->date_of_birth"
                            :label="trans('shop::app.customers.account.profile.edit.dob')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.dob')"
                        />

                        <x-shop::form.control-group.error control-name="date_of_birth" />
                    </x-shop::form.control-group>
                </div>

                <!-- Password Change Section Header -->
                <div class="pt-4 border-t border-soxnsox-border/60">
                    <h3 class="font-display text-base font-bold text-[#133b63]">
                        Change Password
                    </h3>
                    <p class="text-xs text-soxnsox-muted">
                        Leave blank if you do not want to change your current password.
                    </p>
                </div>

                <!-- Current & New Password Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Current Password -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                            @lang('shop::app.customers.account.profile.edit.current-password')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="password"
                            name="current_password"
                            class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                            :label="trans('shop::app.customers.account.profile.edit.current-password')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.current-password')"
                        />

                        <x-shop::form.control-group.error control-name="current_password" />
                    </x-shop::form.control-group>

                    <!-- New Password -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                            @lang('shop::app.customers.account.profile.edit.new-password')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="password"
                            name="new_password"
                            rules="min:6"
                            class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                            :label="trans('shop::app.customers.account.profile.edit.new-password')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.new-password')"
                        />

                        <x-shop::form.control-group.error control-name="new_password" />
                    </x-shop::form.control-group>
                </div>

                <!-- Confirm New Password -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                        @lang('shop::app.customers.account.profile.edit.confirm-password')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="password"
                        name="new_password_confirmation"
                        rules="confirmed:@new_password"
                        class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                        :label="trans('shop::app.customers.account.profile.edit.confirm-password')"
                        :placeholder="trans('shop::app.customers.account.profile.edit.confirm-password')"
                    />

                    <x-shop::form.control-group.error control-name="new_password_confirmation" />
                </x-shop::form.control-group>

                <!-- Newsletter Subscription Checkbox -->
                <div class="flex items-center gap-2 pt-1 text-xs text-soxnsox-slate">
                    <input
                        type="checkbox"
                        name="subscribed_to_news_letter"
                        id="is-subscribed"
                        class="h-4 w-4 rounded border-soxnsox-border text-soxnsox-teal focus:ring-soxnsox-teal cursor-pointer"
                        @checked($customer->subscribed_to_news_letter)
                    >
                    <label for="is-subscribed" class="cursor-pointer select-none">
                        @lang('shop::app.customers.account.profile.edit.subscribe-to-newsletter')
                    </label>
                </div>

                <!-- Save Changes Button -->
                <div class="pt-4">
                    <button
                        type="submit"
                        class="soxnsox-btn-primary h-11 px-8 text-xs uppercase tracking-widest font-semibold inline-flex items-center gap-2 shadow-soxnsox-card"
                    >
                        <span>@lang('shop::app.customers.account.profile.edit.save')</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.after', ['customer' => $customer]) !!}

        </x-shop::form>

        {!! view_render_event('bagisto.shop.customers.account.profile.edit.after', ['customer' => $customer]) !!}

    </div>
</x-shop::layouts.account>
