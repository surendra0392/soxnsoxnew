<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.create.add-address')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="addresses.create" />
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
                    href="{{ route('shop.customers.account.addresses.index') }}"
                >
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>

                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e9f2fa] text-[#2ca7a3] text-[9px] font-semibold tracking-wider uppercase">
                        <i class="fa-solid fa-feather text-[10px]"></i>
                        <span>Address Book</span>
                    </div>
                    <h1 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]">
                        @lang('shop::app.customers.account.addresses.create.add-address')
                    </h1>
                </div>
            </div>
        </div>

        <v-create-customer-address>
            <!--Address Shimmer-->
            <x-shop::shimmer.form.control-group :count="6" />
        </v-create-customer-address>

    </div>

    @push('scripts')
        <script
            type="text/x-template"
            id="v-create-customer-address-template"
        >
            <div>
                <x-shop::form :action="route('shop.customers.account.addresses.store')">
                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.before') !!}

                    <div class="space-y-4">
                        <!-- Company Name -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                @lang('shop::app.customers.account.addresses.create.company-name')
                            </x-shop::form.control-group.label>
                
                            <x-shop::form.control-group.control
                                type="text"
                                name="company_name"
                                :value="old('company_name')"
                                class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                :label="trans('shop::app.customers.account.addresses.create.company-name')"
                                :placeholder="trans('shop::app.customers.account.addresses.create.company-name')"
                            />
                
                            <x-shop::form.control-group.error control-name="company_name" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.company_name.after') !!}

                        <!-- First & Last Name Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- First Name -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                    @lang('shop::app.customers.account.addresses.create.first-name')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    name="first_name"
                                    rules="required"
                                    :value="old('first_name')"
                                    class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                    :label="trans('shop::app.customers.account.addresses.create.first-name')"
                                    :placeholder="trans('shop::app.customers.account.addresses.create.first-name')"
                                />

                                <x-shop::form.control-group.error control-name="first_name" />
                            </x-shop::form.control-group>

                            <!-- Last Name -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                    @lang('shop::app.customers.account.addresses.create.last-name')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    name="last_name"
                                    rules="required"
                                    :value="old('last_name')"
                                    class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                    :label="trans('shop::app.customers.account.addresses.create.last-name')"
                                    :placeholder="trans('shop::app.customers.account.addresses.create.last-name')"
                                />

                                <x-shop::form.control-group.error control-name="last_name" />
                            </x-shop::form.control-group>
                        </div>

                        <!-- Street Address -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                @lang('shop::app.customers.account.addresses.create.street-address')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="address[]"
                                rules="required|address"
                                :value="old('address[0]')"
                                class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                :label="trans('shop::app.customers.account.addresses.create.street-address')"
                                :placeholder="trans('shop::app.customers.account.addresses.create.street-address')"
                            />

                            <x-shop::form.control-group.error control-name="address[]" />
                        </x-shop::form.control-group>

                        @if (
                            core()->getConfigData('customer.address.information.street_lines')
                            && core()->getConfigData('customer.address.information.street_lines') > 1
                        )
                            @for ($i = 2; $i <= core()->getConfigData('customer.address.information.street_lines'); $i++)
                                <x-shop::form.control-group.control
                                    type="text"
                                    name="address[{{ $i }}]"
                                    class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                    :value="old('address[' . $i . ']')"
                                    :label="trans('shop::app.customers.account.addresses.create.street-address')"
                                    :placeholder="trans('shop::app.customers.account.addresses.create.street-address')"
                                />
                            @endfor
                        @endif

                        <!-- Country & State Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Country -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                    @lang('shop::app.customers.account.addresses.create.country')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="select"
                                    name="country"
                                    rules="required"
                                    class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                    v-model="country"
                                    :label="trans('shop::app.customers.account.addresses.create.country')"
                                    :placeholder="trans('shop::app.customers.account.addresses.create.country')"
                                >
                                    <option value="">@lang('shop::app.customers.account.addresses.create.select-country')</option>
                                    @foreach (core()->countries() as $country)
                                        <option value="{{ $country->code }}">{{ $country->name }}</option>
                                    @endforeach
                                </x-shop::form.control-group.control>

                                <x-shop::form.control-group.error control-name="country" />
                            </x-shop::form.control-group>

                            <!-- State -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                    @lang('shop::app.customers.account.addresses.create.state')
                                </x-shop::form.control-group.label>

                                <template v-if="haveStates()">
                                    <x-shop::form.control-group.control
                                        type="select"
                                        name="state"
                                        rules="required"
                                        class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                        v-model="state"
                                        :label="trans('shop::app.customers.account.addresses.create.state')"
                                        :placeholder="trans('shop::app.customers.account.addresses.create.state')"
                                    >
                                        <option value="">@lang('shop::app.customers.account.addresses.create.select-state')</option>
                                        <option 
                                            v-for='(state, index) in countryStates[country]'
                                            :value="state.code"
                                            v-text="state.default_name"
                                        >
                                        </option>
                                    </x-shop::form.control-group.control>
                                </template>

                                <template v-else>
                                    <x-shop::form.control-group.control
                                        type="text"
                                        name="state"
                                        rules="required"
                                        class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                        :value="old('state')"
                                        :label="trans('shop::app.customers.account.addresses.create.state')"
                                        :placeholder="trans('shop::app.customers.account.addresses.create.state')"
                                    />
                                </template>

                                <x-shop::form.control-group.error control-name="state" />
                            </x-shop::form.control-group>
                        </div>

                        <!-- City & Postcode Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- City -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                    @lang('shop::app.customers.account.addresses.create.city')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    name="city"
                                    rules="required"
                                    class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                    :value="old('city')"
                                    :label="trans('shop::app.customers.account.addresses.create.city')"
                                    :placeholder="trans('shop::app.customers.account.addresses.create.city')"
                                />

                                <x-shop::form.control-group.error control-name="city" />
                            </x-shop::form.control-group>

                            <!-- Postcode -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="{{ core()->isPostCodeRequired() ? 'required' : '' }} text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                    @lang('shop::app.customers.account.addresses.create.post-code')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    name="postcode"
                                    rules="{{ core()->isPostCodeRequired() ? 'required' : '' }}|postcode"
                                    class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                    :value="old('postcode')"
                                    :label="trans('shop::app.customers.account.addresses.create.post-code')"
                                    :placeholder="trans('shop::app.customers.account.addresses.create.post-code')"
                                />

                                <x-shop::form.control-group.error control-name="postcode" />
                            </x-shop::form.control-group>
                        </div>

                        <!-- Phone -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required text-xs font-semibold uppercase tracking-wider text-soxnsox-charcoal">
                                @lang('shop::app.customers.account.addresses.create.phone')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="phone"
                                rules="required|phone"
                                class="rounded-xl border border-soxnsox-border bg-white px-4 py-3 text-sm text-soxnsox-charcoal focus:border-soxnsox-teal focus:ring-soxnsox-teal"
                                :value="old('phone')"
                                :label="trans('shop::app.customers.account.addresses.create.phone')"
                                :placeholder="trans('shop::app.customers.account.addresses.create.phone')"
                            />

                            <x-shop::form.control-group.error control-name="phone" />
                        </x-shop::form.control-group>

                        <!-- Set As Default -->
                        <div class="flex items-center gap-2 pt-1 text-xs text-soxnsox-slate">
                            <input
                                type="checkbox"
                                name="default_address"
                                value="1"
                                id="default_address"
                                class="h-4 w-4 rounded border-soxnsox-border text-soxnsox-teal focus:ring-soxnsox-teal cursor-pointer"
                            >
                            <label for="default_address" class="cursor-pointer select-none">
                                @lang('shop::app.customers.account.addresses.create.set-as-default')
                            </label>
                        </div>

                        <!-- Save Button -->
                        <div class="pt-4">
                            <button
                                type="submit"
                                class="soxnsox-btn-primary h-11 px-8 text-xs uppercase tracking-widest font-semibold inline-flex items-center gap-2 shadow-soxnsox-card"
                            >
                                <span>@lang('shop::app.customers.account.addresses.create.save')</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.after') !!}
                </x-shop::form>
                {!! view_render_event('bagisto.shop.customers.account.address.create.after') !!}
            </div>
        </script>
    
        <script type="module">
            app.component('v-create-customer-address', {
                template: '#v-create-customer-address-template',
    
                data() {
                    return {
                        country: "{{ old('country') }}",

                        state: "{{ old('state') }}",

                        countryStates: @json(core()->groupedStatesByCountries()),
                    }
                },
    
                methods: {
                    haveStates() {
                        return !!this.countryStates[this.country]?.length;
                    },
                }
            });
        </script>
    @endpush

</x-shop::layouts.account>
