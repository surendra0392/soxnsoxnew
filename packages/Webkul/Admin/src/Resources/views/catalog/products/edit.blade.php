<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.catalog.products.edit.title')
    </x-slot>

    {!! view_render_event('bagisto.admin.catalog.product.edit.before', ['product' => $product]) !!}

    <x-admin::form
        method="PUT"
        enctype="multipart/form-data"
    >
        {!! view_render_event('bagisto.admin.catalog.product.edit.actions.before', ['product' => $product]) !!}

        @php
            $channels = core()->getAllChannels();
            $currentChannel = core()->getRequestedChannel();
            $currentLocale = core()->getRequestedLocale();
            $defaultTab = 'general';
        @endphp

        <v-product-edit-workspace
            default-tab="{{ $defaultTab }}"
            product-type="{{ $product->type }}"
            :variant-count="{{ $product->type === 'configurable' ? $product->variants->count() : 0 }}"
            v-slot="{ activeTab, setTab, productType }"
        >
            <!-- Page Header (Shopify / WooCommerce Style Sticky Header) -->
            <div class="sticky top-0 z-20 -mx-4 -mt-4 mb-4 bg-white/95 px-6 py-3.5 backdrop-blur-md border-b border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <!-- Left: Title & Badges -->
                    <div class="flex items-center gap-3">
                        <a
                            href="{{ route('admin.catalog.products.index') }}"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition-all"
                            title="Back to Catalog"
                        >
                            <i class="icon-sort-left text-lg"></i>
                        </a>

                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h1 class="text-lg font-bold leading-tight text-slate-900" v-pre>
                                    {{ $product->name ?? trans('admin::app.catalog.products.edit.title') }}
                                </h1>

                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold {{ $product->type === 'configurable' ? 'bg-purple-100 text-purple-800 border border-purple-200' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $product->type === 'configurable' ? 'Variable Product' : ucfirst($product->type) }}
                                </span>

                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono font-medium bg-slate-100 text-slate-600">
                                    SKU: {{ $product->sku }}
                                </span>

                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-bold {{ $product->status ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $product->status ? 'bg-emerald-600' : 'bg-rose-600' }}"></span>
                                    {{ $product->status ? 'Active' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Actions & Channel/Locale Switchers -->
                    <div class="flex items-center gap-2.5">
                        <!-- Channel & Locale Mini Dropdowns -->
                        <div class="flex items-center gap-1">
                            <x-admin::dropdown :class="$channels->count() <= 1 ? 'hidden' : ''">
                                <x-slot:toggle>
                                    <button
                                        type="button"
                                        class="transparent-button px-2 py-1.5 text-xs font-medium hover:bg-gray-100 rounded-lg flex items-center gap-1"
                                    >
                                        <span class="icon-store text-base text-slate-500"></span>
                                        <span v-pre>{{ $currentChannel->name }}</span>
                                        <input type="hidden" name="channel" value="{{ $currentChannel->code }}" />
                                        <span class="icon-sort-down text-base text-slate-400"></span>
                                    </button>
                                </x-slot>
                                <x-slot:content class="!p-0">
                                    @foreach ($channels as $channel)
                                        <a
                                            href="?{{ Arr::query(['channel' => $channel->code, 'locale' => $channel->default_locale?->code ?? $currentLocale->code ]) }}"
                                            class="flex cursor-pointer gap-2.5 px-4 py-2 text-xs hover:bg-gray-100"
                                            v-pre
                                        >
                                            {{ $channel->name }}
                                        </a>
                                    @endforeach
                                </x-slot>
                            </x-admin::dropdown>

                            <x-admin::dropdown :class="$currentChannel->locales->count() <= 1 ? 'hidden' : ''">
                                <x-slot:toggle>
                                    <button
                                        type="button"
                                        class="transparent-button px-2 py-1.5 text-xs font-medium hover:bg-gray-100 rounded-lg flex items-center gap-1"
                                    >
                                        <span class="icon-language text-base text-slate-500"></span>
                                        <span v-pre>{{ $currentLocale->name }}</span>
                                        <input type="hidden" name="locale" value="{{ $currentLocale->code }}" />
                                        <span class="icon-sort-down text-base text-slate-400"></span>
                                    </button>
                                </x-slot>
                                <x-slot:content class="!p-0">
                                    @foreach ($currentChannel->locales->sortBy('name') as $locale)
                                        <a
                                            href="?{{ Arr::query(['channel' => $currentChannel->code, 'locale' => $locale->code]) }}"
                                            class="flex gap-2.5 px-4 py-2 text-xs cursor-pointer hover:bg-gray-100 {{ $locale->code == $currentLocale->code ? 'bg-gray-100' : ''}}"
                                            v-pre
                                        >
                                            {{ $locale->name }}
                                        </a>
                                    @endforeach
                                </x-slot>
                            </x-admin::dropdown>
                        </div>

                        @if (
                            $product->status
                            && $product->visible_individually
                            && $product->url_key
                        )
                            <a
                                href="{{ route('shop.product_or_category.index', $product->url_key) }}"
                                class="secondary-button text-xs font-semibold inline-flex items-center gap-1.5"
                                target="_blank"
                            >
                                <span>@lang('admin::app.catalog.products.edit.preview')</span>
                                <i class="icon-share text-xs"></i>
                            </a>
                        @endif

                        <button type="submit" class="primary-button text-xs font-bold inline-flex items-center gap-1.5 px-4 py-2">
                            <i class="icon-done text-sm"></i>
                            <span>@lang('admin::app.catalog.products.edit.save-btn')</span>
                        </button>
                    </div>
                </div>

                <!-- Workspace Navigation Tabs (Shopify / WooCommerce Style) -->
                <div class="mt-3 flex items-center justify-between gap-3 border-t border-slate-100 pt-2.5 max-sm:flex-wrap">
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5 text-xs font-semibold">
                        <!-- Tab 1: Details & Description -->
                        <button
                            type="button"
                            @click="setTab('general')"
                            class="inline-flex items-center gap-2 rounded-xl px-3.5 py-1.5 transition-all cursor-pointer whitespace-nowrap"
                            :style="activeTab === 'general' ? 'background: linear-gradient(135deg, #133b63 0%, #0d2847 100%) !important; color: #ffffff !important;' : ''"
                            :class="activeTab === 'general' ? 'shadow-sm font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900'"
                        >
                            <i class="icon-edit text-sm"></i>
                            <span>Details &amp; Description</span>
                        </button>

                        @if ($product->type === 'configurable')
                            <!-- Tab 2: Variations & Stock -->
                            <button
                                type="button"
                                @click="setTab('variations')"
                                class="inline-flex items-center gap-2 rounded-xl px-3.5 py-1.5 transition-all cursor-pointer whitespace-nowrap"
                                :style="activeTab === 'variations' ? 'background: linear-gradient(135deg, #133b63 0%, #0d2847 100%) !important; color: #ffffff !important;' : ''"
                                :class="activeTab === 'variations' ? 'shadow-sm font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900'"
                            >
                                <i class="icon-attribute text-sm"></i>
                                <span>Variations &amp; Stock</span>
                                <span
                                    class="inline-flex items-center rounded-full px-2 py-0.2 text-[10px] font-black leading-tight"
                                    :style="activeTab === 'variations' ? 'background-color: rgba(255,255,255,0.2) !important; color: #ffffff !important;' : 'background-color: #e2e8f0 !important; color: #334155 !important;'"
                                >
                                    {{ $product->variants->count() }}
                                </span>
                            </button>
                        @else
                            <!-- Tab 2: Price & Stock (Simple Product) -->
                            <button
                                type="button"
                                @click="setTab('inventory')"
                                class="inline-flex items-center gap-2 rounded-xl px-3.5 py-1.5 transition-all cursor-pointer whitespace-nowrap"
                                :style="activeTab === 'inventory' ? 'background: linear-gradient(135deg, #133b63 0%, #0d2847 100%) !important; color: #ffffff !important;' : ''"
                                :class="activeTab === 'inventory' ? 'shadow-sm font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900'"
                            >
                                <i class="icon-inventory text-sm"></i>
                                <span>Price &amp; Stock</span>
                            </button>
                        @endif

                        <!-- Tab 3: Media Gallery -->
                        <button
                            type="button"
                            @click="setTab('media')"
                            class="inline-flex items-center gap-2 rounded-xl px-3.5 py-1.5 transition-all cursor-pointer whitespace-nowrap"
                            :style="activeTab === 'media' ? 'background: linear-gradient(135deg, #133b63 0%, #0d2847 100%) !important; color: #ffffff !important;' : ''"
                            :class="activeTab === 'media' ? 'shadow-sm font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900'"
                        >
                            <i class="icon-camera text-sm"></i>
                            <span>Media Gallery</span>
                            @if ($product->images->count())
                                <span
                                    class="inline-flex items-center rounded-full px-1.5 py-0.2 text-[10px] font-bold leading-tight"
                                    :style="activeTab === 'media' ? 'background-color: rgba(255,255,255,0.2) !important; color: #ffffff !important;' : 'background-color: #e2e8f0 !important; color: #334155 !important;'"
                                >
                                    {{ $product->images->count() }}
                                </span>
                            @endif
                        </button>

                        <!-- Tab 4: Linked Products -->
                        <button
                            type="button"
                            @click="setTab('links')"
                            class="inline-flex items-center gap-2 rounded-xl px-3.5 py-1.5 transition-all cursor-pointer whitespace-nowrap"
                            :style="activeTab === 'links' ? 'background: linear-gradient(135deg, #133b63 0%, #0d2847 100%) !important; color: #ffffff !important;' : ''"
                            :class="activeTab === 'links' ? 'shadow-sm font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900'"
                        >
                            <i class="icon-cart text-sm"></i>
                            <span>Linked Products</span>
                        </button>

                        <!-- Tab 5: SEO & URL -->
                        <button
                            type="button"
                            @click="setTab('seo')"
                            class="inline-flex items-center gap-2 rounded-xl px-3.5 py-1.5 transition-all cursor-pointer whitespace-nowrap"
                            :style="activeTab === 'seo' ? 'background: linear-gradient(135deg, #133b63 0%, #0d2847 100%) !important; color: #ffffff !important;' : ''"
                            :class="activeTab === 'seo' ? 'shadow-sm font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900'"
                        >
                            <i class="icon-search text-sm"></i>
                            <span>SEO &amp; URL</span>
                        </button>
                    </div>

                    <!-- Right Side: View Mode Toggle -->
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="setTab(activeTab === 'all' ? ('{{ $defaultTab }}') : 'all')"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-2.5 py-1 text-[11px] font-semibold transition-all cursor-pointer"
                            :style="activeTab === 'all' ? 'background-color: #1e293b !important; color: #ffffff !important; border-color: #1e293b !important;' : 'background-color: #ffffff; color: #475569;'"
                            title="Toggle continuous all-sections view"
                        >
                            <i class="icon-view text-xs"></i>
                            <span>@{{ activeTab === 'all' ? 'Back to Tabs' : 'View All' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            {!! view_render_event('bagisto.admin.catalog.product.edit.actions.after', ['product' => $product]) !!}

            <!-- body content -->
            {!! view_render_event('bagisto.admin.catalog.product.edit.form.before', ['product' => $product]) !!}

            <div class="mt-4 flex flex-col gap-6">
                <!-- TAB 1: Details & Description -->
                <div v-show="activeTab === 'general' || activeTab === 'all'" class="w-full">
                    <div class="flex gap-4 max-xl:flex-wrap">
                        <!-- Left: Main Details & Description (flex-1) -->
                        <div class="flex flex-1 flex-col gap-4 max-xl:flex-auto">
                            @foreach ($product->attribute_family->attribute_groups as $group)
                                @if (in_array($group->code, ['meta_description', 'inventories', 'settings']))
                                    @continue
                                @endif

                                @if ($group->code === 'rma')
                                    @if (
                                        ! in_array($product->type, explode(',', core()->getConfigData('sales.rma.setting.select_allowed_product_type'))) 
                                        && (
                                            $product->type != 'simple' 
                                            && empty($product->parent_id)
                                        )
                                    )
                                        @continue
                                    @endif
                                @endif

                                @php $customAttributes = $product->getEditableAttributes($group); @endphp

                                @if ($customAttributes->isNotEmpty())
                                    {!! view_render_event("bagisto.admin.catalog.product.edit.form.{$group->code}.before", ['product' => $product]) !!}

                                    <div class="box-shadow relative rounded-2xl bg-white p-5 border border-slate-200" id="section-{{ $group->code }}">
                                        <p class="mb-4 text-base font-bold text-gray-800" v-pre>
                                            {{ $group->name }}
                                        </p>

                                        @foreach ($customAttributes as $attribute)
                                            {!! view_render_event("bagisto.admin.catalog.product.edit.form.{$group->code}.controls.before", ['product' => $product]) !!}

                                            <x-admin::form.control-group class="last:!mb-0">
                                                <x-admin::form.control-group.label>
                                                    {!! e($attribute->admin_name) . ($attribute->is_required ? '<span class="required"></span>' : '') !!}

                                                    @if (
                                                        $attribute->value_per_channel
                                                        && $channels->count() > 1
                                                    )
                                                        <span 
                                                            class="rounded border border-gray-200 bg-gray-100 px-1 py-0.5 text-[10px] font-semibold leading-normal text-gray-600"
                                                            v-pre
                                                        >
                                                            {{ $currentChannel->name }}
                                                        </span>
                                                    @endif

                                                    @if ($attribute->value_per_locale)
                                                        <span
                                                            class="rounded border border-gray-200 bg-gray-100 px-1 py-0.5 text-[10px] font-semibold leading-normal text-gray-600"
                                                            v-pre
                                                        >
                                                            {{ $currentLocale->name }}
                                                        </span>
                                                    @endif
                                                </x-admin::form.control-group.label>

                                                @include ('admin::catalog.products.edit.controls', [
                                                     'attribute' => $attribute,
                                                     'product'   => $product,
                                                 ])

                                                <x-admin::form.control-group.error :control-name="$attribute->code . (in_array($attribute->type, ['multiselect', 'checkbox']) ? '[]' : '')" />
                                            </x-admin::form.control-group>

                                            {!! view_render_event("bagisto.admin.catalog.product.edit.form.{$group->code}.controls.after", ['product' => $product]) !!}
                                        @endforeach

                                        @includeWhen($group->code == 'price', 'admin::catalog.products.edit.price.group')
                                    </div>

                                    {!! view_render_event("bagisto.admin.catalog.product.edit.form.{$group->code}.after", ['product' => $product]) !!}
                                @endif
                            @endforeach

                            <!-- Additional views if any -->
                            @foreach ($product->getTypeInstance()->getAdditionalViews() as $view)
                                @includeIf($view)
                            @endforeach
                        </div>

                        <!-- Right: Sidebar Cards (Status, Settings, Channels, Categories) -->
                        <div class="flex w-[360px] max-w-full flex-col gap-4 max-sm:w-full">
                            <!-- Settings Group (Status, Visibility, Featured, New) -->
                            @if ($settingsGroup = $product->attribute_family->attribute_groups->firstWhere('code', 'settings'))
                                @php $settingsAttributes = $product->getEditableAttributes($settingsGroup); @endphp
                                @if ($settingsAttributes->isNotEmpty())
                                    <div class="box-shadow relative rounded-2xl bg-white p-5 border border-slate-200" id="section-settings">
                                        <p class="mb-4 text-base font-bold text-gray-800" v-pre>
                                            {{ $settingsGroup->name }}
                                        </p>

                                        @foreach ($settingsAttributes as $attribute)
                                            <x-admin::form.control-group class="last:!mb-0">
                                                <x-admin::form.control-group.label>
                                                    {!! e($attribute->admin_name) . ($attribute->is_required ? '<span class="required"></span>' : '') !!}
                                                </x-admin::form.control-group.label>

                                                @include ('admin::catalog.products.edit.controls', [
                                                     'attribute' => $attribute,
                                                     'product'   => $product,
                                                 ])

                                                <x-admin::form.control-group.error :control-name="$attribute->code . (in_array($attribute->type, ['multiselect', 'checkbox']) ? '[]' : '')" />
                                            </x-admin::form.control-group>
                                        @endforeach
                                    </div>
                                @endif
                            @endif

                            <!-- Channels View Blade File -->
                            @include('admin::catalog.products.edit.channels')

                            <!-- Categories View Blade File -->
                            @include('admin::catalog.products.edit.categories')
                        </div>
                    </div>
                </div>

                @if ($product->type === 'configurable')
                    <!-- TAB 2: Variations & Stock (Full Width Workspace) -->
                    <div v-show="activeTab === 'variations' || activeTab === 'all'" class="w-full">
                        @includeIf('admin::catalog.products.edit.types.' . $product->type)
                    </div>
                @endif

                @if ($product->type !== 'configurable')
                    <!-- TAB: Inventory & Pricing (Simple Products) -->
                    <div v-show="activeTab === 'inventory' || activeTab === 'all'" class="w-full">
                        <div class="flex flex-col gap-4">
                            @if ($inventoryGroup = $product->attribute_family->attribute_groups->firstWhere('code', 'inventories'))
                                @php $invAttributes = $product->getEditableAttributes($inventoryGroup); @endphp
                                <div class="box-shadow relative rounded-2xl bg-white p-5 border border-slate-200">
                                    <p class="mb-4 text-base font-bold text-gray-800" v-pre>
                                        {{ $inventoryGroup->name }}
                                    </p>

                                    @foreach ($invAttributes as $attribute)
                                        <x-admin::form.control-group class="last:!mb-0">
                                            <x-admin::form.control-group.label>
                                                {!! e($attribute->admin_name) . ($attribute->is_required ? '<span class="required"></span>' : '') !!}
                                            </x-admin::form.control-group.label>

                                            @include ('admin::catalog.products.edit.controls', [
                                                 'attribute' => $attribute,
                                                 'product'   => $product,
                                             ])

                                            <x-admin::form.control-group.error :control-name="$attribute->code" />
                                        </x-admin::form.control-group>
                                    @endforeach

                                    @include('admin::catalog.products.edit.inventories')
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- TAB: Media Gallery -->
                <div v-show="activeTab === 'media' || activeTab === 'all'" class="w-full">
                    <div class="flex flex-col gap-4">
                        <!-- Images View Blade File -->
                        <div id="section-images">
                            @include('admin::catalog.products.edit.images')
                        </div>

                        <!-- Videos View Blade File -->
                        @include('admin::catalog.products.edit.videos')
                    </div>
                </div>

                <!-- TAB: Linked Products -->
                <div v-show="activeTab === 'links' || activeTab === 'all'" class="w-full">
                    <div id="section-links">
                        @include('admin::catalog.products.edit.links')
                    </div>
                </div>

                <!-- TAB: SEO & Search -->
                <div v-show="activeTab === 'seo' || activeTab === 'all'" class="w-full">
                    @if ($metaGroup = $product->attribute_family->attribute_groups->firstWhere('code', 'meta_description'))
                        @php $metaAttributes = $product->getEditableAttributes($metaGroup); @endphp

                        <div class="box-shadow relative rounded-2xl bg-white p-5 border border-slate-200" id="section-seo">
                            <p class="mb-4 text-base font-bold text-gray-800" v-pre>
                                Search Engine Optimization (SEO)
                            </p>

                            <x-admin::seo />

                            @foreach ($metaAttributes as $attribute)
                                <x-admin::form.control-group class="last:!mb-0">
                                    <x-admin::form.control-group.label>
                                        {!! e($attribute->admin_name) . ($attribute->is_required ? '<span class="required"></span>' : '') !!}
                                    </x-admin::form.control-group.label>

                                    @include ('admin::catalog.products.edit.controls', [
                                         'attribute' => $attribute,
                                         'product'   => $product,
                                     ])

                                    <x-admin::form.control-group.error :control-name="$attribute->code . (in_array($attribute->type, ['multiselect', 'checkbox']) ? '[]' : '')" />
                                </x-admin::form.control-group>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {!! view_render_event('bagisto.admin.catalog.product.edit.form.after', ['product' => $product]) !!}
        </v-product-edit-workspace>
    </x-admin::form>

    {!! view_render_event('bagisto.admin.catalog.product.edit.after', ['product' => $product]) !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-product-edit-workspace-template"
        >
            <div>
                <slot
                    :active-tab="activeTab"
                    :set-tab="setTab"
                    :product-type="productType"
                ></slot>
            </div>
        </script>

        <script type="module">
            app.component('v-product-edit-workspace', {
                template: '#v-product-edit-workspace-template',

                props: {
                    defaultTab: {
                        type: String,
                        default: 'general'
                    },
                    productType: {
                        type: String,
                        default: 'simple'
                    },
                    variantCount: {
                        type: Number,
                        default: 0
                    }
                },

                data() {
                    return {
                        activeTab: this.defaultTab,
                    };
                },

                mounted() {
                    const hash = window.location.hash.replace('#', '');
                    const validTabs = ['variations', 'general', 'inventory', 'media', 'links', 'seo', 'all'];

                    if (validTabs.includes(hash)) {
                        this.activeTab = hash;
                    }
                },

                methods: {
                    setTab(tab) {
                        this.activeTab = tab;

                        if (history.replaceState) {
                            history.replaceState(null, null, '#' + tab);
                        }
                    }
                }
            });
        </script>
    @endPushOnce
</x-admin::layouts>
