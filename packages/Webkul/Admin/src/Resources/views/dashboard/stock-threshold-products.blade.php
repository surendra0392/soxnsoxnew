<!-- Stock Threshold Products Vue Component -->
<v-dashboard-stock-threshold-products>
    <!-- Shimmer -->
    <x-admin::shimmer.dashboard.stock-threshold-products />
</v-dashboard-stock-threshold-products>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dashboard-stock-threshold-products-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.dashboard.stock-threshold-products />
        </template>

        <!-- Total Sales Section -->
        <template v-else>
            <!-- Stock Threshold Products Details -->
            <div
                class="rounded-[14px] bg-white border border-slate-200 shadow-sm overflow-hidden"
                v-if="report.statistics.length"
            >
                <!-- Single Product -->
                <div
                    class="border-b border-slate-100 last:border-b-0 p-4 transition-all hover:bg-slate-50/80"
                    v-for="product in report.statistics"
                >
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5 min-w-[200px] flex-1">
                            <template v-if="product.image">
                                <img
                                    class="h-12 w-12 rounded-[10px] object-cover border border-slate-200 flex-shrink-0"
                                    :src="product.image"
                                >
                            </template>

                            <template v-else>
                                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-[10px] border border-slate-200 bg-slate-100">
                                    <span class="icon-product text-xl text-slate-400"></span>
                                </div>
                            </template>

                            <div class="flex flex-col gap-1 min-w-0">
                                <!-- Product Name -->
                                <p class="text-sm font-semibold text-slate-900 truncate">
                                    @{{ product.name }}
                                </p>

                                <!-- Product SKU -->
                                <p class="text-xs font-mono text-slate-500">
                                    @{{ "@lang('admin::app.dashboard.index.sku', ['sku' => ':replace'])".replace(':replace', product.sku) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="flex flex-col items-end gap-1">
                                <!-- Product Price -->
                                <p class="text-sm font-bold font-mono text-slate-900">
                                    @{{ product.formatted_price }}
                                </p>

                                <!-- Total Product Stock -->
                                <span
                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold font-mono border"
                                    :class="[product.total_qty > {{ core()->getConfigData('catalog.inventory.stock_options.out_of_stock_threshold') ?? 0 }} ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200']"
                                >
                                    @{{ "@lang('admin::app.dashboard.index.total-stock', ['total_stock' => ':replace'])".replace(':replace', product.total_qty) }}
                                </span>
                            </div>

                            <!-- View More Icon -->
                            <a
                                :href="'{{ route('admin.catalog.products.edit', ':replace') }}'.replace(':replace', product.id)"
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 border border-slate-200 text-[#133b63] hover:bg-[#133b63] hover:text-white transition-all"
                            >
                                <span class="icon-sort-right rtl:icon-sort-left text-lg"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Product Design -->
            <div
                class="rounded-[14px] bg-white border border-slate-200 p-8 text-center"
                v-else
            >
                <div class="grid justify-center justify-items-center gap-2 py-4">
                    <span class="icon-product text-3xl text-slate-400"></span>
                    
                    <p class="text-sm font-semibold text-slate-500">
                        @lang('admin::app.dashboard.index.empty-threshold')
                    </p>

                    <p class="text-xs text-slate-400">
                        @lang('admin::app.dashboard.index.empty-threshold-description')
                    </p>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-dashboard-stock-threshold-products', {
            template: '#v-dashboard-stock-threshold-products-template',

            data() {
                return {
                    report: [],

                    isLoading: true,
                }
            },

            mounted() {
                this.getStats({});

                this.$emitter.on('reporting-filter-updated', this.getStats);
            },

            methods: {
                getStats(filters) {
                    this.isLoading = true;

                    var filters = Object.assign({}, filters);

                    filters.type = 'stock-threshold-products';

                    this.$axios.get("{{ route('admin.dashboard.stats') }}", {
                            params: filters
                        })
                        .then(response => {
                            this.report = response.data;

                            this.isLoading = false;
                        })
                        .catch(error => {});
                }
            }
        });
    </script>
@endPushOnce