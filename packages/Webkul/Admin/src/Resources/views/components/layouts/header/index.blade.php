@php
    $admin = auth()->guard('admin')->user();
    $adminLogo = core()->getConfigData('general.design.admin_logo.logo_image');
    $adminLogoUrl = ($adminLogo && file_exists(public_path('storage/' . $adminLogo)))
        ? asset('storage/' . $adminLogo)
        : (file_exists(public_path('logo.png')) ? asset('logo.png') : ($adminLogo ? Storage::url($adminLogo) : null));
@endphp

<header class="sticky top-0 z-[10001] flex items-center justify-between border-b border-slate-200/80 bg-white/95 backdrop-blur-md px-3 py-2.5 sm:px-5 sm:py-3 shadow-sm">
    <div class="flex items-center gap-1.5 sm:gap-3">
        <!-- Hamburger Menu -->
        <i
            class="icon-menu cursor-pointer rounded-[12px] p-2 text-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all lg:hidden sm:text-2xl"
            @click="$refs.sidebarMenuDrawer.open()"
        >
        </i>

        <!-- Logo -->
        <a href="{{ route('admin.dashboard.index') }}" class="flex-shrink-0 flex items-center gap-2.5">
            @if ($adminLogoUrl)
                <img
                    class="h-8 w-auto sm:h-9 object-contain max-w-[180px]"
                    src="{{ $adminLogoUrl }}"
                    alt="{{ config('app.name') }}"
                />
            @else
                <img
                    src="{{ bagisto_asset('images/logo.svg') }}"
                    class="h-8 w-auto sm:h-9 object-contain"
                    id="logo-image"
                    alt="{{ config('app.name') }}"
                />
            @endif
        </a>

    </div>

    <div class="flex items-center gap-1.5 sm:gap-2.5">
        <!-- Mega Search Bar Vue Component -->
        <v-mega-search class="hidden sm:block">
            <div class="relative flex w-[220px] items-center sm:w-[320px] md:w-[420px] lg:w-[500px]">
                <i class="icon-search pointer-events-none absolute top-1/2 -translate-y-1/2 text-lg text-slate-400 ltr:left-3.5 rtl:right-3.5 sm:text-xl"></i>

                <input
                    type="text"
                    class="block w-full rounded-[12px] border border-slate-200 bg-slate-100 !pl-10 !pr-4 rtl:!pr-10 rtl:!pl-4 py-2 text-sm text-slate-900 placeholder:text-slate-400 transition-all hover:border-slate-300 focus:border-[#133b63] focus:ring-2 focus:ring-[#133b63]/20"
                    placeholder="@lang('admin::app.components.layouts.header.mega-search.title')"
                >
            </div>
        </v-mega-search>
        <!-- Visit Shop Link -->
        <a
            href="{{ route('shop.home.index') }}"
            target="_blank"
            class="hidden sm:flex"
        >
            <span
                class="icon-store cursor-pointer rounded-[12px] p-2 text-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all sm:text-2xl"
                title="@lang('admin::app.components.layouts.header.visit-shop')"
            >
            </span>
        </a>

       <!-- Notification Component -->
        <v-notifications {{ $attributes }}>
            <span class="relative flex">
                <span
                    class="icon-notification cursor-pointer rounded-[12px] p-2 text-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all sm:text-2xl"
                    title="@lang('admin::app.components.layouts.header.notifications')"
                >
                </span>
            </span>
        </v-notifications>

        <!-- Admin profile -->
        <x-admin::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
            <x-slot:toggle>
                <button
                    type="button"
                    class="flex h-9 w-9 cursor-pointer overflow-hidden rounded-full ring-2 ring-slate-200 hover:ring-[#133b63] transition-all focus:outline-none"
                    aria-label="{{ $admin->name }}"
                >
                    <img
                        src="{{ $admin->avatar_url }}"
                        alt="{{ $admin->name }}"
                        class="h-full w-full object-cover"
                    />
                </button>
            </x-slot>

            <!-- Admin Dropdown -->
            <x-slot:content class="!p-0 !bg-white !border !border-slate-200 !rounded-[14px] shadow-xl overflow-hidden">
                <div class="flex items-center gap-3 border-b border-slate-200 bg-slate-50 px-4 py-3">
                    <div class="h-10 w-10 shrink-0 overflow-hidden rounded-xl shadow-xs border border-slate-200/80">
                        <img
                            src="{{ $admin->avatar_url }}"
                            alt="{{ $admin->name }}"
                            class="h-full w-full object-cover"
                        />
                    </div>

                    <div>
                        <p class="text-sm font-bold text-slate-900">
                            {{ $admin->name }}
                        </p>
                        <p class="text-[11px] uppercase tracking-wider text-[#133b63] font-semibold font-mono">
                            Administrator
                        </p>
                    </div>
                </div>

                <div class="grid gap-1 p-2">
                    <a
                        class="cursor-pointer rounded-lg px-3 py-2 text-sm text-slate-700 hover:text-slate-900 hover:bg-slate-100 transition-all"
                        href="{{ route('admin.account.edit') }}"
                    >
                        @lang('admin::app.components.layouts.header.my-account')
                    </a>

                    <!--Admin logout-->
                    <x-admin::form
                        method="DELETE"
                        action="{{ route('admin.session.destroy') }}"
                        id="adminLogout"
                    >
                    </x-admin::form>

                    <a
                        class="cursor-pointer rounded-lg px-3 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 transition-all"
                        href="{{ route('admin.session.destroy') }}"
                        onclick="event.preventDefault(); document.getElementById('adminLogout').submit();"
                    >
                        @lang('admin::app.components.layouts.header.logout')
                    </a>
                </div>
            </x-slot>
        </x-admin::dropdown>
    </div>
</header>

<!-- Menu Sidebar Drawer -->
<x-admin::drawer
    position="left"
    width="270px"
    ref="sidebarMenuDrawer"
>
    <!-- Drawer Header -->
    <x-slot:header>
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.dashboard.index') }}">
                @if ($adminLogoUrl)
                    <img
                        class="h-8 w-auto sm:h-10 object-contain max-w-[180px]"
                        src="{{ $adminLogoUrl }}"
                        alt="{{ config('app.name') }}"
                    />
                @else
                    <img
                        src="{{ bagisto_asset('images/logo.png') }}"
                        class="h-8 w-auto sm:h-10"
                        id="logo-image"
                        alt="{{ config('app.name') }}"
                    />
                @endif
            </a>
        </div>
    </x-slot>

    <!-- Drawer Content -->
    <x-slot:content class="p-3 sm:p-4 bg-white">
        <div class="journal-scroll h-[calc(100vh-100px)] overflow-auto">
            <nav class="grid w-full gap-1.5 sm:gap-2">
                @foreach (menu()->getItems('admin') as $menuItem)
                    <div class="group/item relative">
                        <a
                            href="{{ $menuItem->getUrl() }}"
                            class="flex items-center gap-2.5 p-2.5 rounded-[12px] cursor-pointer transition-all {{ $menuItem->isActive() == 'active' ? 'bg-[#133b63]/10 text-[#133b63] font-semibold border border-[#133b63]/20' : 'text-slate-600 hover:bg-slate-100' }}"
                        >
                            <span class="{{ $menuItem->getIcon() }} text-xl"></span>

                            <p class="whitespace-nowrap text-sm font-medium">
                                {{ $menuItem->getName() }}
                            </p>
                        </a>

                        @if ($menuItem->haveChildren())
                            <div class="{{ $menuItem->isActive() ? '!grid bg-slate-50' : '' }} hidden min-w-[180px] ltr:pl-8 rtl:pr-8 py-1.5 rounded-b-[12px]">
                                @foreach ($menuItem->getChildren() as $subMenuItem)
                                    <a
                                        href="{{ $subMenuItem->getUrl() }}"
                                        class="text-xs {{ $subMenuItem->isActive() ? 'text-[#133b63] font-semibold' : 'text-slate-600 hover:text-slate-900' }} whitespace-nowrap py-1.5 px-2 rounded-lg"
                                    >
                                        {{ $subMenuItem->getName() }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </nav>
        </div>
    </x-slot>
</x-admin::drawer>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-mega-search-template"
    >
        <div class="relative flex w-[220px] items-center sm:w-[320px] md:w-[420px] lg:w-[500px] ltr:ml-3 rtl:mr-3">
            <i class="icon-search pointer-events-none absolute top-1/2 -translate-y-1/2 text-lg text-slate-400 ltr:left-3.5 rtl:right-3.5 sm:text-xl"></i>

            <input
                type="text"
                class="peer block w-full rounded-[12px] border border-slate-200 bg-slate-100 !pl-10 !pr-4 rtl:!pr-10 rtl:!pl-4 py-2 text-sm text-slate-900 placeholder:text-slate-400 transition-all hover:border-slate-300 focus:border-[#133b63] focus:ring-2 focus:ring-[#133b63]/20"
                :class="{'border-[#133b63]': isDropdownOpen}"
                placeholder="@lang('admin::app.components.layouts.header.mega-search.title')"
                v-model.lazy="searchTerm"
                @click="searchTerm.length >= 2 ? isDropdownOpen = true : {}"
                v-debounce="500"
            >

            <div
                class="absolute top-11 z-10 w-full rounded-[14px] border border-slate-200 bg-white shadow-xl backdrop-blur-xl sm:top-12 overflow-hidden"
                v-if="isDropdownOpen"
            >
                <!-- Search Tabs -->
                <div class="flex border-b border-slate-200 text-xs text-slate-600 sm:text-sm bg-slate-50">
                    <div
                        class="cursor-pointer px-4 py-3 hover:text-slate-900 transition-colors"
                        :class="{ 'border-b-2 border-[#133b63] text-[#133b63] font-semibold bg-white': activeTab == tab.key }"
                        v-for="tab in tabs"
                        @click="activeTab = tab.key; search();"
                    >
                        @{{ tab.title }}
                    </div>
                </div>

                <!-- Searched Results -->
                <template v-if="activeTab == 'products'">
                    <template v-if="isLoading">
                        <x-admin::shimmer.header.mega-search.products />
                    </template>

                    <template v-else>
                        <div class="grid max-h-[300px] overflow-y-auto sm:max-h-[400px]">
                            <a
                                :href="'{{ route('admin.catalog.products.edit', ':id') }}'.replace(':id', product.id)"
                                class="flex cursor-pointer justify-between gap-2 border-b border-slate-200 p-3 last:border-b-0 hover:bg-slate-50 sm:gap-2.5 sm:p-4"
                                v-for="product in searchedResults.products.data"
                            >
                                <!-- Left Information -->
                                <div class="flex gap-2 sm:gap-2.5">
                                    <!-- Image -->
                                    <div
                                        class="relative h-10 max-h-10 w-full max-w-10 overflow-hidden rounded-[8px] border border-slate-200 sm:h-[60px] sm:max-h-[60px] sm:max-w-[60px]"
                                        :class="{'border-dashed border-slate-300': ! product.images.length}"
                                    >
                                        <template v-if="! product.images.length">
                                            <img src="{{ bagisto_asset('images/product-placeholders/front.svg') }}" class="h-full w-full object-cover">

                                            <p class="absolute bottom-0.5 w-full text-center text-[4px] font-semibold text-gray-400 sm:bottom-1.5 sm:text-[6px]">
                                                @lang('admin::app.catalog.products.edit.types.grouped.image-placeholder')
                                            </p>
                                        </template>

                                        <template v-else>
                                            <img :src="product.images[0].url" class="h-full w-full object-cover">
                                        </template>
                                    </div>

                                    <!-- Details -->
                                    <div class="grid place-content-start gap-1 sm:gap-1.5">
                                        <p class="text-sm font-semibold text-slate-900 sm:text-base">
                                            @{{ product.name }}
                                        </p>

                                        <p class="text-xs font-mono text-slate-500">
                                            @{{ "@lang('admin::app.components.layouts.header.mega-search.sku')".replace(':sku', product.sku) }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Right Information -->
                                <div class="grid place-content-center gap-1 text-right">
                                    <p class="text-sm font-bold font-mono text-[#133b63]">
                                        @{{ product.formatted_price }}
                                    </p>
                                </div>
                            </a>
                        </div>

                        <div class="flex border-t border-slate-200 p-2 bg-slate-50/50 sm:p-3">
                            <a
                                :href="'{{ route('admin.catalog.products.index') }}?search=:query'.replace(':query', searchTerm)"
                                class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                                v-if="searchedResults.products.data.length"
                            >
                                @{{ "@lang('admin::app.components.layouts.header.mega-search.explore-all-matching-products')".replace(':query', searchTerm).replace(':count', searchedResults.products.meta.total) }}
                            </a>

                            <a
                                href="{{ route('admin.catalog.products.index') }}"
                                class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                                v-else
                            >
                                @lang('admin::app.components.layouts.header.mega-search.explore-all-products')
                            </a>
                        </div>
                    </template>
                </template>

                <template v-if="activeTab == 'orders'">
                    <template v-if="isLoading">
                        <x-admin::shimmer.header.mega-search.orders />
                    </template>

                    <template v-else>
                        <div class="grid max-h-[300px] overflow-y-auto sm:max-h-[400px]">
                            <a
                                :href="'{{ route('admin.sales.orders.view', ':id') }}'.replace(':id', order.id)"
                                class="grid cursor-pointer place-content-start gap-1 border-b border-slate-200 p-3 last:border-b-0 hover:bg-slate-50 sm:gap-1.5 sm:p-4"
                                v-for="order in searchedResults.orders.data"
                            >
                                <p class="text-sm font-bold font-mono text-slate-900">
                                    #@{{ order.increment_id }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    @{{ order.formatted_created_at + ', ' + order.status_label + ', ' + order.customer_full_name }}
                                </p>
                            </a>
                        </div>

                        <div class="flex border-t border-slate-200 p-2 bg-slate-50/50 sm:p-3">
                            <a
                                :href="'{{ route('admin.sales.orders.index') }}?search=:query'.replace(':query', searchTerm)"
                                class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                                v-if="searchedResults.orders.data.length"
                            >
                                @{{ "@lang('admin::app.components.layouts.header.mega-search.explore-all-matching-orders')".replace(':query', searchTerm).replace(':count', searchedResults.orders.total) }}
                            </a>

                            <a
                                href="{{ route('admin.sales.orders.index') }}"
                                class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                                v-else
                            >
                                @lang('admin::app.components.layouts.header.mega-search.explore-all-orders')
                            </a>
                        </div>
                    </template>
                </template>

                <template v-if="activeTab == 'categories'">
                    <template v-if="isLoading">
                        <x-admin::shimmer.header.mega-search.categories />
                    </template>

                    <template v-else>
                        <div class="grid max-h-[300px] overflow-y-auto sm:max-h-[400px]">
                            <a
                                :href="'{{ route('admin.catalog.categories.edit', ':id') }}'.replace(':id', category.id)"
                                class="cursor-pointer border-b border-slate-200 p-3 text-xs font-semibold text-slate-900 last:border-b-0 hover:bg-slate-50 sm:p-4 sm:text-sm"
                                v-for="category in searchedResults.categories.data"
                            >
                                @{{ category.name }}
                            </a>
                        </div>

                        <div class="flex border-t border-slate-200 p-2 bg-slate-50/50 sm:p-3">
                            <a
                                :href="'{{ route('admin.catalog.categories.index') }}?search=:query'.replace(':query', searchTerm)"
                                class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                                v-if="searchedResults.categories.data.length"
                            >
                                @{{ "@lang('admin::app.components.layouts.header.mega-search.explore-all-matching-categories')".replace(':query', searchTerm).replace(':count', searchedResults.categories.total) }}
                            </a>

                            <a
                                href="{{ route('admin.catalog.categories.index') }}"
                                class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                                v-else
                            >
                                @lang('admin::app.components.layouts.header.mega-search.explore-all-categories')
                            </a>
                        </div>
                    </template>
                </template>

                <template v-if="activeTab == 'customers'">
                    <template v-if="isLoading">
                        <x-admin::shimmer.header.mega-search.customers />
                    </template>

                    <template v-else>
                        <div class="grid max-h-[300px] overflow-y-auto sm:max-h-[400px]">
                            <a
                                :href="'{{ route('admin.customers.customers.view', ':id') }}'.replace(':id', customer.id)"
                                class="grid cursor-pointer place-content-start gap-1 border-b border-slate-200 p-3 last:border-b-0 hover:bg-slate-50 sm:gap-1.5 sm:p-4"
                                v-for="customer in searchedResults.customers.data"
                            >
                                <p class="text-sm font-semibold text-slate-900">
                                    @{{ customer.first_name + ' ' + customer.last_name }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    @{{ customer.email }}
                                </p>
                            </a>
                        </div>

                        <div class="flex border-t border-slate-200 p-2 bg-slate-50/50 sm:p-3">
                            <a
                                :href="'{{ route('admin.customers.customers.index') }}?search=:query'.replace(':query', searchTerm)"
                                class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                                v-if="searchedResults.customers.data.length"
                            >
                                @{{ "@lang('admin::app.components.layouts.header.mega-search.explore-all-matching-customers')".replace(':query', searchTerm).replace(':count', searchedResults.customers.total) }}
                            </a>

                            <a
                                href="{{ route('admin.customers.customers.index') }}"
                                class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                                v-else
                            >
                                @lang('admin::app.components.layouts.header.mega-search.explore-all-customers')
                            </a>
                        </div>
                    </template>
                </template>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-mega-search', {
            template: '#v-mega-search-template',

            data() {
                return {
                    activeTab: 'products',

                    isDropdownOpen: false,

                    tabs: {
                        products: {
                            key: 'products',
                            title: "@lang('admin::app.components.layouts.header.mega-search.products')",
                            is_active: true,
                            endpoint: "{{ route('admin.catalog.products.search') }}"
                        },

                        orders: {
                            key: 'orders',
                            title: "@lang('admin::app.components.layouts.header.mega-search.orders')",
                            endpoint: "{{ route('admin.sales.orders.search') }}"
                        },

                        categories: {
                            key: 'categories',
                            title: "@lang('admin::app.components.layouts.header.mega-search.categories')",
                            endpoint: "{{ route('admin.catalog.categories.search') }}"
                        },

                        customers: {
                            key: 'customers',
                            title: "@lang('admin::app.components.layouts.header.mega-search.customers')",
                            endpoint: "{{ route('admin.customers.customers.search') }}"
                        }
                    },

                    isLoading: false,

                    searchTerm: '',

                    searchedResults: {
                        products: [],
                        orders: [],
                        categories: [],
                        customers: []
                    },
                }
            },

            watch: {
                searchTerm: function(newVal, oldVal) {
                    this.search()
                }
            },

            created() {
                window.addEventListener('click', this.handleFocusOut);
            },

            beforeDestroy() {
                window.removeEventListener('click', this.handleFocusOut);
            },

            methods: {
                search() {
                    if (this.searchTerm.length <= 1) {
                        this.searchedResults[this.activeTab] = [];

                        this.isDropdownOpen = false;

                        return;
                    }

                    this.isDropdownOpen = true;

                    let self = this;

                    this.isLoading = true;

                    this.$axios.get(this.tabs[this.activeTab].endpoint, {
                            params: {query: this.searchTerm}
                        })
                        .then(function(response) {
                            self.searchedResults[self.activeTab] = response.data;

                            self.isLoading = false;
                        })
                        .catch(function (error) {
                        })
                },

                handleFocusOut(e) {
                    if (! this.$el.contains(e.target)) {
                        this.isDropdownOpen = false;
                    }
                },
            }
        });
    </script>

    <script
        type="text/x-template"
        id="v-notifications-template"
    >
        <x-admin::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
            <!-- Notification Toggle -->
            <x-slot:toggle>
                <span class="relative flex">
                    <span
                        class="icon-notification cursor-pointer rounded-[12px] p-2 text-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all sm:text-2xl"
                        title="@lang('admin::app.components.layouts.header.notifications')"
                    >
                    </span>

                    <span
                        class="absolute -top-1 flex h-4 min-w-4 cursor-pointer items-center justify-center rounded-full bg-[#133b63] p-1 text-[10px] font-semibold leading-[9px] text-white ltr:right-0 rtl:left-0 font-mono"
                        v-if="totalUnRead"
                    >
                        @{{ totalUnRead }}
                    </span>
                </span>
            </x-slot>

            <!-- Notification Content -->
            <x-slot:content class="min-w-[280px] max-w-[320px] !p-0 !bg-white !border !border-slate-200 !rounded-[14px] shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="border-b border-slate-200 bg-slate-50 p-3 text-sm font-semibold text-slate-900">
                    @lang('admin::app.notifications.title', ['read' => 0])
                </div>

                <!-- Content -->
                <div class="grid max-h-[300px] overflow-y-auto">
                    <a
                        class="flex items-start gap-2.5 border-b border-slate-100 p-3 last:border-b-0 hover:bg-slate-50 transition-colors"
                        v-for="notification in notifications"
                        :href="'{{ route('admin.notification.viewed_notification', ':orderId') }}'.replace(':orderId', notification.order_id)"
                    >
                        <!-- Notification Icon -->
                        <span
                            v-if="notification.order.status in notificationStatusIcon"
                            class="h-fit"
                            :class="notificationStatusIcon[notification.order.status]"
                        >
                        </span>

                        <div class="grid">
                            <!-- Order Id & Status -->
                            <p class="text-sm font-semibold text-slate-900">
                                #@{{ notification.order.id }}
                                @{{ orderTypeMessages[notification.order.status] }}
                            </p>

                            <!-- Created Date In human Readable Format -->
                            <p class="text-xs text-slate-500 font-mono">
                                @{{ notification.order.datetime }}
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Footer -->
                <div class="flex h-[47px] justify-between items-center border-t border-slate-200 bg-slate-50/50 px-4 py-3">
                    <a
                        href="{{ route('admin.notification.index') }}"
                        class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                    >
                        @lang('admin::app.notifications.view-all')
                    </a>

                    <a
                        class="cursor-pointer text-xs font-semibold text-[#133b63] transition-all hover:underline"
                        v-if="notifications?.length"
                        @click="readAll()"
                    >
                        @lang('admin::app.notifications.read-all')
                    </a>
                </div>
            </x-slot>
        </x-admin::dropdown>
    </script>

    <script type="module">
        app.component('v-notifications', {
            template: '#v-notifications-template',

            props: [
                'getReadAllUrl',
                'readAllTitle',
            ],

            data() {
                return {
                    notifications: [],

                    ordertype: {
                        pending: {
                            icon: 'icon-information',
                            message: "@lang('admin::app.notifications.order-status-messages.pending-payment')"
                        },

                        processing: {
                            icon: 'icon-processing',
                            message: "@lang('admin::app.notifications.order-status-messages.processing')",
                        },

                        canceled: {
                            icon: 'icon-cancel-1',
                            message: "@lang('admin::app.notifications.order-status-messages.canceled')"
                        },

                        completed: {
                            icon: 'icon-done',
                            message: "@lang('admin::app.notifications.order-status-messages.completed')"
                        },

                        closed: {
                            icon: 'icon-cancel-1',
                            message: "@lang('admin::app.notifications.order-status-messages.closed')"
                        },

                        pending_payment: {
                            icon: "icon-information",
                            message: "@lang('admin::app.notifications.order-status-messages.pending-payment')"
                        },
                    },

                    totalUnRead: 0,

                    orderTypeMessages: {
                        {{ \Webkul\Sales\Models\Order::STATUS_PENDING }}: "@lang('admin::app.notifications.order-status-messages.pending')",
                        {{ \Webkul\Sales\Models\Order::STATUS_CANCELED }}: "@lang('admin::app.notifications.order-status-messages.canceled')",
                        {{ \Webkul\Sales\Models\Order::STATUS_CLOSED }}: "@lang('admin::app.notifications.order-status-messages.closed')",
                        {{ \Webkul\Sales\Models\Order::STATUS_COMPLETED }}: "@lang('admin::app.notifications.order-status-messages.completed')",
                        {{ \Webkul\Sales\Models\Order::STATUS_PROCESSING }}: "@lang('admin::app.notifications.order-status-messages.processing')",
                        {{ \Webkul\Sales\Models\Order::STATUS_PENDING_PAYMENT }}: "@lang('admin::app.notifications.order-status-messages.pending-payment')",
                    }
                }
            },

            computed: {
                notificationStatusIcon() {
                    return {
                        pending: 'icon-information rounded-full bg-amber-100 p-1 text-lg text-amber-600',
                        closed: 'icon-repeat rounded-full bg-red-100 p-1 text-lg text-red-600',
                        completed: 'icon-done rounded-full bg-emerald-100 p-1 text-lg text-[#133b63]',
                        canceled: 'icon-cancel-1 rounded-full bg-red-100 p-1 text-lg text-red-600',
                        processing: 'icon-sort-right rounded-full bg-emerald-100 p-1 text-lg text-emerald-600',
                    };
                },
            },

            mounted() {
                this.getNotification();
            },

            methods: {
                getNotification() {
                    this.$axios.get('{{ route('admin.notification.get_notification') }}', {
                            params: {
                                limit: 5,
                                read: 0
                            }
                        })
                        .then((response) => {
                            this.notifications = response.data.search_results.data;

                            this.totalUnRead =   response.data.total_unread;
                        })
                        .catch(error => console.log(error))
                },

                readAll() {
                    this.$axios.post('{{ route('admin.notification.read_all') }}')
                        .then((response) => {
                            this.notifications = response.data.search_results.data;

                            this.totalUnRead = response.data.total_unread;

                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.success_message });
                        })
                        .catch((error) => {});
                },
            },
        });
    </script>
@endpushOnce
