<!-- Todays Details Vue Component -->
<v-dashboard-todays-details>
    <!-- Shimmer -->
    <x-admin::shimmer.dashboard.todays-details />
</v-dashboard-todays-details>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dashboard-todays-details-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.dashboard.todays-details />
        </template>

        <!-- Total Sales Section -->
        <template v-else>
            <div class="flex flex-col gap-3.5">
                <!-- Summary 3-Bento Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <!-- Today's Sales -->
                    <div class="relative overflow-hidden rounded-[14px] bg-white border border-slate-200 p-4 flex flex-col justify-between hover:border-slate-300 transition-all shadow-sm group">
                        <div class="absolute -top-6 -right-6 h-20 w-20 rounded-full bg-[#2ca7a3]/5 blur-xl group-hover:bg-[#2ca7a3]/10 transition-all pointer-events-none"></div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                @lang('admin::app.dashboard.index.today-sales')
                            </span>

                            <div class="flex h-9 w-9 items-center justify-center rounded-[12px] bg-[#133b63]/5 border border-[#133b63]/10 p-2 text-[#133b63]">
                                <span class="icon-sales text-xl"></span>
                            </div>
                        </div>

                        <div class="flex items-baseline justify-between gap-2 mt-auto">
                            <p class="text-xl sm:text-2xl font-bold text-slate-900 font-mono tracking-tight">
                                @{{ report.statistics.total_sales.formatted_total }}
                            </p>

                            <!-- Percentage Of Sales -->
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

                    <!-- Today's Orders -->
                    <div class="relative overflow-hidden rounded-[14px] bg-white border border-slate-200 p-4 flex flex-col justify-between hover:border-slate-300 transition-all shadow-sm group">
                        <div class="absolute -top-6 -right-6 h-20 w-20 rounded-full bg-[#2ca7a3]/5 blur-xl group-hover:bg-[#2ca7a3]/10 transition-all pointer-events-none"></div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                @lang('admin::app.dashboard.index.today-orders')
                            </span>

                            <div class="flex h-9 w-9 items-center justify-center rounded-[12px] bg-[#133b63]/5 border border-[#133b63]/10 p-2 text-[#133b63]">
                                <span class="icon-cart text-xl"></span>
                            </div>
                        </div>

                        <div class="flex items-baseline justify-between gap-2 mt-auto">
                            <p class="text-xl sm:text-2xl font-bold text-slate-900 font-mono tracking-tight">
                                @{{ report.statistics.total_orders.current }}
                            </p>

                            <!-- Orders Percentage -->
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

                    <!-- Today's Customers -->
                    <div class="relative overflow-hidden rounded-[14px] bg-white border border-slate-200 p-4 flex flex-col justify-between hover:border-slate-300 transition-all shadow-sm group">
                        <div class="absolute -top-6 -right-6 h-20 w-20 rounded-full bg-[#2ca7a3]/5 blur-xl group-hover:bg-[#2ca7a3]/10 transition-all pointer-events-none"></div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                @lang('admin::app.dashboard.index.today-customers')
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
                </div>

                <!-- Today Orders Feed Container -->
                <div
                    v-if="report.statistics.orders && report.statistics.orders.length"
                    class="rounded-[14px] bg-white border border-slate-200 shadow-sm overflow-hidden"
                >
                    <div 
                        v-for="order in report.statistics.orders"
                        class="border-b border-slate-100 last:border-b-0 p-4 transition-all hover:bg-slate-50/80"
                    >
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <!-- Order Info -->
                            <div class="flex min-w-[160px] flex-col gap-1">
                                <p class="text-sm font-bold text-slate-900 font-mono">
                                    @{{ "@lang('admin::app.dashboard.index.order-id', ['id' => ':replace'])".replace(':replace', order.increment_id) }}
                                </p>
        
                                <p class="text-xs text-slate-500 font-mono">
                                    @{{ order.created_at }}
                                </p>
        
                                <div>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold font-mono bg-slate-100 text-slate-700 border border-slate-200">
                                        @{{ order.status_label }}
                                    </span>
                                </div>
                            </div>

                            <!-- Financial Details -->
                            <div class="flex min-w-[140px] flex-col gap-1">
                                <p class="text-base font-bold text-[#133b63] font-mono">
                                    @{{ order.formatted_base_grand_total }}
                                </p>
            
                                <p class="text-xs text-slate-600">
                                    @{{ order.payment_method }}
                                </p>
            
                                <p class="text-xs text-slate-400">
                                    @{{ order.channel_name }}
                                </p>
                            </div>

                            <!-- Customer Info -->
                            <div class="flex min-w-[180px] flex-1 flex-col gap-1">
                                <p class="text-sm font-semibold text-slate-900">
                                    @{{ order.customer_name }}
                                </p>
            
                                <p class="text-xs text-slate-500 truncate max-w-[200px]">
                                    @{{ order.customer_email }}
                                </p>
            
                                <p class="text-xs text-slate-400 truncate max-w-[240px]">
                                    @{{ order.billing_address }}
                                </p>
                            </div>
     
                            <!-- Ordered Product Images & Action -->
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex flex-wrap gap-1.5"
                                    v-html="order.items"
                                >
                                </div>

                                <a
                                    :href="'{{ route('admin.sales.orders.view', ':replace') }}'.replace(':replace', order.id)"
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 border border-slate-200 text-[#133b63] hover:bg-[#133b63] hover:text-white transition-all"
                                >
                                    <span class="icon-sort-right rtl:icon-sort-left text-lg"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-dashboard-todays-details', {
            template: '#v-dashboard-todays-details-template',

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

                    filters.type = 'today';

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