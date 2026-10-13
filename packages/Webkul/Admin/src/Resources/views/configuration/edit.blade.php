@php
    $channels = core()->getAllChannels();

    $currentChannel = core()->getRequestedChannel();

    $currentLocale = core()->getRequestedLocale();

    $activeConfiguration = system_config()->getActiveConfigurationItem();
@endphp

<x-admin::layouts>
    <x-slot:title>
        {{ $name = $activeConfiguration->getName() }}
    </x-slot>

    <!-- Configuration form fields -->
    <x-admin::form
        action=""
        enctype="multipart/form-data"
    >
        <!-- Page Header & Action Buttons -->
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.configuration.index') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:text-slate-900 hover:bg-slate-50 transition-all shadow-xs"
                    title="@lang('admin::app.configuration.index.back-btn')"
                >
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>

                <div>
                    <h1 
                        class="text-2xl font-bold tracking-tight text-slate-900"
                        v-pre
                    >
                        {{ $name }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Configure options, settings, and behavior for {{ strtolower($name) }}.
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5">
                <a
                    href="{{ route('admin.configuration.index') }}"
                    class="transparent-button rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-xs"
                >
                    @lang('admin::app.configuration.index.back-btn')
                </a>

                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('admin::app.configuration.index.save-btn')
                </button>
            </div>
        </div>

        <!-- Channel & Locale Switchers -->
        @if ($channels->count() > 1 || $currentChannel->locales->count() > 1)
            <div class="mb-6 flex items-center gap-2.5 rounded-xl border border-slate-200/80 bg-slate-50/70 p-2.5">
                <!-- Channel Switcher -->
                <x-admin::dropdown :class="$channels->count() <= 1 ? 'hidden' : ''">
                    <x-slot:toggle>
                        <button
                            type="button"
                            class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-xs hover:bg-slate-50 transition-all"
                        >
                            <span class="icon-store text-lg text-slate-500"></span>

                            <span v-pre>{{ $currentChannel->name }}</span>

                            <input
                                type="hidden"
                                name="channel"
                                value="{{ $currentChannel->code }}"
                            />

                            <span class="icon-sort-down text-base text-slate-400"></span>
                        </button>
                    </x-slot>

                    <x-slot:content class="!p-1.5 !rounded-xl !border !border-slate-200 !bg-white shadow-lg">
                        @foreach ($channels as $channel)
                            <a
                                href="?{{ Arr::query(['channel' => $channel->code, 'locale' => $channel->default_locale?->code ?? $currentLocale->code]) }}"
                                class="flex cursor-pointer items-center rounded-lg px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-[#133b63]/10 hover:text-[#133b63] transition-colors {{ $channel->code == $currentChannel->code ? 'bg-[#133b63]/10 text-[#133b63] font-semibold' : '' }}"
                                v-pre
                            >
                                {{ $channel->name }}
                            </a>
                        @endforeach
                    </x-slot>
                </x-admin::dropdown>

                <!-- Locale Switcher -->
                <x-admin::dropdown :class="$currentChannel->locales->count() <= 1 ? 'hidden' : ''">
                    <x-slot:toggle>
                        <button
                            type="button"
                            class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-xs hover:bg-slate-50 transition-all"
                        >
                            <span class="icon-language text-lg text-slate-500"></span>

                            <span v-pre>{{ $currentLocale->name }}</span>
                            
                            <input
                                type="hidden"
                                name="locale"
                                value="{{ $currentLocale->code }}"
                            />

                            <span class="icon-sort-down text-base text-slate-400"></span>
                        </button>
                    </x-slot>

                    <x-slot:content class="!p-1.5 !rounded-xl !border !border-slate-200 !bg-white shadow-lg max-h-60 overflow-y-auto journal-scroll">
                        @foreach ($currentChannel->locales->sortBy('name') as $locale)
                            <a
                                href="?{{ Arr::query(['channel' => $currentChannel->code, 'locale' => $locale->code]) }}"
                                class="flex cursor-pointer items-center rounded-lg px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-[#133b63]/10 hover:text-[#133b63] transition-colors {{ $locale->code == $currentLocale->code ? 'bg-[#133b63]/10 text-[#133b63] font-semibold' : ''}}"
                                v-pre
                            >
                                {{ $locale->name }}
                            </a>
                        @endforeach
                    </x-slot>
                </x-admin::dropdown>
            </div>
        @endif

        <!-- Form Panels Grid -->
        <div class="space-y-8">
            @foreach ($activeConfiguration->getChildren() as $child)
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-[1fr_2.5fr] lg:gap-10 pb-8 border-b border-slate-200/80 last:border-b-0 last:pb-0">
                    <div class="content-start space-y-1.5">
                        <h2 class="text-base font-bold tracking-tight text-slate-900">
                            {{ $child->getName() }}
                        </h2>

                        @if ($childInfo = $child->getInfo())
                            <p class="text-xs leading-relaxed text-slate-500">
                                {!! $childInfo !!}
                            </p>
                        @endif
                    </div>

                    <div class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-xs">
                        @foreach ($child->getFields() as $field)
                            @if (
                                $field->getType() == 'blade'
                                && view()->exists($path = $field->getPath())
                            )
                                {!! view($path, compact('field', 'child'))->render() !!}
                            @else 
                                @include ('admin::configuration.field-type')
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </x-admin::form>
</x-admin::layouts>
