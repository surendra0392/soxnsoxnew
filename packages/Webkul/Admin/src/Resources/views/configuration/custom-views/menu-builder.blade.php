@php
    $categories = app(\Webkul\Category\Repositories\CategoryRepository::class)->getConfigOptions();
    $cmsPages = app(\Webkul\CMS\Repositories\PageRepository::class)->getConfigOptions();
    
    // Config values
    $nameField = $field->getNameField(); // e.g. general[design][categories][custom_menu_items]
    
    // Get current value
    $value = core()->getConfigData($field->getNameKey());
    if (!$value) {
        $value = '[]';
    }
@endphp

<v-menu-builder
    name-field="{{ $nameField }}"
    :categories-data="{{ json_encode($categories) }}"
    :cms-pages-data="{{ json_encode($cmsPages) }}"
    :initial-value="{{ json_encode($value) }}"
>
    <!-- Shimmer Loader -->
    <div class="shimmer mb-1.5 h-4 w-24"></div>
    <div class="shimmer flex h-[100px] w-full rounded-md"></div>
</v-menu-builder>

@pushOnce('scripts')
    <script type="text/x-template" id="v-menu-builder-template">
        <div>
            <!-- Hidden input that actually saves to core_config -->
            <input type="hidden" :name="nameField" :value="jsonValue">
            
            <div class="flex flex-col gap-4">
                <!-- Checkboxes and Inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Add CMS Pages -->
                    <div class="border rounded-md p-4">
                        <p class="font-semibold mb-3 text-gray-800">Add CMS Pages</p>
                        <div class="max-h-[150px] overflow-y-auto space-y-2 pr-2">
                            <label v-for="(page, index) in cmsPages" :key="'cms_' + page.value" class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" :value="{ type: 'cms', id: page.value, title: page.title }" v-model="pendingSelections.cms" class="rounded border-gray-300 text-[#133b63] focus:ring-[#133b63]/20">
                                <span class="text-sm text-gray-600">@{{ page.title }}</span>
                            </label>
                        </div>
                        <button type="button" @click="addPending('cms')" class="mt-3 px-3 py-1.5 bg-white border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-50 transition-colors">Add to Menu</button>
                    </div>

                    <!-- Add Categories -->
                    <div class="border rounded-md p-4">
                        <p class="font-semibold mb-3 text-gray-800">Add Categories</p>
                        <div class="max-h-[150px] overflow-y-auto space-y-2 pr-2">
                            <label v-for="(cat, index) in categories" :key="'cat_' + cat.value" class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" :value="{ type: 'category', id: cat.value, title: cat.title }" v-model="pendingSelections.category" class="rounded border-gray-300 text-[#133b63] focus:ring-[#133b63]/20">
                                <span class="text-sm text-gray-600" v-html="cat.title"></span>
                            </label>
                        </div>
                        <button type="button" @click="addPending('category')" class="mt-3 px-3 py-1.5 bg-white border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-50 transition-colors">Add to Menu</button>
                    </div>

                    <!-- Add Custom Link -->
                    <div class="border rounded-md p-4 md:col-span-2">
                        <p class="font-semibold mb-3 text-gray-800">Add Custom Link</p>
                        <div class="flex gap-4 items-end">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Title</label>
                                <input type="text" v-model="customLink.title" class="w-full px-3 py-2 border rounded-md focus:border-[#133b63] focus:ring-1 focus:ring-[#133b63]/20 text-sm">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">URL</label>
                                <input type="text" v-model="customLink.url" placeholder="https://" class="w-full px-3 py-2 border rounded-md focus:border-[#133b63] focus:ring-1 focus:ring-[#133b63]/20 text-sm">
                            </div>
                            <button type="button" @click="addCustomLink" class="px-4 py-2 bg-gray-800 text-white rounded text-sm hover:bg-gray-700 transition-colors">Add to Menu</button>
                        </div>
                    </div>
                </div>

                <!-- Menu Structure (Sortable List) -->
                <div class="border rounded-md p-4 bg-gray-50 mt-2">
                    <p class="font-semibold mb-3 text-gray-800">Menu Structure</p>
                    <p class="text-sm text-gray-500 mb-4">Arrange the items in the order you want them to appear in the header.</p>
                    
                    <div v-if="items.length === 0" class="p-6 border border-dashed rounded text-center text-gray-400">
                        No menu items added yet.
                    </div>
                    
                    <draggable v-model="items" item-key="uniqueId" handle=".drag-handle" class="space-y-2">
                        <template #item="{element, index}">
                            <div class="flex items-center gap-3 bg-white border rounded p-3 shadow-sm">
                                <span class="icon-drag drag-handle cursor-move text-gray-400 hover:text-gray-600 text-lg"></span>
                                
                                <div class="flex-1 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-sm text-gray-700" v-html="element.title"></span>
                                        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-500 text-xs uppercase" v-text="element.type"></span>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <span v-if="element.type === 'custom'" class="text-xs text-[#133b63] truncate max-w-[200px]">@{{ element.url }}</span>
                                        <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 p-1">
                                            <span class="icon-delete text-lg"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </draggable>
                </div>

            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-menu-builder', {
            template: '#v-menu-builder-template',

            props: {
                nameField: String,
                categoriesData: Object,
                cmsPagesData: Object,
                initialValue: String,
            },

            data() {
                // Ensure initialValue is a valid JSON array or default to empty array
                let parsedItems = [];
                try {
                    let parsedString = JSON.parse(this.initialValue);
                    if (typeof parsedString === 'string') {
                        parsedItems = JSON.parse(parsedString);
                    } else if (Array.isArray(parsedString)) {
                        parsedItems = parsedString;
                    }
                } catch (e) {
                    parsedItems = [];
                }
                
                // Add uniqueId for draggable
                parsedItems = parsedItems.map(item => {
                    item.uniqueId = Math.random().toString(36).substring(2, 9);
                    return item;
                });

                return {
                    items: parsedItems,
                    categories: this.categoriesData,
                    cmsPages: this.cmsPagesData,
                    
                    pendingSelections: {
                        cms: [],
                        category: []
                    },
                    
                    customLink: {
                        title: '',
                        url: ''
                    }
                };
            },

            computed: {
                jsonValue() {
                    // Remove uniqueId before saving
                    const cleanItems = this.items.map(item => {
                        const { uniqueId, ...cleanItem } = item;
                        return cleanItem;
                    });
                    return JSON.stringify(cleanItems);
                }
            },

            methods: {
                addPending(type) {
                    this.pendingSelections[type].forEach(item => {
                        this.items.push({
                            ...item,
                            uniqueId: Math.random().toString(36).substring(2, 9)
                        });
                    });
                    // Clear selections
                    this.pendingSelections[type] = [];
                },
                
                addCustomLink() {
                    if (this.customLink.title.trim() === '' || this.customLink.url.trim() === '') {
                        alert('Please provide both Title and URL for the custom link.');
                        return;
                    }
                    
                    this.items.push({
                        type: 'custom',
                        title: this.customLink.title,
                        url: this.customLink.url,
                        uniqueId: Math.random().toString(36).substring(2, 9)
                    });
                    
                    // Reset
                    this.customLink.title = '';
                    this.customLink.url = '';
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }
        });
    </script>
@endpushOnce
