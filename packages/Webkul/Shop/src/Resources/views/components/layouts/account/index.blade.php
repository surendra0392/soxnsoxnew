<x-shop::layouts :has-header="true" :has-feature="false" :has-footer="true">
    <!-- Page Title -->
    <x-slot:title>
        {{ $title ?? 'Account' }} | SOXNSOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-screen">
        <div class="site-container py-6 sm:py-10">
            <!-- Breadcrumbs -->
            <x-shop::layouts.account.breadcrumb />

            <!-- Main Account Grid Layout -->
            <div class="mt-6 flex flex-col lg:flex-row items-start gap-8 lg:gap-10">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-shop::layouts>
