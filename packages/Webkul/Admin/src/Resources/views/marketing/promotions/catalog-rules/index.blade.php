<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.marketing.promotions.catalog-rules.index.title')
    </x-slot>

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                @lang('admin::app.marketing.promotions.catalog-rules.index.title')
            </h1>
            <p class="mt-0.5 text-xs text-slate-500">
                Set category-wide markdown pricing, percentage sales, and scheduled catalog promotions.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            @if (bouncer()->hasPermission('marketing.promotions.catalog_rules.create'))
                <a 
                    href="{{ route('admin.marketing.promotions.catalog_rules.create') }}"
                    class="primary-button"
                >
                    <i class="fa-solid fa-plus text-xs mr-1"></i>
                    @lang('admin::app.marketing.promotions.catalog-rules.index.create-btn')
                </a>
            @endif
        </div>
    </div>
    
    {!! view_render_event('bagisto.admin.marketing.promotions.catalog_rules.list.before') !!}

    <x-admin::datagrid :src="route('admin.marketing.promotions.catalog_rules.index')" />

    {!! view_render_event('bagisto.admin.marketing.promotions.catalog_rules.list.after') !!}
</x-admin::layouts>