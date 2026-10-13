<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.catalog.families.index.title')
    </x-slot>

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                @lang('admin::app.catalog.families.index.title')
            </h1>
            <p class="mt-0.5 text-xs text-slate-500">
                Manage attribute family groupings, tab groupings, and attribute sets for product types.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            @if (bouncer()->hasPermission('catalog.families.create'))
                <a href="{{ route('admin.catalog.families.create') }}">
                    <div class="primary-button">
                        <i class="fa-solid fa-plus text-xs mr-1"></i>
                        @lang('admin::app.catalog.families.index.add')
                    </div>
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('bagisto.admin.catalog.families.list.before') !!}

    <x-admin::datagrid :src="route('admin.catalog.families.index')" />

    {!! view_render_event('bagisto.admin.catalog.families.list.after') !!}
</x-admin::layouts>