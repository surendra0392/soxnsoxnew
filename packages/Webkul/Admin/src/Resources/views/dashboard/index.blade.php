<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.dashboard.index.title')
    </x-slot>

    <!-- User Details Section -->
    <div class="flex items-center justify-between gap-4 mb-6 max-sm:flex-wrap">
        <div class="grid gap-1">
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl font-bold !leading-tight text-slate-900 font-heading" v-pre>
                    @lang('admin::app.dashboard.index.user-name', ['user_name' => auth()->guard('admin')->user()->name])
                </h1>
                <span class="inline-flex items-center gap-1 rounded-full bg-[#133b63]/10 px-2.5 py-0.5 text-xs font-semibold text-[#133b63] border border-[#133b63]/20 font-mono">
                    Overview
                </span>
            </div>

            <p class="!leading-normal text-sm text-slate-600">
                @lang('admin::app.dashboard.index.user-info')
            </p>
        </div>

        <!-- Actions -->
        <v-dashboard-filters>
            <!-- Shimmer -->
            <div class="flex gap-2">
                <div class="shimmer h-[40px] w-[132px] rounded-[12px]"></div>
                <div class="shimmer h-[40px] w-[155px] rounded-[12px]"></div>
                <div class="shimmer h-[40px] w-[155px] rounded-[12px]"></div>
            </div>
        </v-dashboard-filters>
    </div>

    <!-- Body Component -->
    <div class="mt-4 flex gap-6 max-xl:flex-wrap">
        <!-- Left Section -->
        <div class="flex flex-col flex-1 gap-6 max-xl:flex-auto">
            {!! view_render_event('bagisto.admin.dashboard.overall_details.before') !!}

            <!-- Overall Details -->
            <div class="flex flex-col gap-2.5">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 font-mono">
                    @lang('admin::app.dashboard.index.overall-details')
                </p>

                <!-- Over All Details Section -->
                @include('admin::dashboard.over-all-details')
            </div>

            {!! view_render_event('bagisto.admin.dashboard.overall_details.after') !!}

            {!! view_render_event('bagisto.admin.dashboard.todays_details.before') !!}

            <!-- Todays Details -->
            <div class="flex flex-col gap-2.5">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 font-mono">
                    @lang('admin::app.dashboard.index.today-details')
                </p>

                <!-- Todays Details Section -->
                @include('admin::dashboard.todays-details')
            </div>

            {!! view_render_event('bagisto.admin.dashboard.todays_details.after') !!}

            {!! view_render_event('bagisto.admin.dashboard.stock_threshold.before') !!}

            <!-- Stock Threshold -->
            <div class="flex flex-col gap-2.5">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 font-mono">
                    @lang('admin::app.dashboard.index.stock-threshold')
                </p>

                <!-- Products List -->  
                @include('admin::dashboard.stock-threshold-products')
            </div>
            
            {!! view_render_event('bagisto.admin.dashboard.stock_threshold.after') !!}
        </div>

        <!-- Right Section -->
        <div class="flex w-[380px] max-w-full flex-col gap-2.5 max-sm:w-full">
            <!-- First Component -->
            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 font-mono">
                @lang('admin::app.dashboard.index.store-stats')
            </p>

            {!! view_render_event('bagisto.admin.dashboard.store_stats.before') !!}

            <!-- Store Stats -->
            <div class="rounded-[14px] bg-white border border-slate-200 shadow-sm overflow-hidden">
                <!-- Total Sales Details -->
                @include('admin::dashboard.total-sales')

                <!-- Top Selling Products -->
                @include('admin::dashboard.top-selling-products')

                <!-- Top Customers -->
                @include('admin::dashboard.top-customers')
            </div>

            {!! view_render_event('bagisto.admin.dashboard.store_stats.after') !!}
        </div>
    </div>
    
    @pushOnce('scripts')
        <script
            type="module"
            src="{{ bagisto_asset('js/chart.js') }}"
        >
        </script>

        <script
            type="text/x-template"
            id="v-dashboard-filters-template"
        >
            <div class="flex items-center gap-2">
                <template v-if="channels.length > 2">
                    <x-admin::dropdown position="bottom-right">
                        <x-slot:toggle>
                            <button
                                type="button"
                                class="inline-flex w-full cursor-pointer appearance-none items-center justify-between gap-x-2 rounded-[12px] border border-slate-200 bg-white px-3.5 py-2 text-center text-sm leading-6 text-slate-800 transition-all hover:border-slate-300 focus:border-[#133b63]"
                            >
                                @{{ channels.find(channel => channel.code == filters.channel).name }}
                                
                                <span class="text-xl icon-sort-down text-slate-500"></span>
                            </button>
                        </x-slot>

                        <x-slot:menu class="!p-1.5 !bg-white !border !border-slate-200 !rounded-[14px] shadow-xl">
                            <x-admin::dropdown.menu.item
                                v-for="channel in channels"
                                ::class="{'!bg-[#133b63]/10 !text-[#133b63] !font-semibold': channel.code == filters.channel}"
                                class="!rounded-lg text-sm text-slate-700 hover:!text-slate-900 hover:!bg-slate-100"
                                @click="filters.channel = channel.code"
                            >
                                @{{ channel.name }}
                            </x-admin::dropdown.menu.item>
                        </x-slot>
                    </x-admin::dropdown>
                </template>

                <x-admin::flat-picker.date class="!w-[155px]" ::allow-input="false">
                    <input
                        class="flex min-h-[40px] w-full rounded-[12px] border border-slate-200 bg-white !pl-3.5 !pr-9 rtl:!pr-3.5 rtl:!pl-9 py-2 text-xs sm:text-sm font-medium text-slate-800 transition-all hover:border-slate-300 focus:border-[#133b63]"
                        v-model="filters.start"
                        placeholder="@lang('admin::app.dashboard.index.start-date')"
                    />
                </x-admin::flat-picker.date>

                <x-admin::flat-picker.date class="!w-[155px]" ::allow-input="false">
                    <input
                        class="flex min-h-[40px] w-full rounded-[12px] border border-slate-200 bg-white !pl-3.5 !pr-9 rtl:!pr-3.5 rtl:!pl-9 py-2 text-xs sm:text-sm font-medium text-slate-800 transition-all hover:border-slate-300 focus:border-[#133b63]"
                        v-model="filters.end"
                        placeholder="@lang('admin::app.dashboard.index.end-date')"
                    />
                </x-admin::flat-picker.date>
            </div>
        </script>

        <script type="module">
            app.component('v-dashboard-filters', {
                template: '#v-dashboard-filters-template',

                data() {
                    return {
                        channels: [
                            {
                                name: "@lang('admin::app.dashboard.index.all-channels')",
                                code: ''
                            },
                            ...@json(core()->getAllChannels()),
                        ],
                        
                        filters: {
                            channel: '',

                            start: "{{ $startDate->format('Y-m-d') }}",
                            
                            end: "{{ $endDate->format('Y-m-d') }}",
                        }
                    }
                },

                watch: {
                    filters: {
                        handler() {
                            this.$emitter.emit('reporting-filter-updated', this.filters);
                        },

                        deep: true
                    }
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
