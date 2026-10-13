<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.reporting.products.index.title')
    </x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                @lang('admin::app.reporting.products.index.title')
            </h1>
            <p class="mt-0.5 text-xs text-slate-500">
                Analyze product velocities, wishlist activity, top-selling items, and search trends.
            </p>
        </div>

        <!-- Actions -->
        <v-reporting-filters>
            <!-- Shimmer -->
            <div class="flex gap-2">
                <div class="shimmer h-[38px] w-[132px] rounded-[10px]"></div>
                <div class="shimmer h-[38px] w-[140px] rounded-[10px]"></div>
                <div class="shimmer h-[38px] w-[140px] rounded-[10px]"></div>
            </div>
        </v-reporting-filters>
    </div>

    <!-- Products Stats Vue Component -->
    <div class="flex flex-1 flex-col gap-4 max-xl:flex-auto">
        <!-- Total Sold Quantities and Products Added to Wishlist Sections Container -->
        <div class="flex flex-col justify-between gap-4 flex-1 [&>*]:flex-1 md:flex-row">
            <!-- Total Sold Quantities Section -->
            @include('admin::reporting.products.sold-quantities')

            <!-- Products Added to Wishlist Section -->
            @include('admin::reporting.products.wishlist-products')
        </div>

        <!-- Top Selling Products By Revenue and Top Selling Products By Quantity Sections Container -->
        <div class="flex flex-col justify-between gap-4 flex-1 [&>*]:flex-1 md:flex-row">
            <!-- Top Selling Products By Revenue Section -->
            @include('admin::reporting.products.top-selling-by-revenue')

            <!-- Top Selling Products By Quantity Section -->
            @include('admin::reporting.products.top-selling-by-quantity')
        </div>

        <!-- Products With Most Reviews Section -->
        <div class="flex flex-col justify-between gap-4 flex-1 [&>*]:flex-1 md:flex-row">
            <!-- Products With Most Reviews Section -->
            @include('admin::reporting.products.most-reviews')
        </div>

        <!-- Last Search Terms and Top Search Terms Sections Container -->
        <div class="flex flex-col justify-between gap-4 flex-1 [&>*]:flex-1 md:flex-row">
            <!-- Last Search Terms Section -->
            @include('admin::reporting.products.last-search-terms')

            <!-- Top Search Terms Section -->
            @include('admin::reporting.products.top-search-terms')
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
            id="v-reporting-filters-template"
        >
            <div class="flex items-center gap-2">
                <template v-if="channels.length > 2">
                    <x-admin::dropdown position="bottom-right">
                        <x-slot:toggle>
                            <button
                                type="button"
                                class="inline-flex w-full cursor-pointer appearance-none items-center justify-between gap-x-2 rounded-[10px] border border-slate-200 bg-white px-3 py-2 text-center text-xs font-semibold text-slate-700 shadow-xs hover:bg-slate-50 focus:border-[#133b63]"
                            >
                                @{{ channels.find(channel => channel.code == filters.channel).name }}
                                
                                <span class="icon-sort-down text-base text-slate-400"></span>
                            </button>
                        </x-slot>

                        <x-slot:menu class="!p-1.5 !rounded-xl !border !border-slate-200 !bg-white shadow-xl">
                            <x-admin::dropdown.menu.item
                                v-for="channel in channels"
                                ::class="{'!bg-[#133b63]/10 !text-[#133b63] !font-semibold': channel.code == filters.channel}"
                                class="!rounded-lg text-xs font-medium text-slate-700 hover:!text-slate-900 hover:!bg-slate-100"
                                @click="filters.channel = channel.code"
                            >
                                @{{ channel.name }}
                            </x-admin::dropdown.menu.item>
                        </x-slot>
                    </x-admin::dropdown>
                </template>

                <x-admin::flat-picker.date class="!w-[140px]" ::allow-input="false">
                    <input
                        class="flex min-h-[38px] w-full rounded-[10px] border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800 shadow-xs transition-all hover:border-slate-300 focus:border-[#133b63] focus:ring-2 focus:ring-[#133b63]/20"
                        v-model="filters.start"
                        placeholder="@lang('admin::app.reporting.products.index.start-date')"
                    />
                </x-admin::flat-picker.date>

                <x-admin::flat-picker.date class="!w-[140px]" ::allow-input="false">
                    <input
                        class="flex min-h-[38px] w-full rounded-[10px] border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800 shadow-xs transition-all hover:border-slate-300 focus:border-[#133b63] focus:ring-2 focus:ring-[#133b63]/20"
                        v-model="filters.end"
                        placeholder="@lang('admin::app.reporting.products.index.end-date')"
                    />
                </x-admin::flat-picker.date>
            </div>
        </script>

        <script type="module">
            app.component('v-reporting-filters', {
                template: '#v-reporting-filters-template',

                data() {
                    return {
                        channels: [
                            {
                                name: "@lang('admin::app.reporting.products.index.all-channels')",
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
