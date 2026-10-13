<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.profile.index.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="profile" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <!-- Main Content Card -->
    <div class="flex-1 w-full rounded-3xl border border-soxnsox-border/80 bg-white p-6 sm:p-8 shadow-soxnsox-subtle space-y-6">
        <div class="flex items-center justify-between border-b border-soxnsox-border/60 pb-4">
            <div class="flex items-center gap-3">
                <!-- Back Button For Mobile View -->
                <a
                    class="md:hidden flex h-8 w-8 items-center justify-center rounded-lg border border-soxnsox-border text-soxnsox-charcoal"
                    href="{{ route('shop.customers.account.index') }}"
                >
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>

                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e9f2fa] text-[#2ca7a3] text-[9px] font-semibold tracking-wider uppercase">
                        <i class="fa-solid fa-feather text-[10px]"></i>
                        <span>Settings</span>
                    </div>
                    <h1 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]">
                        @lang('shop::app.customers.account.profile.index.title')
                    </h1>
                </div>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.edit_button.before') !!}

            <a
                href="{{ route('shop.customers.account.profile.edit') }}"
                class="soxnsox-btn-outline soxnsox-btn-shimmer h-9 px-5 text-xs uppercase tracking-widest font-bold rounded-full inline-flex items-center gap-1.5 active:scale-95 transition-all duration-300"
            >
                <i class="fa-solid fa-pen-to-square text-xs"></i>
                <span>@lang('shop::app.customers.account.profile.index.edit')</span>
            </a>

            {!! view_render_event('bagisto.shop.customers.account.profile.edit_button.after') !!}
        </div>

        <!-- Profile Information Table -->
        <div class="divide-y divide-soxnsox-border/60 text-xs sm:text-sm">
            {!! view_render_event('bagisto.shop.customers.account.profile.first_name.before') !!}

            <div class="py-3.5 flex justify-between items-center">
                <span class="text-soxnsox-muted">@lang('shop::app.customers.account.profile.index.first-name')</span>
                <span class="font-semibold text-soxnsox-charcoal" v-pre>{{ $customer->first_name }}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.first_name.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.last_name.before') !!}

            <div class="py-3.5 flex justify-between items-center">
                <span class="text-soxnsox-muted">@lang('shop::app.customers.account.profile.index.last-name')</span>
                <span class="font-semibold text-soxnsox-charcoal" v-pre>{{ $customer->last_name }}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.last_name.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.gender.before') !!}

            <div class="py-3.5 flex justify-between items-center">
                <span class="text-soxnsox-muted">@lang('shop::app.customers.account.profile.index.gender')</span>
                <span class="font-semibold text-soxnsox-charcoal" v-pre>{{ $customer->gender ?? '-'}}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.gender.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.date_of_birth.before') !!}

            <div class="py-3.5 flex justify-between items-center">
                <span class="text-soxnsox-muted">@lang('shop::app.customers.account.profile.index.dob')</span>
                <span class="font-semibold text-soxnsox-charcoal" v-pre>{{ $customer->date_of_birth ?? '-' }}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.date_of_birth.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.email.before') !!}

            <div class="py-3.5 flex justify-between items-center">
                <span class="text-soxnsox-muted">@lang('shop::app.customers.account.profile.index.email')</span>
                <span class="font-semibold text-soxnsox-charcoal" v-pre>{{ $customer->email }}</span>
            </div>
            
            {!! view_render_event('bagisto.shop.customers.account.profile.email.after') !!}
        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.delete.before') !!}

        <!-- Profile Delete Modal Action -->
        <div class="pt-6 border-t border-soxnsox-border/60">
            <x-shop::form action="{{ route('shop.customers.account.profile.destroy') }}">
                <x-shop::modal>
                    <x-slot:toggle>
                        <button
                            type="button"
                            class="text-xs uppercase tracking-wider font-semibold text-red-600 hover:text-red-700 transition-colors"
                        >
                            @lang('shop::app.customers.account.profile.index.delete-profile')
                        </button>
                    </x-slot>

                    <x-slot:header>
                        <h2 class="font-display text-xl font-extrabold text-[#133b63]">
                            @lang('shop::app.customers.account.profile.index.enter-password')
                        </h2>
                    </x-slot>

                    <x-slot:content>
                        <div class="py-2">
                            <x-shop::form.control-group class="!mb-0">
                                <x-shop::form.control-group.control
                                    type="password"
                                    name="password"
                                    class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal w-full"
                                    rules="required"
                                    placeholder="Enter your password"
                                />

                                <x-shop::form.control-group.error
                                    class="text-left"
                                    control-name="password"
                                />
                            </x-shop::form.control-group>
                        </div>
                    </x-slot>

                    <!-- Modal Footer -->
                    <x-slot:footer>
                        <button
                            type="submit"
                            class="soxnsox-btn-primary h-10 px-6 text-xs uppercase tracking-widest font-semibold"
                        >
                            @lang('shop::app.customers.account.profile.index.delete')
                        </button>
                    </x-slot>
                </x-shop::modal>
            </x-shop::form>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.delete.after') !!}
    </div>
</x-shop::layouts.account>
