@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-form-template"
    >
        <div class="space-y-4">
            <x-shop::form.control-group class="hidden">
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.id'"
                    ::value="address.id"
                />
            </x-shop::form.control-group>

            <!-- Name (First & Last) -->
            <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">
                <!-- First Name -->
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.label class="required !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                        @lang('shop::app.checkout.onepage.address.first-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.first_name'"
                        ::value="address.first_name"
                        rules="required"
                        class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                        :label="trans('shop::app.checkout.onepage.address.first-name')"
                        :placeholder="trans('shop::app.checkout.onepage.address.first-name')"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.first_name'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.first_name.after') !!}

                <!-- Last Name -->
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.label class="required !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                        @lang('shop::app.checkout.onepage.address.last-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.last_name'"
                        ::value="address.last_name"
                        rules="required"
                        class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                        :label="trans('shop::app.checkout.onepage.address.last-name')"
                        :placeholder="trans('shop::app.checkout.onepage.address.last-name')"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.last_name'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.last_name.after') !!}
            </div>

            <!-- Email & Phone -->
            <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">
                <!-- Email -->
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.label class="required !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                        @lang('shop::app.checkout.onepage.address.email')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="email"
                        ::name="controlName + '.email'"
                        ::value="address.email"
                        rules="required|email"
                        class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                        :label="trans('shop::app.checkout.onepage.address.email')"
                        placeholder="email@example.com"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.email'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.email.after') !!}

                <!-- Phone Number -->
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.label class="required !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                        @lang('shop::app.checkout.onepage.address.telephone')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.phone'"
                        ::value="address.phone"
                        rules="required|phone"
                        class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                        :label="trans('shop::app.checkout.onepage.address.telephone')"
                        placeholder="e.g. 9876543210"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.phone'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.phone.after') !!}
            </div>

            <!-- Street Address -->
            <x-shop::form.control-group class="!mb-0">
                <x-shop::form.control-group.label class="required !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                    @lang('shop::app.checkout.onepage.address.street-address')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.address.[0]'"
                    ::value="address.address[0]"
                    rules="required|address"
                    class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                    :label="trans('shop::app.checkout.onepage.address.street-address')"
                    placeholder="House / Flat No., Street, Landmark"
                />

                <x-shop::form.control-group.error
                    class="mb-2"
                    ::name="controlName + '.address.[0]'"
                />

                @if (core()->getConfigData('customer.address.information.street_lines') > 1)
                    @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                        <x-shop::form.control-group.control
                            type="text"
                            ::name="controlName + '.address.[{{ $i }}]'"
                            rules="address"
                            class="!mt-2 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                            :label="trans('shop::app.checkout.onepage.address.street-address')"
                            placeholder="Apartment, suite, unit, etc. (optional)"
                        />

                        <x-shop::form.control-group.error
                            class="mb-2"
                            ::name="controlName + '.address.[{{ $i }}]'"
                        />
                    @endfor
                @endif
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.address.after') !!}

            <!-- Country & State -->
            <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">
                <!-- Country -->
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.label class="{{ core()->isCountryRequired() ? 'required' : '' }} !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                        @lang('shop::app.checkout.onepage.address.country')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="select"
                        ::name="controlName + '.country'"
                        ::value="address.country"
                        v-model="selectedCountry"
                        rules="{{ core()->isCountryRequired() ? 'required' : '' }}"
                        class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] transition-all outline-none"
                        :label="trans('shop::app.checkout.onepage.address.country')"
                        :placeholder="trans('shop::app.checkout.onepage.address.country')"
                    >
                        <option value="">
                            @lang('shop::app.checkout.onepage.address.select-country')
                        </option>

                        <option
                            v-for="country in countries"
                            :value="country.code"
                        >
                            @{{ country.name }}
                        </option>
                    </x-shop::form.control-group.control>

                    <x-shop::form.control-group.error ::name="controlName + '.country'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.country.after') !!}

                <!-- State -->
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.label class="{{ core()->isStateRequired() ? 'required' : '' }} !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                        @lang('shop::app.checkout.onepage.address.state')
                    </x-shop::form.control-group.label>

                    <template v-if="! selectedCountry">
                        <x-shop::form.control-group.control
                            type="select"
                            ::name="controlName + '.state'"
                            disabled
                            class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-gray-100 opacity-60 cursor-not-allowed !text-sm text-[#9ca3af]"
                            :label="trans('shop::app.checkout.onepage.address.state')"
                        >
                            <option value="">Select country first</option>
                        </x-shop::form.control-group.control>
                    </template>

                    <template v-else-if="states">
                        <template v-if="haveStates">
                            <x-shop::form.control-group.control
                                type="select"
                                ::name="controlName + '.state'"
                                rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                ::value="address.state"
                                class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] transition-all outline-none"
                                :label="trans('shop::app.checkout.onepage.address.state')"
                                :placeholder="trans('shop::app.checkout.onepage.address.state')"
                            >
                                <option value="">
                                    @lang('shop::app.checkout.onepage.address.select-state')
                                </option>

                                <option
                                    v-for='(state, index) in states[selectedCountry]'
                                    :value="state.code"
                                >
                                    @{{ state.default_name }}
                                </option>
                            </x-shop::form.control-group.control>
                        </template>

                        <template v-else>
                            <x-shop::form.control-group.control
                                type="text"
                                ::name="controlName + '.state'"
                                ::value="address.state"
                                rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                                :label="trans('shop::app.checkout.onepage.address.state')"
                                :placeholder="trans('shop::app.checkout.onepage.address.state')"
                            />
                        </template>
                    </template>

                    <x-shop::form.control-group.error ::name="controlName + '.state'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.state.after') !!}
            </div>

            <!-- City & Postcode -->
            <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">
                <!-- City -->
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.label class="required !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                        @lang('shop::app.checkout.onepage.address.city')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.city'"
                        ::value="address.city"
                        rules="required"
                        class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                        :label="trans('shop::app.checkout.onepage.address.city')"
                        placeholder="City / Town"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.city'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.city.after') !!}

                <!-- Postcode -->
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.label class="{{ core()->isPostCodeRequired() ? 'required' : '' }} !mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                        @lang('shop::app.checkout.onepage.address.postcode')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.postcode'"
                        ::value="address.postcode"
                        rules="{{ core()->isPostCodeRequired() ? 'required' : '' }}|postcode"
                        class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                        :label="trans('shop::app.checkout.onepage.address.postcode')"
                        placeholder="e.g. 500072"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.postcode'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.postcode.after') !!}
            </div>

            <!-- Optional Business / Company Details -->
            <div class="pt-2 border-t border-[#e5e7eb]/60">
                <details class="group">
                    <summary class="cursor-pointer text-xs font-semibold uppercase tracking-wider text-[#64748b] hover:text-[#1d5b8f] flex items-center justify-between list-none py-1 transition-colors select-none">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-building text-xs"></i>
                            <span>Add Company & Tax Details (Optional)</span>
                        </span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform group-open:rotate-180"></i>
                    </summary>

                    <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1 pt-3">
                        <!-- Company Name -->
                        <x-shop::form.control-group class="!mb-0">
                            <x-shop::form.control-group.label class="!mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                @lang('shop::app.checkout.onepage.address.company-name')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                ::name="controlName + '.company_name'"
                                ::value="address.company_name"
                                class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                                placeholder="Company Name (Optional)"
                            />
                        </x-shop::form.control-group>

                        <!-- Vat ID -->
                        <template v-if="controlName=='billing'">
                            <x-shop::form.control-group class="!mb-0">
                                <x-shop::form.control-group.label class="!mt-0 !mb-1.5 text-xs font-semibold uppercase tracking-wider text-[#133b63]">
                                    @lang('shop::app.checkout.onepage.address.vat-id')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    ::name="controlName + '.vat_id'"
                                    ::value="address.vat_id"
                                    class="!mb-0 w-full !h-11 sm:!h-12 !px-3.5 sm:!px-4 !rounded-xl !border !border-[#e5e7eb] !bg-[#f8fafc]/60 hover:!border-[#1d5b8f]/40 focus:!border-[#1d5b8f] focus:!ring-2 focus:!ring-[#1d5b8f]/15 focus:!bg-white !text-sm !text-[#133b63] placeholder:!text-[#9ca3af] transition-all outline-none"
                                    placeholder="VAT / GSTIN (Optional)"
                                />

                                <x-shop::form.control-group.error ::name="controlName + '.vat_id'" />
                            </x-shop::form.control-group>
                        </template>
                    </div>
                </details>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-checkout-address-form', {
            template: '#v-checkout-address-form-template',

            props: {
                controlName: {
                    type: String,
                    required: true,
                },

                address: {
                    type: Object,

                    default: () => ({
                        id: 0,
                        company_name: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        address: [],
                        country: '',
                        state: '',
                        city: '',
                        postcode: '',
                        phone: '',
                    }),
                },
            },

            data() {
                return {
                    selectedCountry: this.address?.country || '',

                    countries: [],

                    states: null,
                }
            },

            computed: {
                haveStates() {
                    return !! this.states[this.selectedCountry]?.length;
                },
            },

            watch: {
                address: {
                    handler(newVal) {
                        if (newVal?.country) {
                            this.selectedCountry = newVal.country;
                        }
                    },
                    immediate: true,
                    deep: true,
                },
            },

            mounted() {
                this.getCountries();

                this.getStates();
            },

            methods: {
                getCountries() {
                    this.$axios.get("{{ route('shop.api.core.countries') }}")
                        .then(response => {
                            this.countries = response.data.data;
                        })
                        .catch(() => {});
                },

                getStates() {
                    this.$axios.get("{{ route('shop.api.core.states') }}")
                        .then(response => {
                            this.states = response.data.data;
                        })
                        .catch(() => {});
                },
            }
        });
    </script>
@endPushOnce
