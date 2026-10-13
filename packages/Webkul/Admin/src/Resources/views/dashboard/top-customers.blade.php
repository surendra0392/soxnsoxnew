<!-- Top Selling Products Vue Component -->
<v-dashboard-top-customers>
    <!-- Shimmer -->
    <x-admin::shimmer.dashboard.top-customers />
</v-dashboard-top-customers>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-dashboard-top-customers-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <x-admin::shimmer.dashboard.top-customers />
        </template>

        <!-- Total Sales Section -->
        <template v-else>
            <div>
                <div class="flex items-center justify-between p-4 border-b border-slate-200 bg-slate-50">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        @lang('admin::app.dashboard.index.customer-with-most-sales')
                    </span>

                    <span class="text-[11px] font-mono text-slate-400">
                        @{{ report.date_range }}
                    </span>
                </div>

                <div
                    class="flex flex-col"
                    v-if="report.statistics.length"
                >
                    <a
                        :href="customer.id ? '{{ route('admin.customers.customers.view', ':id') }}'.replace(':id', customer.id) : '#'"
                        class="flex items-center justify-between gap-3 border-b border-slate-100 p-3.5 transition-all last:border-b-0 hover:bg-slate-50/80"
                        v-for="customer in report.statistics"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            <!-- Profile avatar or placeholder icon -->
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full ring-1 ring-slate-200 overflow-hidden shadow-2xs">
                                <img
                                    :src="customer.avatar_url || customer.image_url || getSoxnsoxAvatar(customer.full_name, 36)"
                                    class="h-full w-full object-cover"
                                    :alt="customer.full_name"
                                />
                            </div>

                            <div class="flex flex-col min-w-0">
                                <p class="text-xs font-semibold text-slate-900 truncate">
                                    @{{ customer.full_name }}
                                </p>

                                <p class="text-[11px] text-slate-500 truncate">
                                    @{{ customer.email }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col items-end flex-shrink-0">
                            <p class="text-xs font-bold font-mono text-[#133b63]">
                                @{{ customer.formatted_total }}
                            </p>

                            <p class="text-[11px] font-mono text-slate-400" v-if="customer.orders">
                                @{{ "@lang('admin::app.dashboard.index.order-count')".replace(':count', customer.orders) }}
                            </p>
                        </div>
                    </a>
                </div>

                <div
                    class="flex flex-col gap-8 p-6 text-center"
                    v-else
                >
                    <div class="grid justify-center justify-items-center gap-2 py-4">
                        <span class="icon-customer text-3xl text-slate-400"></span>

                        <p class="text-xs font-semibold text-slate-500">
                            @lang('admin::app.dashboard.index.add-customer')
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-dashboard-top-customers', {
            template: '#v-dashboard-top-customers-template',

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

                    filters.type = 'top-customers';

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