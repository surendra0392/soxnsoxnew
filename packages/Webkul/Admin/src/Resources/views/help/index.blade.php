<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.help.index.title')
    </x-slot>

    @php
        $services = [
            [
                'title' => trans('admin::app.help.index.cloud-hosting'),
                'info'  => trans('admin::app.help.index.cloud-hosting-info'),
                'url'   => 'https://bagisto.com/en/cloud/',
                'host'  => 'bagisto.com/cloud',
                'icon'  => 'fa-solid fa-cloud',
            ],
            [
                'title' => trans('admin::app.help.index.support'),
                'info'  => trans('admin::app.help.index.support-info'),
                'url'   => 'https://bagisto.com/en/support/',
                'host'  => 'bagisto.com/support',
                'icon'  => 'fa-solid fa-headset',
            ],
            [
                'title' => trans('admin::app.help.index.paid-services'),
                'info'  => trans('admin::app.help.index.paid-services-info'),
                'url'   => 'https://bagisto.com/en/contacts/',
                'host'  => 'bagisto.com/services',
                'icon'  => 'fa-solid fa-wrench',
            ],
        ];

        $resources = [
            [
                'title' => trans('admin::app.help.index.extensions'),
                'info'  => trans('admin::app.help.index.extensions-info'),
                'url'   => 'https://bagisto.com/en/extensions/',
                'host'  => 'bagisto.com/extensions',
                'icon'  => 'fa-solid fa-puzzle-piece',
            ],
            [
                'title' => trans('admin::app.help.index.docs'),
                'info'  => trans('admin::app.help.index.docs-info'),
                'url'   => 'https://devdocs.bagisto.com/',
                'host'  => 'devdocs.bagisto.com',
                'icon'  => 'fa-solid fa-book',
            ],
            [
                'title' => trans('admin::app.help.index.api-docs'),
                'info'  => trans('admin::app.help.index.api-docs-info'),
                'url'   => 'https://api-docs.bagisto.com/',
                'host'  => 'api-docs.bagisto.com',
                'icon'  => 'fa-solid fa-code',
            ],
        ];
    @endphp

    {!! view_render_event('bagisto.admin.help.index.before') !!}

    <!-- Page Header -->
    <div class="grid gap-1.5 mb-8 max-w-3xl">
        <p class="text-2xl font-bold !leading-snug text-gray-800">
            @lang('admin::app.help.index.title')
        </p>

        <p class="!leading-relaxed text-gray-600">
            @lang('admin::app.help.index.description')
        </p>
    </div>

    <!-- Services -->
    <div class="mb-10">
        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">
            @lang('admin::app.help.index.services-title')
        </p>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($services as $card)
                @include('admin::help.card', ['card' => $card])
            @endforeach
        </div>
    </div>

    <!-- Resources & Documentation -->
    <div class="mb-10">
        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">
            @lang('admin::app.help.index.resources-title')
        </p>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($resources as $card)
                @include('admin::help.card', ['card' => $card])
            @endforeach
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="flex flex-wrap items-center justify-between gap-5 rounded-[14px] bg-gradient-to-r from-[#133b63] to-[#0d2847] px-7 py-6 shadow-md border border-[#133b63]">
        <div class="flex items-center gap-4">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/20 text-white">
                <i class="fa-solid fa-comment-dots text-xl"></i>
            </span>

            <div class="grid gap-0.5">
                <p class="text-lg font-bold !leading-snug text-white">
                    @lang('admin::app.help.index.cta-title')
                </p>

                <p class="!leading-snug text-white/80">
                    @lang('admin::app.help.index.cta-description')
                </p>
            </div>
        </div>

        <a
            href="https://bagisto.com/en/contacts/"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 font-semibold text-[#133b63] transition-all hover:bg-slate-100 shadow-sm"
        >
            @lang('admin::app.help.index.cta-btn')

            <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>

    {!! view_render_event('bagisto.admin.help.index.after') !!}
</x-admin::layouts>
