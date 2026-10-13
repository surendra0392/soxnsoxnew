<x-admin::layouts>
    <x-slot:title>
        @lang('blog::app.admin.blogs.title')
    </x-slot>

    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800">
            @lang('blog::app.admin.blogs.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            @if (bouncer()->hasPermission('blogs.create'))
                <a
                    href="{{ route('admin.blogs.create') }}"
                    class="primary-button"
                >
                    @lang('blog::app.admin.blogs.create')
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('bagisto.admin.blogs.list.before') !!}

    <x-admin::datagrid :src="route('admin.blogs.index')" />
    
    {!! view_render_event('bagisto.admin.blogs.list.after') !!}

</x-admin::layouts>
