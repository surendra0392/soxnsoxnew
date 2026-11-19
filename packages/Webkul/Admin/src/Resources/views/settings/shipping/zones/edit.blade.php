<x-admin::layouts>
    <x-slot:title>
        Edit Shipping Zone
    </x-slot>

    <x-admin::form :action="route('admin.settings.shipping.zones.update', $zone->id)" method="PUT">
        <v-shipping-zone></v-shipping-zone>
    </x-admin::form>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-shipping-zone-template">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xl font-bold text-gray-800">
                        Edit Shipping Zone
                    </p>

                    <div class="flex items-center gap-x-2.5">
                        <a href="{{ route('admin.settings.shipping.zones.index') }}" class="transparent-button">
                            Back
                        </a>
                        <button type="submit" class="primary-button">
                            Save Zone
                        </button>
                    </div>
                </div>

                <div class="flex gap-4 max-xl:flex-wrap">
                    <div class="flex flex-col gap-4 max-xl:w-full flex-1">
                        <!-- Zone Details -->
                        <div class="box-shadow rounded bg-white p-4">
                            <p class="mb-4 text-base font-semibold text-gray-800">Zone Details</p>
                            
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">Zone Name</x-admin-form.control-group.label>
                                <x-admin::form.control-group.control type="text" name="name" rules="required" :value="$zone->name" :label="'Zone Name'" />
                                <x-admin::form.control-group.error control-name="name" />
                            </x-admin::form.control-group>
                            
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>Status</x-admin-form.control-group.label>
                                <x-admin::form.control-group.control type="switch" name="is_active" value="1" :label="'Status'" :checked="(bool) $zone->is_active" />
                                <x-admin::form.control-group.error control-name="is_active" />
                            </x-admin::form.control-group>
                        </div>

                        <!-- Zone Regions -->
                        <div class="box-shadow rounded bg-white p-4">
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-base font-semibold text-gray-800">Zone Regions</p>
                                <button type="button" @click="addLocation" class="secondary-button !py-1 !px-2 !text-xs">Add Region</button>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-4">Select the regions that this zone applies to. Customers matching these regions will see the shipping methods below.</p>

                            <div v-if="locations.length === 0" class="text-center py-4 text-gray-500 bg-gray-50 rounded border border-dashed border-gray-300">
                                No regions added. This zone will apply to all regions not covered by other zones.
                            </div>

                            <div v-for="(location, index) in locations" :key="'loc'+index" class="flex gap-4 items-start mb-4 bg-gray-50 p-4 rounded border border-gray-200">
                                <div class="w-1/3">
                                    <label class="block text-xs font-semibold mb-1 text-gray-600">Region Type</label>
                                    <select :name="'locations[' + index + '][type]'" v-model="location.type" @change="location.code = ''" class="custom-select w-full p-2 border rounded bg-white">
                                        <option value="country">Country</option>
                                        <option value="state">State / Province</option>
                                        <option value="postcode">Postcode / ZIP</option>
                                    </select>
                                </div>
                                
                                <!-- For Country or Postcode (Single Input) -->
                                <div v-if="location.type !== 'state'" class="w-1/2">
                                    <label class="block text-xs font-semibold mb-1 text-gray-600">Region</label>
                                    <select v-if="location.type === 'country'" :name="'locations[' + index + '][code]'" v-model="location.code" class="custom-select w-full p-2 border rounded bg-white">
                                        <option value="">Select Country...</option>
                                        @foreach (core()->countries() as $country)
                                            <option value="{{ $country->code }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <input v-else type="text" :name="'locations[' + index + '][code]'" v-model="location.code" placeholder="e.g. 90210 or 9021*" class="w-full p-2 border rounded bg-white" />
                                </div>

                                <!-- For State (Double Input) -->
                                <div v-else class="w-1/2 flex gap-4">
                                    <div class="w-1/2">
                                        <label class="block text-xs font-semibold mb-1 text-gray-600">Country</label>
                                        <select v-model="location.country_code" @change="location.code = ''" class="custom-select w-full p-2 border rounded bg-white">
                                            <option value="">Select Country...</option>
                                            @foreach (core()->countries() as $country)
                                                <option value="{{ $country->code }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block text-xs font-semibold mb-1 text-gray-600">State</label>
                                        <select :name="'locations[' + index + '][code]'" v-model="location.code" class="custom-select w-full p-2 border rounded bg-white" :disabled="!location.country_code">
                                            <option value="">Select State...</option>
                                            <option v-for="state in countryStates[location.country_code]" :key="state.code" :value="state.code">
                                                @{{ state.default_name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-1/6 text-right pt-6">
                                    <button type="button" @click="removeLocation(index)" class="text-red-600 hover:underline text-sm">Remove</button>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Methods -->
                        <div class="box-shadow rounded bg-white p-4">
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-base font-semibold text-gray-800">Shipping Methods</p>
                                <button type="button" @click="addMethod" class="secondary-button !py-1 !px-2 !text-xs">Add Method</button>
                            </div>

                            <p class="text-sm text-gray-600 mb-4">Add shipping methods available to customers in this zone.</p>

                            <div v-if="methods.length === 0" class="text-center py-4 text-gray-500 bg-gray-50 rounded border border-dashed border-gray-300">
                                No shipping methods added. Customers in this zone will not be able to checkout.
                            </div>

                            <div v-for="(method, index) in methods" :key="'m'+index" class="mb-4 bg-gray-50 p-4 rounded border border-gray-200">
                                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200">
                                    <span class="font-bold">Method #@{{ index + 1 }}</span>
                                    <button type="button" @click="removeMethod(index)" class="text-red-600 hover:underline text-sm">Remove</button>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-semibold mb-1">Method Title</label>
                                        <input type="text" :name="'methods[' + index + '][title]'" v-model="method.title" class="w-full p-2 border rounded" required placeholder="e.g. Standard Delivery" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold mb-1">Method Type</label>
                                        <select :name="'methods[' + index + '][type]'" v-model="method.type" class="custom-select w-full p-2 border rounded">
                                            <option value="flat_rate">Flat Rate</option>
                                            <option value="free_shipping">Free Shipping</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-semibold mb-1">Price</label>
                                        <input type="number" step="0.01" :name="'methods[' + index + '][price]'" v-model="method.price" class="w-full p-2 border rounded" placeholder="0.00" :disabled="method.type === 'free_shipping'" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold mb-1">Status</label>
                                        <select :name="'methods[' + index + '][is_active]'" v-model="method.is_active" class="custom-select w-full p-2 border rounded">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold mb-1">Priority (Sorting)</label>
                                        <input type="number" :name="'methods[' + index + '][priority]'" v-model="method.priority" class="w-full p-2 border rounded" />
                                    </div>
                                </div>

                                <p class="text-xs font-semibold text-gray-500 mb-2">Optional Conditions (Leave blank if not applicable)</p>
                                <div class="grid grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Min Subtotal</label>
                                        <input type="number" step="0.01" :name="'methods[' + index + '][min_subtotal]'" v-model="method.min_subtotal" class="w-full p-2 border rounded text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Max Subtotal</label>
                                        <input type="number" step="0.01" :name="'methods[' + index + '][max_subtotal]'" v-model="method.max_subtotal" class="w-full p-2 border rounded text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Min Weight</label>
                                        <input type="number" step="0.01" :name="'methods[' + index + '][min_weight]'" v-model="method.min_weight" class="w-full p-2 border rounded text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Max Weight</label>
                                        <input type="number" step="0.01" :name="'methods[' + index + '][max_weight]'" v-model="method.max_weight" class="w-full p-2 border rounded text-sm" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            @php
                $groupedStates = core()->groupedStatesByCountries();
                $defaultCountry = config('app.default_country', 'IN');
                $zoneLocations = $zone->locations->map(function($loc) use ($groupedStates, $defaultCountry) {
                    $countryCode = '';
                    if ($loc->location_type === 'state') {
                        if (isset($groupedStates[$defaultCountry])) {
                            foreach ($groupedStates[$defaultCountry] as $state) {
                                if ($state->code === $loc->location_code) {
                                    $countryCode = $defaultCountry;
                                    break;
                                }
                            }
                        }

                        if (! $countryCode) {
                            foreach ($groupedStates as $cCode => $states) {
                                foreach ($states as $state) {
                                    if ($state->code === $loc->location_code) {
                                        $countryCode = $cCode;
                                        break 2;
                                    }
                                }
                            }
                        }
                    }

                    return [
                        'type'         => $loc->location_type ?: 'country',
                        'code'         => $loc->location_code,
                        'country_code' => $countryCode
                    ];
                })->toArray();

                $zoneMethods = $zone->methods->map(function($m) {
                    return [
                        'title' => $m->title,
                        'type' => $m->type,
                        'price' => $m->price,
                        'is_active' => $m->is_active,
                        'priority' => $m->priority,
                        'min_subtotal' => $m->min_subtotal,
                        'max_subtotal' => $m->max_subtotal,
                        'min_weight' => $m->min_weight,
                        'max_weight' => $m->max_weight,
                    ];
                })->toArray();
            @endphp
            app.component('v-shipping-zone', {
                template: '#v-shipping-zone-template',
                data() {
                    return {
                        countryStates: @json(core()->groupedStatesByCountries()),
                        locations: @json($zoneLocations),
                        methods: @json($zoneMethods)
                    }
                },
                methods: {
                    addLocation() {
                        this.locations.push({ type: 'country', code: '', country_code: '' });
                    },
                    removeLocation(index) {
                        this.locations.splice(index, 1);
                    },
                    addMethod() {
                        this.methods.push({
                            title: '',
                            type: 'flat_rate',
                            price: 0,
                            is_active: 1,
                            priority: 0,
                            min_subtotal: '',
                            max_subtotal: '',
                            min_weight: '',
                            max_weight: ''
                        });
                    },
                    removeMethod(index) {
                        this.methods.splice(index, 1);
                    }
                }
            });
        </script>
    @endPushOnce
</x-admin::layouts>
