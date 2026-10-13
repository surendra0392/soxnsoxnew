<!-- Over Details Vue Component -->
<v-dashboard-overall-details>
    <!-- Shimmer -->
    <x-admin::shimmer.dashboard.over-all-details />
</v-dashboard-overall-details>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dashboard-overall-details-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.dashboard.over-all-details />
        </template>

        <!-- Total Sales Section -->
        <template v-else>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3.5">
                <!-- Total Sales -->
                <div class="relative overflow-hidden rounded-[14px] bg-white border border-slate-200 p-4 flex flex-col justify-between hover:border-slate-300 transition-all shadow-sm group">
                    <div class="absolute -top-6 -right-6 h-20 w-20 rounded-full bg-[#2ca7a3]/5 blur-xl group-hover:bg-[#2ca7a3]/10 transition-all pointer-events-none"></div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            @lang('admin::app.dashboard.index.total-sales')
                        </span>

                        <div class="flex h-9 w-9 items-center justify-center rounded-[12px] bg-[#133b63]/5 border border-[#133b63]/10 p-2 text-[#133b63]">
                            <span class="icon-sales text-xl"></span>
                        </div>
                    </div>

                    <div class="flex items-baseline justify-between gap-2 mt-auto">
                        <p class="text-xl sm:text-2xl font-bold text-slate-900 font-mono tracking-tight">
                            @{{ report.statistics.total_sales.formatted_total }}
                        </p>

                        <!-- Sales Percentage -->
                        <div
                            class="inline-flex items-center gap-0.5 rounded-full px-2 py-0.5 text-xs font-semibold font-mono border"
                            :class="[report.statistics.total_sales.progress < 0 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200']"
                        >
                            <span
                                class="text-xs"
                                :class="[report.statistics.total_sales.progress < 0 ? 'icon-down-stat' : 'icon-up-stat']"
                            ></span>
                            <span>@{{ Math.abs(report.statistics.total_sales.progress.toFixed(2)) }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="relative overflow-hidden rounded-[14px] bg-white border border-slate-200 p-4 flex flex-col justify-between hover:border-slate-300 transition-all shadow-sm group">
                    <div class="absolute -top-6 -right-6 h-20 w-20 rounded-full bg-[#2ca7a3]/5 blur-xl group-hover:bg-[#2ca7a3]/10 transition-all pointer-events-none"></div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            @lang('admin::app.dashboard.index.total-orders')
                        </span>

                        <div class="flex h-9 w-9 items-center justify-center rounded-[12px] bg-[#133b63]/5 border border-[#133b63]/10 p-2 text-[#133b63]">
                            <span class="icon-cart text-xl"></span>
                        </div>
                    </div>

                    <div class="flex items-baseline justify-between gap-2 mt-auto">
                        <p class="text-xl sm:text-2xl font-bold text-slate-900 font-mono tracking-tight">
                            @{{ report.statistics.total_orders.current }}
                        </p>

                        <!-- Order Percentage -->
                        <div
                            class="inline-flex items-center gap-0.5 rounded-full px-2 py-0.5 text-xs font-semibold font-mono border"
                            :class="[report.statistics.total_orders.progress < 0 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200']"
                        >
                            <span
                                class="text-xs"
                                :class="[report.statistics.total_orders.progress < 0 ? 'icon-down-stat' : 'icon-up-stat']"
                            ></span>
                            <span>@{{ Math.abs(report.statistics.total_orders.progress.toFixed(2)) }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Total Customers -->
                <div class="relative overflow-hidden rounded-[14px] bg-white border border-slate-200 p-4 flex flex-col justify-between hover:border-slate-300 transition-all shadow-sm group">
                    <div class="absolute -top-6 -right-6 h-20 w-20 rounded-full bg-[#2ca7a3]/5 blur-xl group-hover:bg-[#2ca7a3]/10 transition-all pointer-events-none"></div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            @lang('admin::app.dashboard.index.total-customers')
                        </span>

                        <div class="flex h-9 w-9 items-center justify-center rounded-[12px] bg-[#133b63]/5 border border-[#133b63]/10 p-2 text-[#133b63]">
                            <span class="icon-customer text-xl"></span>
                        </div>
                    </div>

                    <div class="flex items-baseline justify-between gap-2 mt-auto">
                        <p class="text-xl sm:text-2xl font-bold text-slate-900 font-mono tracking-tight">
                            @{{ report.statistics.total_customers.current }}
                        </p>

                        <!-- Customers Percentage -->
                        <div
                            class="inline-flex items-center gap-0.5 rounded-full px-2 py-0.5 text-xs font-semibold font-mono border"
                            :class="[report.statistics.total_customers.progress < 0 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200']"
                        >
                            <span
                                class="text-xs"
                                :class="[report.statistics.total_customers.progress < 0 ? 'icon-down-stat' : 'icon-up-stat']"
                            ></span>
                            <span>@{{ Math.abs(report.statistics.total_customers.progress.toFixed(2)) }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Average sales -->
                <div class="relative overflow-hidden rounded-[14px] bg-white border border-slate-200 p-4 flex flex-col justify-between hover:border-slate-300 transition-all shadow-sm group">
                    <div class="absolute -top-6 -right-6 h-20 w-20 rounded-full bg-[#2ca7a3]/5 blur-xl group-hover:bg-[#2ca7a3]/10 transition-all pointer-events-none"></div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            @lang('admin::app.dashboard.index.average-sale')
                        </span>

                        <div class="flex h-9 w-9 items-center justify-center rounded-[12px] bg-[#133b63]/5 border border-[#133b63]/10 p-2 text-[#133b63]">
                            <span class="icon-report text-xl"></span>
                        </div>
                    </div>

                    <div class="flex items-baseline justify-between gap-2 mt-auto">
                        <p class="text-xl sm:text-2xl font-bold text-slate-900 font-mono tracking-tight">
                            @{{ report.statistics.avg_sales.formatted_total }}
                        </p>

                        <!-- Sales Percentage -->
                        <div
                            class="inline-flex items-center gap-0.5 rounded-full px-2 py-0.5 text-xs font-semibold font-mono border"
                            :class="[report.statistics.avg_sales.progress < 0 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200']"
                        >
                            <span
                                class="text-xs"
                                :class="[report.statistics.avg_sales.progress < 0 ? 'icon-down-stat' : 'icon-up-stat']"
                            ></span>
                            <span>@{{ Math.abs(report.statistics.avg_sales.progress).toFixed(2) }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Unpaid Invoices -->
                <div class="relative overflow-hidden rounded-[14px] bg-white border border-slate-200 p-4 flex flex-col justify-between hover:border-slate-300 transition-all shadow-sm group">
                    <div class="absolute -top-6 -right-6 h-20 w-20 rounded-full bg-[#E69223]/5 blur-xl group-hover:bg-[#E69223]/10 transition-all pointer-events-none"></div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            @lang('admin::app.dashboard.index.total-unpaid-invoices')
                        </span>

                        <div class="flex h-9 w-9 items-center justify-center rounded-[12px] bg-[#E69223]/10 border border-[#E69223]/20 p-2 text-[#E69223]">
                            <span class="icon-sales text-xl"></span>
                        </div>
                    </div>

                    <div class="flex items-baseline justify-between gap-2 mt-auto">
                        <p class="text-xl sm:text-2xl font-bold text-[#E69223] font-mono tracking-tight">
                            @{{ report.statistics.total_unpaid_invoices.formatted_total }}
                        </p>

                        <span class="text-xs font-semibold text-slate-400 font-mono">Pending</span>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-dashboard-overall-details', {
            template: '#v-dashboard-overall-details-template',

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

                    filters.type = 'over-all';

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