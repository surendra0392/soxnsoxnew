{{--
    Shared withdrawal receipt presentation.
    Used by both the auth-customer confirmation page and the guest signed-URL page.
    $withdrawal (Withdrawal model), $isGuest (bool).
--}}
@php
    $isDeclined = $withdrawal->status === 'declined';

    $statusContext = [
        'received' => [
            'badge'   => 'bg-amber-100 text-amber-800',
            'hero_bg' => 'bg-emerald-100 text-emerald-700',
        ],

        'refunded' => [
            'badge'   => 'bg-emerald-100 text-emerald-800',
            'hero_bg' => 'bg-emerald-100 text-emerald-700',
        ],

        'declined' => [
            'badge'   => 'bg-red-100 text-red-800',
            'hero_bg' => 'bg-red-100 text-red-700',
        ],
    ][$withdrawal->status] ?? [
        'badge'   => 'bg-zinc-100 text-zinc-800',
        'hero_bg' => 'bg-zinc-100 text-zinc-700',
    ];
@endphp

<style>
    @media print {
        @page {
            margin: 12mm;
        }

        html,
        body {
            background: #ffffff !important;
        }

        body * {
            visibility: hidden !important;
        }

        #eu-withdrawal-print-area,
        #eu-withdrawal-print-area * {
            visibility: visible !important;
        }

        #eu-withdrawal-print-area {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            background: #ffffff !important;
            color: #000000 !important;
            z-index: 2147483647 !important;
        }

        #eu-withdrawal-print-area .print\:hidden,
        #eu-withdrawal-print-area [data-eu-clipboard] {
            display: none !important;
        }
    }
</style>

<div id="eu-withdrawal-print-area">
    <div class="flex items-center justify-between max-sm:flex-col max-sm:items-start max-sm:gap-3">
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 flex-shrink-0 place-items-center rounded-full {{ $statusContext['hero_bg'] }}">
                @if ($isDeclined)
                    <i class="fa-solid fa-circle-xmark text-2xl text-red-600"></i>
                @else
                    <i class="fa-solid fa-circle-check text-2xl text-emerald-600"></i>
                @endif
            </span>

            <div>
                <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base">
                    @lang('shop::app.eu_withdrawal.confirmation.heading_'.$withdrawal->status)
                </h2>

                <p class="text-sm text-zinc-600 max-sm:hidden">
                    @lang('shop::app.eu_withdrawal.confirmation.intro_'.$withdrawal->status)
                </p>
            </div>
        </div>

        <button
            type="button"
            data-eu-print
            data-eu-print-title="@lang('shop::app.eu_withdrawal.confirmation.page_title')"
            class="secondary-button border-zinc-200 px-4 py-2 text-sm font-normal rounded-full print:hidden"
        >
            @lang('shop::app.eu_withdrawal.confirmation.print')
        </button>
    </div>

    <p class="mt-3 text-sm text-zinc-600 sm:hidden">
        @lang('shop::app.eu_withdrawal.confirmation.intro_'.$withdrawal->status)
    </p>

    {{-- Receipt Card --}}
    <div class="mt-8 overflow-hidden rounded-xl border border-zinc-200 bg-white">
        <dl class="grid grid-cols-1 divide-y divide-zinc-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
            <div class="px-6 py-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                    @lang('shop::app.eu_withdrawal.confirmation.received_at')
                </dt>

                <dd class="mt-1 text-sm font-medium text-zinc-900">
                    {{ $withdrawal->received_at->copy()->setTimezone('UTC')->format('d M Y, H:i') }}
                    <span class="text-zinc-500">UTC</span>
                </dd>
            </div>

            <div class="px-6 py-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                    @lang('shop::app.eu_withdrawal.confirmation.reference')
                </dt>

                <dd class="mt-1 flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2">
                    <code class="flex-1 break-all font-mono text-sm font-medium text-zinc-900">
                        {{ $withdrawal->uuid }}
                    </code>

                    <button
                        type="button"
                        title="@lang('shop::app.eu_withdrawal.confirmation.copy_reference')"
                        data-eu-clipboard="{{ $withdrawal->uuid }}"
                        data-eu-clipboard-message="@lang('shop::app.eu_withdrawal.confirmation.reference_copied')"
                        class="grid h-7 w-7 flex-shrink-0 place-items-center rounded-md text-zinc-500 transition-all hover:bg-zinc-200 hover:text-zinc-900"
                    >
                        <i class="fa-regular fa-copy text-sm"></i>
                    </button>
                </dd>
            </div>

            <div class="px-6 py-4 sm:border-t sm:border-zinc-100">
                <dt class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                    @lang('shop::app.eu_withdrawal.confirmation.order')
                </dt>

                <dd class="mt-1 text-sm font-medium text-zinc-900">
                    @if (! $isGuest)
                        <a
                            href="{{ route('shop.customers.account.orders.view', $withdrawal->order_id) }}"
                            class="text-navyBlue hover:underline"
                        >
                            #{{ $withdrawal->order->increment_id ?? $withdrawal->order_id }}
                        </a>
                    @else
                        #{{ $withdrawal->order->increment_id ?? $withdrawal->order_id }}
                    @endif
                </dd>
            </div>

            <div class="px-6 py-4 sm:border-t sm:border-zinc-100">
                <dt class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                    @lang('shop::app.eu_withdrawal.confirmation.email')
                </dt>

                <dd class="mt-1 text-sm font-medium text-zinc-900">
                    {{ $withdrawal->customer_email }}
                </dd>
            </div>

            <div class="px-6 py-4 sm:border-t sm:border-zinc-100">
                <dt class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                    @lang('shop::app.eu_withdrawal.confirmation.status')
                </dt>

                <dd class="mt-1">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $statusContext['badge'] }}">
                        @lang('shop::app.eu_withdrawal.confirmation.status_'.$withdrawal->status)
                    </span>
                </dd>
            </div>

            <div class="px-6 py-4 sm:border-t sm:border-zinc-100">
                <dt class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                    @lang('shop::app.eu_withdrawal.confirmation.reason')
                </dt>

                <dd class="mt-1 whitespace-pre-wrap text-sm text-zinc-900">
                    {{ $withdrawal->reason_text ?: '—' }}
                </dd>
            </div>
        </dl>
    </div>

    {{-- Refund Timeline --}}
    <div class="mt-6 rounded-xl border border-zinc-200 bg-white p-5">
        <h3 class="text-base font-medium text-zinc-900">
            @lang('shop::app.eu_withdrawal.confirmation.next_steps_title')
        </h3>

        <ol class="mt-4 space-y-3 text-sm">
            <li class="flex gap-3">
                <span class="grid h-6 w-6 flex-shrink-0 place-items-center rounded-full bg-emerald-100 text-emerald-700">
                    <i class="fa-solid fa-check text-xs"></i>
                </span>

                <div>
                    <p class="font-medium text-zinc-900">
                        @lang('shop::app.eu_withdrawal.confirmation.step_received')
                    </p>

                    <p class="text-xs text-zinc-500">
                        {{ $withdrawal->received_at->copy()->setTimezone('UTC')->format('d M Y, H:i') }} UTC
                    </p>
                </div>
            </li>

            <li class="flex gap-3">
                @if ($withdrawal->confirmation_sent_at)
                    <span class="grid h-6 w-6 flex-shrink-0 place-items-center rounded-full bg-emerald-100 text-emerald-700">
                        <i class="fa-solid fa-check text-xs"></i>
                    </span>
                @else
                    <span class="grid h-6 w-6 flex-shrink-0 place-items-center rounded-full border border-zinc-300 text-zinc-400">
                        <i class="fa-regular fa-circle text-[10px]"></i>
                    </span>
                @endif

                <div>
                    <p class="font-medium text-zinc-900">
                        @lang('shop::app.eu_withdrawal.confirmation.step_email')
                    </p>

                    <p class="text-xs text-zinc-500">
                        @if ($withdrawal->confirmation_sent_at)
                            @lang('shop::app.eu_withdrawal.confirmation.email_sent')
                        @elseif ($withdrawal->confirmation_error)
                            <span class="text-amber-700">@lang('shop::app.eu_withdrawal.confirmation.email_pending')</span>
                        @else
                            @lang('shop::app.eu_withdrawal.confirmation.email_pending')
                        @endif
                    </p>
                </div>
            </li>
            
            <li class="flex gap-3">
                @if ($withdrawal->refunded_at)
                    <span class="grid h-6 w-6 flex-shrink-0 place-items-center rounded-full bg-emerald-100 text-emerald-700">
                        <i class="fa-solid fa-check text-xs"></i>
                    </span>

                    <div>
                        <p class="font-medium text-zinc-900">
                            @lang('shop::app.eu_withdrawal.confirmation.step_refund_done')
                        </p>

                        <p class="text-xs text-zinc-500">
                            {{ $withdrawal->refunded_at->copy()->setTimezone('UTC')->format('d M Y, H:i') }} UTC
                        </p>
                    </div>
                @elseif ($withdrawal->declined_at)
                    <span class="grid h-6 w-6 flex-shrink-0 place-items-center rounded-full bg-red-100 text-red-700">
                        <i class="fa-solid fa-xmark text-xs font-bold leading-none"></i>
                    </span>

                    <div class="flex-1">
                        <p class="font-medium text-zinc-900">
                            @lang('shop::app.eu_withdrawal.confirmation.step_declined')
                        </p>

                        @if ($withdrawal->declined_reason)
                            <div class="mt-2 rounded-md border border-red-100 bg-red-50 p-3">
                                <p class="text-xs font-medium uppercase tracking-wide text-red-700">
                                    @lang('shop::app.eu_withdrawal.confirmation.declined_reason_label')
                                </p>

                                <p class="mt-1 whitespace-pre-wrap text-sm text-red-900">{{ $withdrawal->declined_reason }}</p>
                            </div>
                        @endif

                        <p class="mt-2 text-xs text-zinc-500">
                            @lang('shop::app.eu_withdrawal.confirmation.declined_notice')
                        </p>
                    </div>
                @else
                    <span class="grid h-6 w-6 flex-shrink-0 place-items-center rounded-full border border-zinc-300 text-zinc-400">
                        <i class="fa-regular fa-circle text-[10px]"></i>
                    </span>

                    <div>
                        <p class="font-medium text-zinc-900">
                            @lang('shop::app.eu_withdrawal.confirmation.step_refund')
                        </p>

                        <p class="text-xs text-zinc-500">
                            @lang('shop::app.eu_withdrawal.confirmation.refund_notice')
                        </p>
                    </div>
                @endif
            </li>
        </ol>
    </div>

    <p class="mt-6 text-xs text-zinc-500">
        @lang('shop::app.eu_withdrawal.confirmation.durable_medium_notice')
    </p>
</div>

@if (! $isGuest)
    <div class="mt-6 print:hidden">
        <a
            href="{{ route('shop.customers.account.orders.view', $withdrawal->order_id) }}"
            class="inline-flex items-center gap-1.5 text-sm text-navyBlue hover:underline"
        >
            <i class="fa-solid fa-arrow-left rtl:rotate-180 text-sm"></i>

            @lang('shop::app.customers.account.orders.title')
        </a>
    </div>
@endif

@pushOnce('scripts')
    <script>
        document.addEventListener('click', async function (event) {
            const button = event.target.closest('[data-eu-clipboard]');

            if (! button) {
                return;
            }

            event.preventDefault();

            const text = button.getAttribute('data-eu-clipboard');
            const message = button.getAttribute('data-eu-clipboard-message') || 'Copied';

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                } else {
                    const ta = document.createElement('textarea');
                    ta.value = text;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                }

                const emitter = window?.app?.config?.globalProperties?.$emitter;

                if (emitter) {
                    emitter.emit('add-flash', { type: 'success', message: message });
                }
            } catch (err) {
                console.error('Copy failed:', err);
            }
        });

        document.addEventListener('click', function (event) {
            const trigger = event.target.closest('[data-eu-print]');

            if (! trigger) {
                return;
            }

            event.preventDefault();

            const printArea = document.getElementById('eu-withdrawal-print-area');

            if (! printArea) {
                window.print();

                return;
            }

            const HIDDEN_CLASS = 'eu-print-temp-hidden';
            const WRAPPER_ID = 'eu-print-temp-wrapper';
            const STYLE_ID = 'eu-print-temp-style';

            const cleanup = function () {
                const wrapper = document.getElementById(WRAPPER_ID);
                const styleEl = document.getElementById(STYLE_ID);

                if (wrapper) wrapper.remove();
                if (styleEl) styleEl.remove();

                document.querySelectorAll('.' + HIDDEN_CLASS).forEach(function (el) {
                    el.classList.remove(HIDDEN_CLASS);
                });

                window.removeEventListener('afterprint', cleanup);
            };

            cleanup();

            const styleEl = document.createElement('style');
            styleEl.id = STYLE_ID;
            styleEl.textContent =
                '.' + HIDDEN_CLASS + '{display:none !important;}'
                + '#' + WRAPPER_ID + '{background:#fff;color:#000;padding:24px;}'
                + '#' + WRAPPER_ID + ' [data-eu-clipboard],'
                + '#' + WRAPPER_ID + ' [data-eu-print]{display:none !important;}'
                + '@media print{@page{margin:12mm;}html,body{background:#fff !important;}}';
            document.head.appendChild(styleEl);

            Array.from(document.body.children).forEach(function (child) {
                child.classList.add(HIDDEN_CLASS);
            });

            const wrapper = document.createElement('div');
            wrapper.id = WRAPPER_ID;
            wrapper.appendChild(printArea.cloneNode(true));
            document.body.appendChild(wrapper);

            window.addEventListener('afterprint', cleanup);

            setTimeout(function () {
                window.print();
            }, 80);
        });
    </script>
@endPushOnce
