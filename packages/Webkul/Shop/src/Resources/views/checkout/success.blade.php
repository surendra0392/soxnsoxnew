<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.success.thanks') | SOXNSOX
    </x-slot>

    <div class="bg-[#f5f7fa] min-h-[calc(100vh-80px)]">
        <!-- Page content -->
        <main class="site-container py-12 lg:py-20">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 sm:p-14 lg:p-16 text-center max-w-2xl mx-auto shadow-sm space-y-6">
                {{ view_render_event('bagisto.shop.checkout.success.image.before', ['order' => $order]) }}

                <!-- Success Badge -->
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#e6f8f7] border border-[#2ca7a3]/30 text-2xl text-[#208a86] font-bold select-none">
                    <i class="fa-solid fa-circle-check text-3xl text-[#2ca7a3]"></i>
                </div>

                {{ view_render_event('bagisto.shop.checkout.success.image.after', ['order' => $order]) }}

                <div class="space-y-2">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#e6f8f7] text-[#208a86] text-[10px] sm:text-xs font-semibold tracking-widest uppercase">
                        <i class="fa-solid fa-circle-check text-xs"></i>
                        <span>Order Confirmed</span>
                    </div>

                    <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-[#133b63]">
                        @lang('shop::app.checkout.success.thanks')
                    </h1>

                    <div class="soxnsox-decorative-line-center mt-2.5"></div>

                    <p class="text-sm sm:text-base font-semibold text-[#1d5b8f] pt-1">
                        @if (auth()->guard('customer')->user())
                            @lang('shop::app.checkout.success.order-id-info', [
                                'order_id' => '<a class="underline hover:text-[#133b63]" href="'.route('shop.customers.account.orders.view', $order->id).'">#'.$order->increment_id.'</a>'
                            ])
                        @else
                            Order #{{ $order->increment_id }}
                        @endif
                    </p>

                    <p class="text-xs sm:text-sm text-[#6b7280] leading-relaxed max-w-md mx-auto pt-2">
                        @if (! empty($order->checkout_message))
                            {!! nl2br($order->checkout_message) !!}
                        @else
                            A confirmation receipt has been dispatched to <strong>{{ $order->customer_email }}</strong>. Your bamboo socks are being carefully prepared for express dispatch.
                        @endif
                    </p>
                </div>

                {{ view_render_event('bagisto.shop.checkout.success.continue-shopping.before', ['order' => $order]) }}

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a
                        href="{{ route('shop.home.index') }}"
                        class="soxnsox-btn-primary soxnsox-btn-shimmer active:scale-95 w-full sm:w-auto inline-flex items-center justify-center gap-2 text-xs uppercase tracking-widest font-semibold px-8 py-3.5 shadow-sm transition-all"
                    >
                        <span>@lang('shop::app.checkout.cart.index.continue-shopping')</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>

                    @if (auth()->guard('customer')->user())
                        <a
                            href="{{ route('shop.customers.account.orders.view', $order->id) }}"
                            class="soxnsox-btn-outline soxnsox-btn-shimmer active:scale-95 w-full sm:w-auto inline-flex items-center justify-center gap-2 text-xs uppercase tracking-widest font-semibold px-7 py-3.5 transition-all"
                        >
                            <span>View Order Status</span>
                        </a>
                    @endif
                </div>

                {{ view_render_event('bagisto.shop.checkout.success.continue-shopping.after', ['order' => $order]) }}
            </div>
        </main>
    </div>
</x-shop::layouts>
