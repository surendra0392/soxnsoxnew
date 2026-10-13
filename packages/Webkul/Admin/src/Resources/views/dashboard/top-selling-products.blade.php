<!-- Top Selling Products Vue Component -->
<v-dashboard-top-selling-products>
    <!-- Shimmer -->
    <x-admin::shimmer.dashboard.top-selling-products />
</v-dashboard-top-selling-products>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dashboard-top-selling-products-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.dashboard.top-selling-products />
        </template>

        <!-- Total Sales Section -->
        <template v-else>
            <div class="border-b border-slate-200">
                <div class="flex items-center justify-between p-4 border-b border-slate-200 bg-slate-50">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        @lang('admin::app.dashboard.index.top-selling-products')
                    </span>

                    <span class="text-[11px] font-mono text-slate-400">
                        @{{ report.date_range }}
                    </span>
                </div>

                <!-- Top Selling Products Details -->
                <div
                    class="flex flex-col"
                    v-if="report.statistics.length"
                >
                    <a
                        :href="'{{ route('admin.catalog.products.edit', ':id') }}'.replace(':id', item.id)"
                        class="flex items-center gap-3 border-b border-slate-100 p-3.5 transition-all last:border-b-0 hover:bg-slate-50/80"
                        v-for="item in report.statistics"
                    >
                        <!-- Product Item -->
                        <img
                            v-if="item.images?.length"
                            class="relative h-12 w-12 flex-shrink-0 overflow-hidden rounded-[10px] border border-slate-200 object-cover"
                            :src="item.images[0]?.url"
                        />

                        <div
                            v-else
                            class="relative flex h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-[10px] border border-slate-200 bg-slate-100"
                        >
                            <span class="icon-product text-xl text-slate-400"></span>
                        </div>

                        <!-- Product Details -->
                        <div class="flex w-full min-w-0 flex-col gap-1">
                            <p
                                class="text-xs font-semibold text-slate-900 truncate"
                                v-text="item.name"
                            >
                            </p>

                            <div class="flex items-center justify-between">
                                <p class="text-xs font-mono text-slate-500">
                                    @{{ item.formatted_price }}
                                </p>

                                <p class="text-xs font-bold font-mono text-[#133b63]">
                                    @{{ item.formatted_revenue }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Empty Product Design -->
                <div
                    class="flex flex-col gap-8 p-6 text-center"
                    v-else
                >
                    <div class="grid justify-center justify-items-center gap-2 py-4">
                        <span class="icon-product text-3xl text-slate-400"></span>

                        <p class="text-xs font-semibold text-slate-500">
                            @lang('admin::app.dashboard.index.add-product')
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-dashboard-top-selling-products', {
            template: '#v-dashboard-top-selling-products-template',

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

                    filters.type = 'top-selling-products';

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