@php
    $inventorySources = app(\Webkul\Inventory\Repositories\InventorySourceRepository::class)->findWhere(['status' => 1]);
    $primaryInventorySource = $inventorySources->first();
    $primaryInventorySourceId = $primaryInventorySource ? $primaryInventorySource->id : 1;
@endphp

{!! view_render_event('bagisto.admin.catalog.product.edit.form.types.configurable.before', ['product' => $product]) !!}

<v-product-variations :errors="errors" :primary-inventory-source-id="{{ $primaryInventorySourceId }}"></v-product-variations>

{!! view_render_event('bagisto.admin.catalog.product.edit.form.types.configurable.after', ['product' => $product]) !!}

@pushOnce('scripts')
    <!-- Variations Template -->
    <script
        type="text/x-template"
        id="v-product-variations-template"
    >
        <div class="relative rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden mb-6">
            <!-- Top Accent Gradient Line -->
            <div class="h-1 w-full" style="background: linear-gradient(90deg, #133b63 0%, #2ca7a3 50%, #f29a38 100%);"></div>

            <!-- Panel Header -->
            <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-[#133b63] border border-blue-200/80 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>

                        <div>
                            <div class="flex items-center gap-2.5">
                                <h3 class="text-base font-bold text-slate-900 tracking-tight">
                                    Product Variations
                                </h3>

                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-700 border border-blue-200">
                                    @{{ variants.length }} Variations
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 mt-0.5">
                                Manage variant prices, stock levels, SKUs, and imagery in one unified table.
                            </p>
                        </div>
                    </div>

                    <!-- Header Stats & Action -->
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Stat: Total Stock -->
                        <div class="hidden sm:flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 shadow-2xs">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            <span class="text-xs text-slate-500 font-medium">In Stock:</span>
                            <span class="text-xs font-bold text-slate-800">@{{ totalUnitsInStock }} units</span>
                        </div>

                        <!-- Stat: Price Range -->
                        <div class="hidden md:flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 shadow-2xs">
                            <span class="text-xs text-slate-500 font-medium">Range:</span>
                            <span class="text-xs font-bold text-blue-700">@{{ formattedPriceRange }}</span>
                        </div>

                        <!-- Add Button -->
                        <button
                            type="button"
                            class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-xs font-bold text-white shadow-sm hover:opacity-95 transition-all cursor-pointer"
                            style="background: linear-gradient(135deg, #133b63 0%, #0d2847 100%);"
                            @click="$refs.variantCreateModal.open()"
                        >
                            <i class="icon-add text-base"></i>
                            <span>Add Variation</span>
                        </button>
                    </div>
                </div>

                <!-- Filter & Bulk Toolbar (When variants exist) -->
                <div
                    class="mt-4 pt-4 border-t border-slate-200/60 flex flex-wrap items-center justify-between gap-3"
                    v-if="variants.length"
                >
                    <!-- Left: Search & Attribute Filter -->
                    <div class="flex flex-wrap items-center gap-2.5 flex-1 max-w-xl">
                        <!-- Quick Search -->
                        <div class="relative flex-1 min-w-[240px]">
                            <i class="icon-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input
                                type="text"
                                v-model="searchQuery"
                                placeholder="Filter by SKU, color, or pack size..."
                                class="w-full rounded-xl border border-slate-200 bg-white py-2 pr-8 text-xs text-slate-700 placeholder-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition-all shadow-2xs"
                                style="padding-left: 36px;"
                            />
                            <button
                                type="button"
                                v-if="searchQuery"
                                @click="searchQuery = ''"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                            >
                                <i class="icon-cancel text-xs"></i>
                            </button>
                        </div>

                        <!-- Attribute Filter Dropdown -->
                        <select
                            v-model="filterAttribute"
                            class="custom-select rounded-xl border border-slate-200 bg-white py-2 px-3 text-xs font-medium text-slate-700 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 shadow-2xs"
                        >
                            <option value="all">All Variations (@{{ variants.length }})</option>
                            <optgroup
                                v-for="attribute in superAttributes"
                                :key="attribute.code"
                                :label="attribute.admin_name"
                            >
                                <option
                                    v-for="option in attribute.options"
                                    :key="option.id"
                                    :value="attribute.code + ':' + option.id"
                                >
                                    @{{ attribute.admin_name }}: @{{ option.admin_name }}
                                </option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Right: Selection Count & Mass Action Button -->
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-500 font-medium">
                            Showing @{{ visibleVariantsCount }} of @{{ variants.length }}
                        </span>

                        <!-- Mass Action Vue Component -->
                        <v-product-variations-mass-action
                            :super-attributes="superAttributes"
                            :variants="variants"
                        >
                        </v-product-variations-mass-action>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <template v-if="variants.length">
                <div class="overflow-x-auto border-t border-slate-200 w-full">
                    <div class="w-full" style="min-width: 1150px;">
                        <!-- Table Header Bar -->
                        <div class="flex items-center gap-4 px-5 py-3.5 bg-slate-100/90 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600 select-none w-full">
                            <div class="w-10 shrink-0 flex items-center justify-center">
                                <input
                                    type="checkbox"
                                    :id="'select_all_variants_checkbox'"
                                    class="peer hidden"
                                    :checked="areAllVisibleSelected"
                                    @change="toggleSelectAllVisible"
                                />
                                <label
                                    class="icon-uncheckbox peer-checked:icon-checked cursor-pointer text-lg peer-checked:text-blue-600"
                                    :for="'select_all_variants_checkbox'"
                                    title="Select all visible"
                                ></label>
                            </div>
                            <div class="w-14 shrink-0 text-center">
                                Media
                            </div>
                            <div class="flex-1 min-w-[220px]">
                                Variation &amp; Options
                            </div>
                            <div class="flex-1 min-w-[240px]">
                                SKU
                            </div>
                            <div class="w-36 shrink-0">
                                Regular Price
                            </div>
                            <div class="w-36 shrink-0">
                                Sale Price
                            </div>
                            <div class="w-28 shrink-0 text-center">
                                Stock
                            </div>
                            <div class="w-24 shrink-0 text-center">
                                Status
                            </div>
                            <div class="w-24 shrink-0 text-right">
                                Actions
                            </div>
                        </div>

                        <!-- Variations Items List -->
                        <div class="divide-y divide-slate-100">
                            <v-product-variation-item
                                v-for='(variant, index) in variants'
                                :key="variant.id"
                                :index="index"
                                :variant="variant"
                                :attributes="superAttributes"
                                :primary-inventory-source-id="primaryInventorySourceId"
                                @onRemoved="removeVariant"
                                :errors="errors"
                            >
                            </v-product-variation-item>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <template v-else>
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-[#133b63] shadow-inner mb-4">
                        <i class="icon-attribute text-4xl"></i>
                    </div>

                    <h4 class="text-base font-bold text-slate-800">
                        No variations created yet
                    </h4>

                    <p class="max-w-md text-xs text-slate-500 mt-1 mb-5">
                        Add product variations to enable customers to pick colors, pack sizes, or other options with individual prices and inventory.
                    </p>

                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-[#133b63] px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-[#1b4b7c] transition-all cursor-pointer"
                        @click="$refs.variantCreateModal.open()"
                    >
                        <i class="icon-add text-base"></i>
                        <span>Add First Variation</span>
                    </button>
                </div>
            </template>

            <!-- Add Variant Form Modal -->
            <x-admin::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                <form @submit="handleSubmit($event, addVariant)">
                    <x-admin::modal ref="variantCreateModal">
                        <!-- Modal Header -->
                        <x-slot:header>
                            <div class="flex items-center gap-2.5">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#133b63]">
                                    <i class="icon-attribute text-lg"></i>
                                </div>
                                <p class="text-base font-bold text-gray-900">
                                    Create New Variation Combination
                                </p>
                            </div>
                        </x-slot>
        
                        <!-- Modal Content -->
                        <x-slot:content>
                            <p class="text-xs text-slate-500 mb-4">
                                Select an option for each attribute to define this new product variation:
                            </p>

                            <x-admin::form.control-group
                                v-for='(attribute, index) in superAttributes'
                                class="mb-4"
                            >
                                <x-admin::form.control-group.label class="required text-xs font-semibold text-slate-700">
                                    @{{ attribute.admin_name }}
                                </x-admin::form.control-group.label>

                                <v-field
                                    as="select"
                                    :name="attribute.code"
                                    class="custom-select flex min-h-[40px] w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition-all hover:border-gray-400 focus:border-[#133b63]"
                                    :class="[errors[attribute.code] ? 'border-red-500' : '']"
                                    rules="required"
                                    :label="attribute.admin_name"
                                >
                                    <option value="" disabled selected>Select @{{ attribute.admin_name }}...</option>
                                    <option
                                        v-for="option in attribute.options"
                                        :key="option.id"
                                        :value="option.id"
                                    >
                                        @{{ option.admin_name }}
                                    </option>
                                </v-field>

                                <v-error-message
                                    :name="attribute.code"
                                    v-slot="{ message }"
                                >
                                    <p
                                        class="mt-1 text-xs italic text-red-600"
                                        v-text="message"
                                    >
                                    </p>
                                </v-error-message>
                            </x-admin::form.control-group>
                        </x-slot>
        
                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <div class="flex items-center justify-end gap-2.5">
                                <button
                                    type="button"
                                    class="transparent-button text-xs"
                                    @click="$refs.variantCreateModal.close()"
                                >
                                    Cancel
                                </button>

                                <x-admin::button
                                    button-type="submit"
                                    class="primary-button text-xs font-bold"
                                    :title="trans('admin::app.catalog.products.edit.types.configurable.create.save-btn')"
                                />
                            </div>
                        </x-slot>
                    </x-admin::modal>
                </form>
            </x-admin::form>
        </div>
    </script>

    <!-- Mass Action Template -->
    <script
        type="text/x-template"
        id="v-product-variations-mass-action-template"
    >
        <div class="flex items-center gap-2">
            <!-- Dropdown Actions Menu -->
            <x-admin::dropdown position="bottom-right">
                <x-slot:toggle>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50 transition-all cursor-pointer"
                    >
                        <i class="icon-settings text-sm text-[#133b63]"></i>
                        <span>Bulk Actions</span>
                        <span
                            v-if="selectedVariants.length"
                            class="inline-flex items-center justify-center rounded-full bg-[#133b63] px-1.5 text-[10px] font-bold text-white leading-tight"
                        >
                            @{{ selectedVariants.length }}
                        </span>
                        <i class="icon-sort-down text-sm text-slate-400"></i>
                    </button>
                </x-slot>

                <x-slot:menu>
                    <div class="p-1 min-w-[200px]">
                        <x-admin::dropdown.menu.item
                            v-for="type in updateTypes"
                            @click="edit(type.key)"
                            class="rounded-lg text-xs"
                        >
                            @{{ type.title }}
                        </x-admin::dropdown.menu.item>
                    </div>
                </x-slot>
            </x-admin::dropdown>

            <!-- Bulk Edit Drawer -->
            <x-admin::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                <form @submit="handleSubmit($event, updateAll)">
                    <x-admin::drawer
                        ref="updateVariantsDrawer"
                        class="text-left"
                    >
                        <x-slot:header>
                            <div class="flex items-center justify-between">
                                <p class="text-lg font-bold text-slate-800">
                                    @{{ updateTypes[selectedType]?.title }}
                                </p>

                                <button
                                    class="primary-button text-xs font-bold ltr:mr-11 rtl:ml-11"
                                    type="submit"
                                >
                                    Apply Changes
                                </button>
                            </div>
                        </x-slot>

                        <x-slot:content class="p-5">
                            <!-- Helper Info -->
                            <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50/70 p-3 text-xs text-blue-900">
                                Applying changes to <strong>@{{ tempSelectedVariants.length }}</strong> selected variation(s).
                            </div>

                            <x-admin::form
                                v-slot="{ meta, errors, handleSubmit }"
                                as="div"
                            >
                                <form @submit="handleSubmit($event, update)">
                                    <!-- Mass Update Regular Price -->
                                    <template v-if="selectedType == 'editPrices'">
                                        <div class="border-b border-slate-200 pb-4 mb-4">
                                            <div class="flex items-end gap-2.5">
                                                <x-admin::form.control-group class="!mb-0 flex-1">
                                                    <x-admin::form.control-group.label class="required text-xs font-semibold">
                                                        Apply Regular Price to All Selected
                                                    </x-admin::form.control-group.label>
                        
                                                    <div class="relative">
                                                        <span 
                                                            class="absolute top-1/2 -translate-y-1/2 text-slate-400 ltr:left-3 rtl:right-3 font-bold text-xs"
                                                            v-pre
                                                        >
                                                            {{ core()->currencySymbol(core()->getBaseCurrencyCode()) }}
                                                        </span>

                                                        <x-admin::form.control-group.control
                                                            type="text"
                                                            class="ltr:pl-7 rtl:pr-7 text-xs font-bold"
                                                            name="price"
                                                            ::rules="{required: true, decimal: true, min_value: 0}"
                                                            label="Regular Price"
                                                        />
                                                    </div>
                                                </x-admin::form.control-group>

                                                <button class="secondary-button text-xs">
                                                    Apply to All
                                                </button>
                                            </div>
                    
                                            <x-admin::form.control-group.error control-name="price" />
                                        </div>
                                    </template>

                                    <!-- Mass Update Sale Price -->
                                    <template v-if="selectedType == 'editSpecialPrices'">
                                        <div class="border-b border-slate-200 pb-4 mb-4">
                                            <div class="flex items-end gap-2.5">
                                                <x-admin::form.control-group class="!mb-0 flex-1">
                                                    <x-admin::form.control-group.label class="text-xs font-semibold text-emerald-800">
                                                        Apply Sale / Special Price to All Selected
                                                    </x-admin::form.control-group.label>
                        
                                                    <div class="relative">
                                                        <span 
                                                            class="absolute top-1/2 -translate-y-1/2 text-emerald-600 ltr:left-3 rtl:right-3 font-bold text-xs"
                                                            v-pre
                                                        >
                                                            {{ core()->currencySymbol(core()->getBaseCurrencyCode()) }}
                                                        </span>

                                                        <x-admin::form.control-group.control
                                                            type="text"
                                                            class="ltr:pl-7 rtl:pr-7 text-xs font-bold border-emerald-300 bg-emerald-50/30 text-emerald-900"
                                                            name="special_price"
                                                            ::rules="{decimal: true, min_value: 0}"
                                                            label="Sale Price"
                                                        />
                                                    </div>
                                                </x-admin::form.control-group>

                                                <button class="secondary-button text-xs">
                                                    Apply to All
                                                </button>
                                            </div>
                    
                                            <x-admin::form.control-group.error control-name="special_price" />
                                        </div>
                                    </template>

                                    <!-- Mass Update Weight -->
                                    <template v-if="selectedType == 'editWeight'">
                                        <div class="border-b border-slate-200 pb-4 mb-4">
                                            <div class="flex items-end gap-2.5">
                                                <x-admin::form.control-group class="!mb-0 flex-1">
                                                    <x-admin::form.control-group.label class="required text-xs font-semibold">
                                                        Apply Weight (kg) to All Selected
                                                    </x-admin::form.control-group.label>
                        
                                                    <div class="relative">
                                                        <x-admin::form.control-group.control
                                                            type="text"
                                                            name="weight"
                                                            ::rules="{ required: true, regex: /^([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)$/ }"
                                                            label="Weight"
                                                        />
                                                    </div>
                                                </x-admin::form.control-group>

                                                <button class="secondary-button text-xs">
                                                    Apply to All
                                                </button>
                                            </div>
                    
                                            <x-admin::form.control-group.error control-name="weight" />
                                        </div>
                                    </template>

                                    <!-- Mass Update Status -->
                                    <template v-if="selectedType == 'editStatus'">
                                        <div class="border-b border-slate-200 pb-4 mb-4">
                                            <div class="flex items-end gap-2.5">
                                                <x-admin::form.control-group class="!mb-0 flex-1">
                                                    <x-admin::form.control-group.label class="text-xs font-semibold">
                                                        Apply Status to All Selected
                                                    </x-admin::form.control-group.label>
                        
                                                    <div class="relative">
                                                        <x-admin::form.control-group.control
                                                            type="select"
                                                            name="status"
                                                            ::rules="{ required: true }"
                                                            label="Status"
                                                        >
                                                            <option value="1">Enabled (Active)</option>
                                                            <option value="0">Disabled (Inactive)</option>
                                                        </x-admin::form.control-group.control>
                                                    </div>
                                                </x-admin::form.control-group>

                                                <button class="secondary-button text-xs">
                                                    Apply to All
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </form>
                            </x-admin::form>

                            <!-- Individual Inputs in Drawer -->
                            <div
                                class="border-b border-slate-100 py-3.5 last:border-b-0 flex items-center justify-between gap-3"
                                v-for="variant in tempSelectedVariants"
                                :key="variant.id"
                            >
                                <div class="text-xs font-semibold text-slate-800">
                                    <span
                                        class="after:content-['_/_'] last:after:content-['']"
                                        v-for='attribute in superAttributes'
                                        :key="attribute.id"
                                    >
                                        @{{ optionName(attribute, variant[attribute.code]) }}
                                    </span>
                                </div>

                                <template v-if="selectedType == 'editPrices'">
                                    <div class="relative w-32">
                                        <span class="absolute top-1/2 -translate-y-1/2 text-slate-400 ltr:left-3 rtl:right-3 font-bold text-xs" v-pre>{{ core()->currencySymbol(core()->getBaseCurrencyCode()) }}</span>
                                        <input
                                            type="text"
                                            class="w-full rounded-lg border border-slate-200 py-1.5 ltr:pl-7 ltr:pr-2 rtl:pr-7 rtl:pl-2 text-xs font-bold"
                                            v-model="variant.price"
                                        />
                                    </div>
                                </template>

                                <template v-if="selectedType == 'editSpecialPrices'">
                                    <div class="relative w-32">
                                        <span class="absolute top-1/2 -translate-y-1/2 text-emerald-600 ltr:left-3 rtl:right-3 font-bold text-xs" v-pre>{{ core()->currencySymbol(core()->getBaseCurrencyCode()) }}</span>
                                        <input
                                            type="text"
                                            class="w-full rounded-lg border border-emerald-300 bg-emerald-50/30 py-1.5 ltr:pl-7 ltr:pr-2 rtl:pr-7 rtl:pl-2 text-xs font-bold text-emerald-900"
                                            v-model="variant.special_price"
                                            placeholder="None"
                                        />
                                    </div>
                                </template>

                                <template v-if="selectedType == 'editWeight'">
                                    <div class="w-32">
                                        <input
                                            type="text"
                                            class="w-full rounded-lg border border-slate-200 py-1.5 px-3 text-xs"
                                            v-model="variant.weight"
                                        />
                                    </div>
                                </template>

                                <template v-if="selectedType == 'editStatus'">
                                    <div class="w-32">
                                        <select
                                            class="w-full rounded-lg border border-slate-200 py-1.5 px-2 text-xs font-medium"
                                            v-model="variant.status"
                                        >
                                            <option :value="1">Enabled</option>
                                            <option :value="0">Disabled</option>
                                        </select>
                                    </div>
                                </template>

                                <template v-if="selectedType == 'editInventories'">
                                    <div class="w-32">
                                        <input
                                            type="number"
                                            min="0"
                                            class="w-full rounded-lg border border-slate-200 py-1.5 px-3 text-xs font-bold text-center"
                                            v-model="variant.inventories[inventorySources[0]?.id || 1]"
                                        />
                                    </div>
                                </template>
                            </div>
                        </x-slot>
                    </x-admin::drawer>
                </form>
            </x-admin::form>
        </div>
    </script>

    <!-- Variation Item Template (Shopify / WooCommerce Style Row) -->
    <script
        type="text/x-template"
        id="v-product-variation-item-template"
    >
        <div
            class="flex items-center gap-4 px-5 py-3 transition-colors hover:bg-slate-50/80 w-full"
            :class="{'bg-blue-50/30': variant.selected, 'opacity-60 bg-slate-50/50': !variant.status}"
            v-show="$parent.isVariantVisible(variant)"
            style="min-width: 1150px;"
        >
            <!-- Form Hidden Fields (Always in DOM so Bagisto never drops attributes on save) -->
            <input
                type="hidden"
                :name="'variants[' + variant.id + '][name]'"
                :value="variant.name"
            />

            <input
                type="hidden"
                :name="'variants[' + variant.id + '][special_price_from]'"
                :value="variant.special_price_from"
            />

            <input
                type="hidden"
                :name="'variants[' + variant.id + '][special_price_to]'"
                :value="variant.special_price_to"
            />

            <input
                type="hidden"
                :name="'variants[' + variant.id + '][weight]'"
                :value="variant.weight"
            />

            <input
                type="hidden"
                :name="'variants[' + variant.id + '][status]'"
                :value="variant.status ? 1 : 0"
            />

            <template v-for="attribute in attributes" :key="attribute.id">
                <input
                    type="hidden"
                    :name="'variants[' + variant.id + '][' + attribute.code + ']'"
                    :value="variant[attribute.code]"
                />
            </template>

            <!-- Inventories for additional sources -->
            <template v-for="inventorySource in inventorySources" :key="inventorySource.id">
                <input
                    type="hidden"
                    :name="'variants[' + variant.id + '][inventories][' + inventorySource.id + ']'"
                    :value="variant.inventories[inventorySource.id]"
                    v-if="inventorySource.id != primaryInventorySourceId"
                />
            </template>

            <!-- Image Hidden Inputs for File Uploads -->
            <template v-for="(image, imgIdx) in variant.images" :key="imgIdx">
                <input
                    type="hidden"
                    :name="'variants[' + variant.id + '][images][files][' + image.id + ']'"
                    v-if="! image.is_new"
                />

                <input
                    type="file"
                    :name="'variants[' + variant.id + '][images][files][]'"
                    :id="$.uid + '_imageInput_' + imgIdx"
                    class="hidden"
                    accept="image/*"
                    :ref="$.uid + '_imageInput_' + imgIdx"
                />
            </template>
            <!-- Ends Form Hidden Fields -->

            <!-- Col 1: Checkbox -->
            <div class="w-10 shrink-0 flex items-center justify-center">
                <input
                    type="checkbox"
                    :id="'variant_' + variant.id"
                    class="peer hidden"
                    v-model="variant.selected"
                />

                <label
                    class="icon-uncheckbox peer-checked:icon-checked cursor-pointer text-lg peer-checked:text-blue-600 select-none"
                    :for="'variant_' + variant.id"
                ></label>
            </div>

            <!-- Col 2: Image Thumbnail -->
            <div class="w-14 shrink-0 flex items-center justify-center">
                <div
                    class="relative h-11 w-11 shrink-0 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden cursor-pointer hover:border-blue-600 transition-all group/img shadow-2xs"
                    @click="$refs.editVariantDrawer.open()"
                    title="Click to view/change images"
                >
                    <template v-if="! variant.images.length">
                        <img src="{{ bagisto_asset('images/product-placeholders/front.svg') }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/img:opacity-100 flex items-center justify-center transition-opacity text-white">
                            <i class="icon-camera text-xs"></i>
                        </div>
                    </template>

                    <template v-else>
                        <img :src="variant.images[0].url" class="h-full w-full object-cover">
                        <span
                            v-if="variant.images.length > 1"
                            class="absolute bottom-0.5 right-0.5 rounded-full px-1 text-[9px] font-bold text-white leading-tight shadow-xs"
                            style="background-color: #133b63;"
                        >
                            @{{ variant.images.length }}
                        </span>
                    </template>
                </div>
            </div>

            <!-- Col 3: Options & Badges -->
            <div class="flex-1 min-w-[220px]">
                <div class="flex flex-wrap items-center gap-1.5">
                    <span
                        v-for="attribute in attributes"
                        :key="attribute.id"
                        class="inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-bold shadow-2xs"
                        :class="attribute.code === 'color' ? 'bg-slate-100 text-slate-800 border border-slate-200' : 'bg-teal-50 text-teal-800 border border-teal-200'"
                    >
                        @{{ optionName(attribute, variant[attribute.code]) }}
                    </span>

                    <span
                        class="inline-flex items-center rounded-md bg-amber-50 px-1.5 py-0.5 text-[10px] font-bold text-amber-800 border border-amber-200 shadow-2xs"
                        v-if="isDefault"
                    >
                        Default
                    </span>
                </div>

                <p class="text-[11px] text-slate-500 font-medium truncate mt-1" :title="variant.name">
                    @{{ variant.name || 'Untitled variation' }}
                </p>
            </div>

            <!-- Col 4: SKU Input -->
            <div class="flex-1 min-w-[240px]">
                <input
                    type="text"
                    :name="'variants[' + variant.id + '][sku]'"
                    v-model="variant.sku"
                    placeholder="Variant SKU"
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-mono font-medium text-slate-800 transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 shadow-2xs truncate focus:overflow-visible"
                    :title="variant.sku"
                />
            </div>

            <!-- Col 5: Regular Price (Modern Input Group) -->
            <div class="w-36 shrink-0">
                <div class="flex items-stretch rounded-lg border border-slate-200 bg-white transition-all focus-within:border-blue-600 focus-within:ring-2 focus-within:ring-blue-600/20 shadow-2xs overflow-hidden">
                    <span
                        class="inline-flex items-center justify-center bg-slate-50 px-2.5 text-xs font-bold text-slate-500 border-r border-slate-200 select-none pointer-events-none"
                        v-pre
                    >
                        {{ core()->currencySymbol(core()->getBaseCurrencyCode()) }}
                    </span>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        :name="'variants[' + variant.id + '][price]'"
                        v-model="variant.price"
                        placeholder="0.00"
                        class="w-full px-2.5 py-1.5 text-xs font-bold text-slate-800 outline-none bg-transparent"
                    />
                </div>
            </div>

            <!-- Col 6: Sale Price (Modern Input Group) -->
            <div class="w-36 shrink-0 relative">
                <div class="flex items-stretch rounded-lg border border-emerald-300 bg-white transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20 shadow-2xs overflow-hidden">
                    <span
                        class="inline-flex items-center justify-center bg-emerald-50 px-2.5 text-xs font-bold text-emerald-700 border-r border-emerald-200 select-none pointer-events-none"
                        v-pre
                    >
                        {{ core()->currencySymbol(core()->getBaseCurrencyCode()) }}
                    </span>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        :name="'variants[' + variant.id + '][special_price]'"
                        v-model="variant.special_price"
                        placeholder="Sale"
                        class="w-full px-2.5 py-1.5 text-xs font-bold text-emerald-900 outline-none bg-transparent placeholder-slate-400"
                    />
                </div>

                <!-- Tiny Sale Badge Indicator -->
                <span
                    v-if="variant.special_price && parseFloat(variant.special_price) > 0"
                    class="absolute -top-2 right-1 inline-flex items-center rounded-full bg-emerald-600 px-1.5 py-0.2 text-[8px] font-black uppercase text-white shadow-2xs leading-tight"
                >
                    SALE
                </span>
            </div>

            <!-- Col 7: Stock Quantity -->
            <div class="w-28 shrink-0 text-center">
                <input
                    type="number"
                    min="0"
                    :name="'variants[' + variant.id + '][inventories][' + primaryInventorySourceId + ']'"
                    v-model="variant.inventories[primaryInventorySourceId]"
                    placeholder="0"
                    class="w-full rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-bold text-center transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 shadow-2xs"
                    :class="parseInt(variant.inventories[primaryInventorySourceId]) > 0 ? 'text-slate-800' : 'text-rose-500 border-rose-300 bg-rose-50/40'"
                />
            </div>

            <!-- Col 8: Status Toggle -->
            <div class="w-24 shrink-0 flex items-center justify-center">
                <button
                    type="button"
                    @click="variant.status = variant.status ? 0 : 1"
                    class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                    :class="variant.status ? 'bg-emerald-500' : 'bg-slate-300'"
                    :title="variant.status ? 'Active variation' : 'Disabled variation'"
                >
                    <span
                        class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition duration-200 ease-in-out"
                        :class="variant.status ? 'translate-x-4' : 'translate-x-0'"
                    ></span>
                </button>
            </div>

            <!-- Col 9: Actions -->
            <div class="w-24 shrink-0 flex items-center justify-end gap-1.5">
                <button
                    type="button"
                    class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-200/70 hover:text-slate-800 transition-all cursor-pointer"
                    @click="$refs.editVariantDrawer.open()"
                    title="Edit Details &amp; Images"
                >
                    <i class="icon-edit text-sm"></i>
                </button>

                <button
                    type="button"
                    class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all cursor-pointer"
                    @click="remove"
                    title="Delete variation"
                >
                    <i class="icon-delete text-sm"></i>
                </button>
            </div>

            <!-- Edit Details Drawer -->
            <x-admin::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                        <form @submit="handleSubmit($event, update)">
                            <x-admin::drawer
                                ref="editVariantDrawer"
                                class="text-left"
                            >
                                <!-- Drawer Header -->
                                <x-slot:header>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-lg font-bold text-slate-900">
                                                Edit Variation Details
                                            </p>
                                            <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                                <span
                                                    v-for="attribute in attributes"
                                                    :key="attribute.id"
                                                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-800 border border-blue-200"
                                                >
                                                    @{{ optionName(attribute, variant[attribute.code]) }}
                                                </span>
                                            </div>
                                        </div>

                                        <button class="primary-button text-xs font-bold ltr:mr-11 rtl:ml-11">
                                            Save Details
                                        </button>
                                    </div>
                                </x-slot>

                                <!-- Drawer Content -->
                                <x-slot:content class="p-5">
                                    <x-admin::form.control-group.control
                                        type="hidden"
                                        name="id"
                                        ::value="variant.id"
                                    />

                                    <!-- Name Field -->
                                    <x-admin::form.control-group class="mb-4">
                                        <x-admin::form.control-group.label class="required text-xs font-semibold">
                                            @lang('admin::app.catalog.products.edit.types.configurable.edit.name')
                                        </x-admin::form.control-group.label>
            
                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="name"
                                            ::value="variant.name"
                                            rules="required"
                                            class="text-xs"
                                            :label="trans('admin::app.catalog.products.edit.types.configurable.edit.name')"
                                        />
            
                                        <x-admin::form.control-group.error control-name="name" />
                                    </x-admin::form.control-group>

                                    <!-- SKU Field -->
                                    <x-admin::form.control-group class="mb-4">
                                        <x-admin::form.control-group.label class="required text-xs font-semibold">
                                            @lang('admin::app.catalog.products.edit.types.configurable.edit.sku')
                                        </x-admin::form.control-group.label>
            
                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="sku"
                                            rules="required"
                                            ::value="variant.sku"
                                            class="text-xs font-mono"
                                            :label="trans('admin::app.catalog.products.edit.types.configurable.edit.sku')"
                                        />
            
                                        <x-admin::form.control-group.error control-name="sku" />
                                    </x-admin::form.control-group>

                                    <!-- Pricing Section (Regular + Sale) -->
                                    <div class="mb-4 grid grid-cols-2 gap-4">
                                        <x-admin::form.control-group class="!mb-0">
                                            <x-admin::form.control-group.label class="required text-xs font-semibold">
                                                Regular Price (₹)
                                            </x-admin::form.control-group.label>
                
                                            <x-admin::form.control-group.control
                                                type="text"
                                                name="price"
                                                ::rules="{required: true, decimal: true, min_value: 0}"
                                                ::value="variant.price"
                                                class="text-xs font-bold"
                                                label="Regular Price"
                                            />
                
                                            <x-admin::form.control-group.error control-name="price" />
                                        </x-admin::form.control-group>

                                        <x-admin::form.control-group class="!mb-0">
                                            <x-admin::form.control-group.label class="text-xs font-semibold text-emerald-800">
                                                Sale Price / Special Price (₹)
                                            </x-admin::form.control-group.label>
                
                                            <x-admin::form.control-group.control
                                                type="text"
                                                name="special_price"
                                                ::rules="{decimal: true, min_value: 0}"
                                                ::value="variant.special_price"
                                                class="text-xs font-bold border-emerald-300 bg-emerald-50/20 text-emerald-900"
                                                label="Sale Price"
                                            />
                
                                            <x-admin::form.control-group.error control-name="special_price" />
                                        </x-admin::form.control-group>
                                    </div>

                                    <!-- Sale Schedule Dates -->
                                    <div class="mb-4 grid grid-cols-2 gap-4">
                                        <x-admin::form.control-group class="!mb-0">
                                            <x-admin::form.control-group.label class="text-xs font-semibold text-slate-600">
                                                Sale Start Date
                                            </x-admin::form.control-group.label>
                
                                            <x-admin::form.control-group.control
                                                type="date"
                                                name="special_price_from"
                                                ::value="variant.special_price_from"
                                                class="text-xs"
                                                label="Sale Start Date"
                                            />
                                        </x-admin::form.control-group>

                                        <x-admin::form.control-group class="!mb-0">
                                            <x-admin::form.control-group.label class="text-xs font-semibold text-slate-600">
                                                Sale End Date
                                            </x-admin::form.control-group.label>
                
                                            <x-admin::form.control-group.control
                                                type="date"
                                                name="special_price_to"
                                                ::value="variant.special_price_to"
                                                class="text-xs"
                                                label="Sale End Date"
                                            />
                                        </x-admin::form.control-group>
                                    </div>

                                    <!-- Weight & Status -->
                                    <div class="mb-4 grid grid-cols-2 gap-4">
                                        <x-admin::form.control-group class="!mb-0">
                                            <x-admin::form.control-group.label class="required text-xs font-semibold">
                                                Weight (kg)
                                            </x-admin::form.control-group.label>
                
                                            <x-admin::form.control-group.control
                                                type="text"
                                                name="weight"
                                                ::rules="{ required: true, regex: /^([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)$/ }"
                                                ::value="variant.weight"
                                                class="text-xs"
                                                label="Weight"
                                            />
                
                                            <x-admin::form.control-group.error control-name="weight" />
                                        </x-admin::form.control-group>

                                        <x-admin::form.control-group class="!mb-0">
                                            <x-admin::form.control-group.label class="text-xs font-semibold">
                                                Status
                                            </x-admin::form.control-group.label>
                
                                            <x-admin::form.control-group.control
                                                type="select"
                                                name="status"
                                                rules="required"
                                                ::value="variant.status"
                                                class="text-xs font-medium"
                                                label="Status"
                                            >
                                                <option value="1">Enabled (Active)</option>
                                                <option value="0">Disabled (Inactive)</option>
                                            </x-admin::form.control-group.control>
                
                                            <x-admin::form.control-group.error control-name="status" />
                                        </x-admin::form.control-group>
                                    </div>

                                    <!-- Inventories Breakdown -->
                                    <div class="mb-5 rounded-xl border border-slate-200 bg-slate-50/50 p-4">
                                        <p class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-700">
                                            Stock Quantities by Inventory Source
                                        </p>

                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                            <x-admin::form.control-group
                                                class="!mb-0"
                                                v-for='inventorySource in inventorySources'
                                            >
                                                <x-admin::form.control-group.label class="text-xs text-slate-600 font-medium">
                                                    @{{ inventorySource.name }}
                                                </x-admin::form.control-group.label>

                                                <v-field
                                                    type="number"
                                                    min="0"
                                                    class="flex min-h-[38px] w-full rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-800 transition-all focus:border-[#133b63]"
                                                    :name="'inventories[' + inventorySource.id + ']'"
                                                    rules="numeric|min:0"
                                                    v-model="variant.inventories[inventorySource.id]"
                                                    :label="inventorySource.name"
                                                >
                                                </v-field>
                                            </x-admin::form.control-group>
                                        </div>
                                    </div>

                                    <!-- Variant Images -->
                                    <div class="mb-5">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-700">
                                                Variation Media Gallery
                                            </p>
                                            <span class="text-xs text-slate-400">Shown when customer selects this combination</span>
                                        </div>

                                        <v-media-images
                                            name="images"
                                            v-bind:allow-multiple="true"
                                            :uploaded-images="variant.images"
                                        >
                                        </v-media-images>
                                    </div>

                                    <!-- Advanced: Customer Group & Wholesale Tier Pricing -->
                                    <div
                                        class="rounded-xl border border-sky-200 bg-sky-50/60 p-4 text-xs text-sky-950"
                                        v-if="typeof variant.id !== 'string'"
                                    >
                                        <div class="flex items-start gap-2.5">
                                            <i class="icon-attribute text-lg text-[#133b63] shrink-0 mt-0.5"></i>
                                            <div>
                                                <p class="font-bold text-[#133b63] text-xs">
                                                    Customer Group &amp; Tier Pricing
                                                </p>
                                                <p class="text-slate-600 text-xs mt-0.5 mb-2.5">
                                                    Configure wholesale discounts, B2B quantity tier breaks, or specific channel overrides:
                                                </p>
                                                <a
                                                    :href="'{{ route('admin.catalog.products.edit', ':id') }}'.replace(':id', variant.id)" 
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-[#133b63]/30 bg-white px-3 py-1.5 text-xs font-semibold text-[#133b63] shadow-2xs hover:bg-[#133b63] hover:text-white transition-all"
                                                    target="_blank"
                                                >
                                                    <span>Open Advanced Variant Editor</span>
                                                    <i class="icon-sort-right text-xs"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </x-slot>
                            </x-admin::drawer>
                        </form>
                    </x-admin::form>
                </div>
    </script>

    <!-- Component Scripts -->
    <script type="module">
        app.component('v-product-variations', {
            template: '#v-product-variations-template',

            props: ['errors', 'primaryInventorySourceId'],

            data () {
                return {
                    defaultId: parseInt('{{ $product->additional['default_variant_id'] ?? null }}'),

                    variants: (@json($product->variants()->with(['attribute_family', 'images', 'inventories'])->get())).map((v) => {
                        v.price = v.price !== null && v.price !== undefined ? parseFloat(v.price) : 0;
                        v.special_price = (v.special_price !== null && v.special_price !== undefined && v.special_price !== '' && parseFloat(v.special_price) > 0) ? parseFloat(v.special_price) : '';
                        v.weight = v.weight !== null && v.weight !== undefined ? parseFloat(v.weight) : 0;
                        v.selected = false;
                        return v;
                    }),

                    superAttributes: @json($product->super_attributes()->with(['options', 'options.attribute', 'options.translations'])->get()),

                    searchQuery: '',

                    filterAttribute: 'all',

                    selectedVariant: {
                        id: null,
                        name: '',
                        sku: '',
                        price: 0,
                        special_price: null,
                        status: 1,
                        weight: 0,
                        inventories: {},
                        images: []
                    },
                }
            },

            computed: {
                totalUnitsInStock() {
                    let total = 0;
                    this.variants.forEach(v => {
                        if (v.inventories) {
                            for (let key in v.inventories) {
                                total += parseInt(v.inventories[key]) || 0;
                            }
                        }
                    });
                    return total;
                },

                formattedPriceRange() {
                    if (!this.variants.length) return '—';
                    let prices = this.variants.map(v => parseFloat(v.price) || 0).filter(p => p > 0);
                    if (!prices.length) return '₹0';
                    let min = Math.min(...prices);
                    let max = Math.max(...prices);
                    if (min === max) {
                        return this.$admin.formatPrice(min);
                    }
                    return `${this.$admin.formatPrice(min)} – ${this.$admin.formatPrice(max)}`;
                },

                visibleVariantsCount() {
                    return this.variants.filter(v => this.isVariantVisible(v)).length;
                },

                areAllVisibleSelected() {
                    let visible = this.variants.filter(v => this.isVariantVisible(v));
                    if (!visible.length) return false;
                    return visible.every(v => v.selected);
                }
            },

            methods: {
                isVariantVisible(variant) {
                    if (this.searchQuery && this.searchQuery.trim() !== '') {
                        let q = this.searchQuery.toLowerCase().trim();
                        let nameMatch = (variant.name || '').toLowerCase().includes(q);
                        let skuMatch = (variant.sku || '').toLowerCase().includes(q);
                        let attrMatch = false;

                        for (let attr of this.superAttributes) {
                            let opt = attr.options.find(o => o.id == variant[attr.code]);
                            if (opt && (opt.admin_name || '').toLowerCase().includes(q)) {
                                attrMatch = true;
                                break;
                            }
                        }

                        if (!nameMatch && !skuMatch && !attrMatch) {
                            return false;
                        }
                    }

                    if (this.filterAttribute && this.filterAttribute !== 'all') {
                        let parts = this.filterAttribute.split(':');
                        if (parts.length === 2) {
                            let attrCode = parts[0];
                            let optionId = parts[1];
                            if (variant[attrCode] != optionId) {
                                return false;
                            }
                        }
                    }

                    return true;
                },

                toggleSelectAllVisible() {
                    let visible = this.variants.filter(v => this.isVariantVisible(v));
                    let allSelected = visible.every(v => v.selected);
                    visible.forEach(v => v.selected = !allSelected);
                },

                addVariant(params, { resetForm }) {
                    let filteredVariants = this.variants.filter((variant) => {
                        let matchCount = 0;

                        for (let key in params) {
                            if (variant[key] == params[key]) {
                                matchCount++;
                            }
                        }

                        return matchCount == this.superAttributes.length;
                    });

                    if (filteredVariants.length) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('admin::app.catalog.products.edit.types.configurable.create.variant-already-exists')" });

                        return;
                    }

                    const optionIds = Object.values(params);

                    let inventories = {};
                    inventories[this.primaryInventorySourceId] = 0;

                    this.variants.push(Object.assign({
                        id: 'variant_' + this.variants.length,
                        sku: '{{ $product->sku }}' + '-variant-' + optionIds.join('-'),
                        name: '',
                        price: 0,
                        special_price: null,
                        special_price_from: null,
                        special_price_to: null,
                        status: 1,
                        weight: 0,
                        inventories: inventories,
                        images: []
                    }, params));

                    resetForm();

                    this.$refs.variantCreateModal.close();
                },

                removeVariant(variant) {
                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            this.variants.splice(this.variants.indexOf(variant), 1);
                        },
                    });
                },
            }
        });

        app.component('v-product-variations-mass-action', {
            template: '#v-product-variations-mass-action-template',

            props: ['superAttributes', 'variants'],

            data() {
                return {
                    inventorySources: @json($inventorySources),

                    selectedType: '',
                    
                    tempSelectedVariants: [],

                    updateTypes: {
                        editPrices: {
                            key: 'editPrices',
                            value: 'price',
                            title: 'Bulk Edit Regular Price'
                        },

                        editSpecialPrices: {
                            key: 'editSpecialPrices',
                            value: 'special_price',
                            title: 'Bulk Edit Sale / Special Price'
                        },

                        editInventories: {
                            key: 'editInventories',
                            value: 'edit-inventories',
                            title: 'Bulk Edit Stock Quantities'
                        },

                        editWeight: {
                            key: 'editWeight',
                            value: 'weight',
                            title: 'Bulk Edit Weight'
                        },

                        editStatus: {
                            key: 'editStatus',
                            value: 'status',
                            title: 'Bulk Edit Active Status'
                        },

                        removeVariants: {
                            key: 'removeVariants',
                            value: 'remove-variants',
                            title: 'Delete Selected Variations'
                        }
                    },
                };
            },

            computed: {
                selectedVariants() {
                    return this.variants.filter((variant) => {
                        variant.temp_images = [];

                        return variant.selected;
                    });
                },
            },

            watch: {
                selectedVariants(newSelectedVariants) {
                    this.tempSelectedVariants = JSON.parse(JSON.stringify(newSelectedVariants));
                },
            },

            mounted() {
                this.tempSelectedVariants = this.selectedVariants;
            },

            methods: {
                optionName(attribute, optionId) {
                    return attribute.options.find((option) => {
                        return option.id == optionId;
                    })?.admin_name;
                },

                edit(type) {
                    if (! this.selectedVariants.length) {
                        this.$emitter.emit('add-flash', {
                            type: 'warning',
                            message: 'Please select at least one variation to apply bulk actions.'
                        });

                        return;
                    }

                    this.selectedType = type;

                    if (type === 'removeVariants') {
                        this.removeVariants();
                    } else {
                        this.$refs.updateVariantsDrawer.open();
                    }
                },

                update(params, { resetForm }) {
                    this[this.selectedType](params);

                    resetForm();
                },

                updateAll(params) {
                    this[this.selectedType](params);

                    this.$refs.updateVariantsDrawer.close();

                    this.selectedVariants.forEach((variant) => variant.selected = false);
                },

                editPrices(params) {
                    let val = params.price;
                    this.selectedVariants.forEach((variant) => {
                        let match = this.tempSelectedVariants.find(t => t.id === variant.id);
                        variant.price = val !== undefined && val !== '' ? val : (match ? match.price : variant.price);
                    });
                },

                editSpecialPrices(params) {
                    let val = params.special_price;
                    this.selectedVariants.forEach((variant) => {
                        let match = this.tempSelectedVariants.find(t => t.id === variant.id);
                        variant.special_price = val !== undefined && val !== '' ? val : (match ? match.special_price : variant.special_price);
                    });
                },

                editInventories(params) {
                    let sourceId = this.inventorySources[0]?.id || 1;
                    this.selectedVariants.forEach((variant) => {
                        let match = this.tempSelectedVariants.find(t => t.id === variant.id);
                        if (match && match.inventories) {
                            variant.inventories[sourceId] = match.inventories[sourceId];
                        }
                    });
                },

                editWeight(params) {
                    let val = params.weight;
                    this.selectedVariants.forEach((variant) => {
                        let match = this.tempSelectedVariants.find(t => t.id === variant.id);
                        variant.weight = val !== undefined && val !== '' ? val : (match ? match.weight : variant.weight);
                    });
                },

                editStatus(params) {
                    let val = params.status;
                    this.selectedVariants.forEach((variant) => {
                        let match = this.tempSelectedVariants.find(t => t.id === variant.id);
                        variant.status = val !== undefined && val !== '' ? parseInt(val) : (match ? parseInt(match.status) : variant.status);
                    });
                },

                removeVariants() {
                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            this.selectedVariants.forEach((variant) => {
                                let index = this.variants.findIndex(v => v.id === variant.id);
                                if (index !== -1) {
                                    this.variants.splice(index, 1);
                                }
                            });
                        },
                    });
                }
            }
        });

        app.component('v-product-variation-item', {
            template: '#v-product-variation-item-template',

            props: [
                'variant',
                'attributes',
                'errors',
                'primaryInventorySourceId'
            ],

            data() {
                return {
                    inventorySources: @json($inventorySources),
                }
            },

            created() {
                let inventories = {};

                this.inventorySources.forEach((source) => {
                    const inventory = Array.isArray(this.variant.inventories)
                        ? this.variant.inventories.find(inventory => inventory.inventory_source_id === source.id)
                        : null;

                    inventories[source.id] = inventory ? (inventory.qty || 0) : 0;
                });

                this.variant.inventories = inventories;
            },

            mounted() {
                if (typeof this.variant.id === 'string' || this.variant.id instanceof String) {
                    this.$refs.editVariantDrawer.open();
                }
            },

            computed: {
                isDefault() {
                    return this.variant.id == this.$parent.defaultId;
                },

                totalQty() {
                    let totalQty = 0;

                    for (let key in this.variant.inventories) {
                        totalQty += parseInt(this.variant.inventories[key]) || 0;
                    }

                    return totalQty;
                }
            },

            watch: {
                variant: {
                    handler(newValue) {
                        setTimeout(() => this.setFiles());
                    },
                    deep: true
                }
            },

            methods: {
                optionName(attribute, optionId) {
                    return attribute.options.find((option) => {
                        return option.id == optionId;
                    })?.admin_name;
                },

                update(params) {
                    Object.assign(this.variant, params);

                    this.$refs.editVariantDrawer.close();
                },

                setFiles() {
                    this.variant.images.forEach((image, index) => {
                        if (image.file instanceof File) {
                            image.is_new = 1;

                            const dataTransfer = new DataTransfer();

                            dataTransfer.items.add(image.file);

                            if (this.$refs[this.$.uid + '_imageInput_' + index] && this.$refs[this.$.uid + '_imageInput_' + index][0]) {
                                this.$refs[this.$.uid + '_imageInput_' + index][0].files = dataTransfer.files;
                            }
                        } else {
                            image.is_new = 0;
                        }
                    });
                },

                remove() {
                    this.$emit('onRemoved', this.variant);
                },
            }
        });
    </script>
@endPushOnce