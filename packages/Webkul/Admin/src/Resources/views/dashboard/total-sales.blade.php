<!-- Total Sales Vue Component -->
<v-dashboard-total-sales>
    <!-- Shimmer -->
    <x-admin::shimmer.dashboard.total-sales />
</v-dashboard-total-sales>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dashboard-total-sales-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.dashboard.total-sales />
        </template>

        <!-- Total Sales Section -->
        <template v-else>
            <div class="grid gap-4 border-b border-slate-200 p-5">
                <div class="flex justify-between items-start gap-2">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            @lang('admin::app.dashboard.index.total-sales')
                        </span>

                        <!-- Total Order Revenue -->
                        <p class="text-2xl font-bold leading-none text-slate-900 font-mono tracking-tight">
                            @{{ report.statistics.total_sales.formatted_total }}
                        </p>
                    </div>

                    <div class="flex flex-col items-end gap-1">
                        <!-- Orders Time Duration -->
                        <span class="text-right text-[11px] font-mono text-slate-400">
                            @{{ report.date_range }}
                        </span>

                        <!-- Total Orders -->
                        <span class="inline-flex items-center rounded-full bg-[#133b63]/10 px-2 py-0.5 text-xs font-semibold text-[#133b63] font-mono border border-[#133b63]/20">
                            @{{ "@lang('admin::app.dashboard.index.order')".replace(':total_orders', report.statistics.total_orders.current ?? 0) }}
                        </span>
                    </div>
                </div>

                <!-- Bar Chart -->
                <x-admin::charts.bar
                    ::labels="chartLabels"
                    ::datasets="chartDatasets"
                    ::aspect-ratio="1.41"
                />
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-dashboard-total-sales', {
            template: '#v-dashboard-total-sales-template',

            data() {
                return {
                    report: [],

                    isLoading: true,
                }
            },

            computed: {
                chartLabels() {
                    return this.report.statistics.over_time.map(({ label }) => label);
                },

                chartDatasets() {
                    return [{
                        data: this.report.statistics.over_time.map(({ total }) => total),
                        barThickness: 6,
                        backgroundColor: '#2ca7a3',
                        borderRadius: 3,
                    }];
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

                    filters.type = 'total-sales';

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