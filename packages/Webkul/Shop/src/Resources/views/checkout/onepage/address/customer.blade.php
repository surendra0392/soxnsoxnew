{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.before') !!}

<!-- Customer Address Vue Component -->
<v-checkout-address-customer
    :cart="cart"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Billing Address Shimmer -->
    <x-shop::shimmer.checkout.onepage.address />
</v-checkout-address-customer>

{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-customer-template"
    >
        <template v-if="isLoading">
            <!-- Billing Address Shimmer -->
            <x-shop::shimmer.checkout.onepage.address />
        </template>

        <template v-else>
            <!-- Saved Addresses -->
            <template v-if="! activeAddressForm && customerSavedAddresses.billing.length">
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form @submit="handleSubmit($event, addAddressToCart)">
                        <!-- Billing Address Header -->
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="font-display text-lg sm:text-xl font-extrabold text-[#133b63] pb-2 border-b border-[#e5e7eb]/60 mb-3 w-full">
                                @lang('shop::app.checkout.onepage.address.billing-address')
                            </h3>
                        </div>

                        <!-- Saved Customer Addresses Cards -->
                        <div class="mb-2 grid grid-cols-2 gap-4 max-1060:grid-cols-[1fr] max-lg:grid-cols-2 max-md:mt-2 max-md:grid-cols-1">
                            <div
                                class="relative max-w-[414px] cursor-pointer select-none rounded-2xl border border-[#e5e7eb] bg-[#f8fafc]/60 hover:border-[#1d5b8f]/40 p-0 transition-all"
                                v-for="address in customerSavedAddresses.billing"
                            >
                                <!-- Actions -->
                                <div class="absolute top-4 flex gap-2 ltr:right-4 rtl:left-4">
                                    <x-shop::form.control-group class="!mb-0 flex items-center gap-2.5">
                                        <x-shop::form.control-group.control
                                            type="radio"
                                            name="billing.id"
                                            ::id="`billing_address_id_${address.id}`"
                                            ::for="`billing_address_id_${address.id}`"
                                            ::value="address.id"
                                            v-model="selectedAddresses.billing_address_id"
                                            rules="required"
                                            label="{{ trans('shop::app.checkout.onepage.address.billing-address') }}"
                                        />
                                    </x-shop::form.control-group>

                                    <!-- Edit Icon -->
                                    <i
                                        class="fa-solid fa-pen-to-square cursor-pointer text-base text-[#64748b] hover:text-[#1d5b8f] transition-colors"
                                        @click="
                                            selectedAddressForEdit = address;
                                            activeAddressForm = 'billing';
                                            saveAddress = address.address_type == 'customer'
                                        "
                                    ></i>
                                </div>

                                <!-- Details -->
                                <label
                                    class="block cursor-pointer rounded-2xl p-5"
                                    :for="`billing_address_id_${address.id}`"
                                >
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fa-solid fa-location-dot text-sm text-[#1d5b8f]"></i>
                                        <p class="text-sm font-bold text-[#133b63]">
                                            @{{ address.first_name + ' ' + address.last_name }}

                                            <template v-if="address.company_name">
                                                (@{{ address.company_name }})
                                            </template>
                                        </p>
                                    </div>

                                    <p class="text-xs text-[#64748b] leading-relaxed pl-7">
                                        <template v-if="address.address">
                                            @{{ address.address.join(', ') }},
                                        </template>

                                        @{{ address.city }},
                                        @{{ address.state }}, @{{ address.country }},
                                        @{{ address.postcode }}
                                    </p>
                                </label>
                            </div>

                            <!-- New Address Card -->
                            <div
                                class="flex max-w-[414px] cursor-pointer items-center justify-center rounded-2xl border-2 border-dashed border-[#e5e7eb] hover:border-[#1d5b8f] p-5 bg-white/50 transition-all min-h-[110px]"
                                @click="activeAddressForm = 'billing'"
                                v-if="! cart.billing_address"
                            >
                                <div
                                    class="flex items-center gap-x-2 text-[#1d5b8f] font-semibold text-xs uppercase tracking-wider"
                                    role="button"
                                    tabindex="0"
                                >
                                    <i class="fa-solid fa-plus text-xs"></i>
                                    <p>@lang('shop::app.checkout.onepage.address.add-new-address')</p>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message Block -->
                        <x-shop::form.control-group.error name="billing.id" />

                        <!-- Shipping Address Block if have stockable items -->
                        <template v-if="cart.have_stockable_items">
                            <!-- Use for Shipping Checkbox -->
                            <div class="mt-4 p-3.5 rounded-xl bg-[#f8fafc] border border-[#e5e7eb] flex items-center gap-3 select-none transition-all hover:border-[#1d5b8f]/40">
                                <input
                                    type="checkbox"
                                    name="billing.use_for_shipping"
                                    id="use_for_shipping_cust"
                                    value="1"
                                    @change="useBillingAddressForShipping = ! useBillingAddressForShipping"
                                    :checked="!! useBillingAddressForShipping"
                                    class="h-4 w-4 rounded border-[#e5e7eb] text-[#1d5b8f] focus:ring-[#1d5b8f] cursor-pointer"
                                />

                                <label
                                    class="cursor-pointer select-none text-xs sm:text-sm font-semibold text-[#133b63]"
                                    for="use_for_shipping_cust"
                                >
                                    @lang('shop::app.checkout.onepage.address.same-as-billing')
                                </label>
                            </div>


                            <!-- Customer Shipping Address -->
                            <div
                                class="mt-8"
                                v-if="! useBillingAddressForShipping"
                            >
                                <!-- Shipping Address Header -->
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="font-display text-lg sm:text-xl font-extrabold text-[#133b63] pb-2 border-b border-[#e5e7eb]/60 mb-3 w-full">
                                        @lang('shop::app.checkout.onepage.address.shipping-address')
                                    </h3>
                                </div>

                                <!-- Saved Customer Addresses Cards -->
                                <div class="mb-2 grid grid-cols-2 gap-4 max-1060:grid-cols-[1fr] max-lg:grid-cols-2 max-md:mt-4 max-md:grid-cols-1">
                                    <div
                                        class="relative max-w-[414px] cursor-pointer select-none rounded-2xl border border-[#e5e7eb] bg-[#f8fafc]/60 hover:border-[#1d5b8f]/40 p-0 transition-all"
                                        v-for="address in customerSavedAddresses.shipping"
                                    >
                                        <!-- Actions -->
                                        <div class="absolute top-4 flex gap-2 ltr:right-4 rtl:left-4">
                                            <x-shop::form.control-group class="!mb-0 flex items-center gap-2.5">
                                                <x-shop::form.control-group.control
                                                    type="radio"
                                                    name="shipping.id"
                                                    ::id="`shipping_address_id_${address.id}`"
                                                    ::for="`shipping_address_id_${address.id}`"
                                                    ::value="address.id"
                                                    v-model="selectedAddresses.shipping_address_id"
                                                    rules="required"
                                                    label="{{ trans('shop::app.checkout.onepage.address.shipping-address') }}"
                                                />
                                            </x-shop::form.control-group>

                                            <!-- Edit Icon -->
                                            <i
                                                class="fa-solid fa-pen-to-square cursor-pointer text-base text-[#64748b] hover:text-[#1d5b8f] transition-colors"
                                                @click="
                                                    selectedAddressForEdit = address;
                                                    activeAddressForm = 'shipping';
                                                    saveAddress = address.address_type == 'customer'
                                                "
                                            ></i>
                                        </div>

                                        <!-- Details -->
                                        <label
                                            class="block cursor-pointer rounded-2xl p-5"
                                            :for="`shipping_address_id_${address.id}`"
                                        >
                                            <div class="flex items-center gap-2 mb-2">
                                                <i class="fa-solid fa-location-dot text-sm text-[#1d5b8f]"></i>
                                                <p class="text-sm font-bold text-[#133b63]">
                                                    @{{ address.first_name + ' ' + address.last_name }}

                                                    <template v-if="address.company_name">
                                                        (@{{ address.company_name }})
                                                    </template>
                                                </p>
                                            </div>

                                            <p class="text-xs text-[#64748b] leading-relaxed pl-7">
                                                <template v-if="address.address">
                                                    @{{ address.address.join(', ') }},
                                                </template>

                                                @{{ address.city }},
                                                @{{ address.state }}, @{{ address.country }},
                                                @{{ address.postcode }}
                                            </p>
                                        </label>
                                    </div>

                                    <!-- New Address Card -->
                                    <div
                                        class="flex max-w-[414px] cursor-pointer items-center justify-center rounded-2xl border-2 border-dashed border-[#e5e7eb] hover:border-[#1d5b8f] p-5 bg-white/50 transition-all min-h-[110px]"
                                        @click="selectedAddressForEdit = null; activeAddressForm = 'shipping'"
                                        v-if="! cart.shipping_address"
                                    >
                                        <div
                                            class="flex items-center gap-x-2 text-[#1d5b8f] font-semibold text-xs uppercase tracking-wider"
                                            role="button"
                                            tabindex="0"
                                        >
                                            <i class="fa-solid fa-plus text-xs"></i>
                                            <p>@lang('shop::app.checkout.onepage.address.add-new-address')</p>
                                        </div>
                                    </div>
                                </div>

                                <x-shop::form.control-group.error name="shipping.id" />
                            </div>
                        </template>

                        <!-- Proceed Button -->
                        <div class="mt-6 flex justify-end">
                            <x-shop::button
                                class="soxnsox-btn-primary h-12 px-10 text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 max-md:w-full shadow-soxnsox-card rounded-full"
                                :title="trans('shop::app.checkout.onepage.address.proceed')"
                                ::loading="isStoring"
                                ::disabled="isStoring"
                            />
                        </div>
                    </form>
                </x-shop::form>
            </template>

            <!-- Create/Edit Address Form -->
            <template v-else>
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form @submit="handleSubmit($event, updateOrCreateAddress)">
                        <!-- Billing Address Header -->
                        <div class="mb-4 flex items-center justify-between pb-2 border-b border-[#e5e7eb]/60">
                            <h3 class="font-display text-lg sm:text-xl font-extrabold text-[#133b63]">
                                <template v-if="activeAddressForm == 'billing'">
                                    @lang('shop::app.checkout.onepage.address.billing-address')
                                </template>

                                <template v-else>
                                    @lang('shop::app.checkout.onepage.address.shipping-address')
                                </template>
                            </h3>

                            <button
                                type="button"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-[#64748b] hover:text-[#1d5b8f] transition-colors"
                                v-show="customerSavedAddresses.billing.length && ['billing', 'shipping'].includes(activeAddressForm)"
                                @click="selectedAddressForEdit = null; activeAddressForm = null"
                            >
                                <i class="fa-solid fa-arrow-left text-xs"></i>
                                <span>@lang('shop::app.checkout.onepage.address.back')</span>
                            </button>
                        </div>
                        
                        <!-- Address Form Vue Component -->
                        <v-checkout-address-form
                            :control-name="activeAddressForm"
                            :address="selectedAddressForEdit || undefined"
                        ></v-checkout-address-form>

                        <!-- Save Address to Address Book Checkbox -->
                        <div class="mt-4 p-3.5 rounded-xl bg-[#f8fafc] border border-[#e5e7eb] flex items-center gap-3 select-none transition-all hover:border-[#1d5b8f]/40">
                            <input
                                type="checkbox"
                                :name="activeAddressForm + '.save_address'"
                                id="save_address"
                                value="1"
                                v-model="saveAddress"
                                @change="saveAddress = ! saveAddress"
                                class="h-4 w-4 rounded border-[#e5e7eb] text-[#1d5b8f] focus:ring-[#1d5b8f] cursor-pointer"
                            />

                            <label
                                class="cursor-pointer select-none text-xs sm:text-sm font-semibold text-[#133b63]"
                                for="save_address"
                            >
                                @lang('shop::app.checkout.onepage.address.save-address')
                            </label>
                        </div>

                        <!-- Save Button -->
                        <div class="mt-6 flex justify-end">
                            <x-shop::button
                                class="soxnsox-btn-primary h-12 px-10 text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 max-md:w-full shadow-soxnsox-card rounded-full"
                                :title="trans('shop::app.checkout.onepage.address.save')"
                                ::loading="isStoring"
                                ::disabled="isStoring"
                            />
                        </div>
                    </form>
                </x-shop::form>
            </template>
        </template>
    </script>

    <script type="module">
        app.component('v-checkout-address-customer', {
            template: '#v-checkout-address-customer-template',

            props: ['cart'],

            emits: ['processing', 'processed'],

            data() {
                return {
                    customerSavedAddresses: {
                        'billing': [],
                        
                        'shipping': [],
                    },

                    useBillingAddressForShipping: true,

                    activeAddressForm: null,

                    selectedAddressForEdit: null,

                    saveAddress: false,

                    selectedAddresses: {
                        billing_address_id: null,

                        shipping_address_id: null,
                    },

                    isLoading: true,

                    isStoring: false,
                }
            },

            created() {
                if (this.cart.billing_address) {
                    this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
                }
            },

            mounted() {
                this.getCustomerSavedAddresses();
            },

            methods: {
                getCustomerSavedAddresses() {
                    this.$axios.get('{{ route('shop.api.customers.account.addresses.index') }}')
                        .then(response => {
                            this.initializeAddresses('billing', structuredClone(response.data.data));

                            this.initializeAddresses('shipping', structuredClone(response.data.data));

                            if (! this.customerSavedAddresses.billing.length) {
                                this.activeAddressForm = 'billing';
                            }

                            this.isLoading = false;
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                },

                initializeAddresses(type, addresses) {
                    this.customerSavedAddresses[type] = addresses;

                    let cartAddress = this.cart[type + '_address'];

                    if (! cartAddress) {
                        addresses.forEach(address => {
                            if (address.default_address) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });

                        return addresses;
                    }

                    if (cartAddress.parent_address_id) {
                        addresses.forEach(address => {
                            if (address.id == cartAddress.parent_address_id) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });
                    } else {
                        this.selectedAddresses[type + '_address_id'] = cartAddress.id;
                        
                        addresses.unshift(cartAddress);
                    }

                    return addresses;
                },

                updateOrCreateAddress(params, { setErrors }) {
                    this.$emit('processing', 'address');

                    params = params[this.activeAddressForm];

                    let address = this.customerSavedAddresses[this.activeAddressForm].find(address => {
                        return address.id == params.id;
                    });

                    if (! address) {
                        if (params.save_address) {
                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.addAddressToList(params);
                        }

                        return;
                    }

                    if (params.save_address) {
                        if (address.address_type == 'customer') {
                            this.updateCustomerAddress(params.id, params, { setErrors })
                                .then((response) => {
                                    this.updateAddressInList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.removeAddressFromList(params);

                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        }
                    } else {
                        this.updateAddressInList(params);
                    }
                },

                addAddressToList(address) {
                    this.cart[this.activeAddressForm + '_address'] = address;

                    this.customerSavedAddresses[this.activeAddressForm].unshift(address);

                    this.selectedAddresses[this.activeAddressForm + '_address_id'] = address.id;

                    this.activeAddressForm = null;
                },

                updateAddressInList(params) {
                    this.customerSavedAddresses[this.activeAddressForm].forEach((address, index) => {
                        if (address.id == params.id) {
                            params = {
                                ...address,
                                ...params,
                            };

                            this.cart[this.activeAddressForm + '_address'] = params;

                            this.customerSavedAddresses[this.activeAddressForm][index] = params;

                            this.selectedAddresses[this.activeAddressForm + '_address_id'] = params.id;

                            this.activeAddressForm = null;
                        }
                    });
                },

                removeAddressFromList(params) {
                    this.customerSavedAddresses[this.activeAddressForm] = this.customerSavedAddresses[this.activeAddressForm].filter(address => address.id != params.id);
                },

                createCustomerAddress(params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.post('{{ route('shop.api.customers.account.addresses.store') }}', params)
                        .then((response) => {
                            this.isStoring = false;

                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                let errors = {};

                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });

                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                updateCustomerAddress(id, params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.put('{{ route('shop.api.customers.account.addresses.update') }}/' + id, params)
                        .then((response) => {
                            this.isStoring = false;

                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                let errors = {};

                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });

                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                addAddressToCart(params, { setErrors }) {
                    let payload = {
                        billing: {
                            ...this.getSelectedAddress('billing', params.billing.id),
                            use_for_shipping: this.useBillingAddressForShipping
                        },
                    };

                    if (params.shipping !== undefined) {
                        payload.shipping = this.getSelectedAddress('shipping', params.shipping.id);
                    }

                    this.isStoring = true;

                    this.moveToNextStep();

                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', payload)
                        .then((response) => {
                            this.isStoring = false;

                            if (response.data.data.redirect_url) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                if (this.cart.have_stockable_items) {
                                    this.$emit('processed', response.data.data.shippingMethods);
                                } else {
                                    this.$emit('processed', response.data.data.payment_methods);
                                }
                            }
                        })
                        .catch(error => {
                            this.isStoring = false;

                            this.$emit('processing', 'address');

                            if (error.response.status == 422) {
                                const billingRegex = /^billing\./;

                                if (Object.keys(error.response.data.errors).some(key => billingRegex.test(key))) {
                                    setErrors({
                                        'billing.id': error.response.data.message
                                    });
                                } else {
                                    setErrors({
                                        'shipping.id': error.response.data.message
                                    });
                                }
                            }
                        });
                },

                getSelectedAddress(type, id) {
                    let address = Object.assign({}, this.customerSavedAddresses[type].find(address => address.id == id));

                    if (id == 0) {
                        address.id = null;
                    }

                    return {
                        ...address,
                        default_address: 0,
                    };
                },

                moveToNextStep() {
                    if (this.cart.have_stockable_items) {
                        this.$emit('processing', 'shipping');
                    } else {
                        this.$emit('processing', 'payment');
                    }
                },
            }
        });
    </script>
@endPushOnce