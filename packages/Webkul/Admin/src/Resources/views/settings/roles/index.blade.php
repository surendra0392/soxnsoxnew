<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.settings.roles.index.title')
    </x-slot>

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                @lang('admin::app.settings.roles.index.title')
            </h1>
            <p class="mt-0.5 text-xs text-slate-500">
                Define role access control lists (ACL) and granular permissions for admin staff.
            </p>
        </div>
        
        <div class="flex items-center gap-2.5">
            <!-- Add Role Button -->
            @if (bouncer()->hasPermission('settings.roles.create')) 
                <a 
                    href="{{ route('admin.settings.roles.create') }}"
                    class="primary-button"
                >
                    <i class="fa-solid fa-plus text-xs mr-1"></i>
                    @lang('admin::app.settings.roles.index.create-btn')
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('bagisto.admin.settings.roles.list.before') !!}
    
    <x-admin::datagrid :src="route('admin.settings.roles.index')" />

    {!! view_render_event('bagisto.admin.settings.roles.list.after') !!}
</x-admin::layouts>