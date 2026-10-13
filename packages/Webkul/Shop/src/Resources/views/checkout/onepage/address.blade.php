{!! view_render_event('bagisto.shop.checkout.onepage.address.before') !!}

<!-- Address Step Card -->
<div class="rounded-3xl border border-[#e5e7eb] bg-white p-6 sm:p-8 shadow-sm space-y-6">
    <div class="flex items-center justify-between border-b border-[#e5e7eb]/60 pb-4">
        <div class="flex items-center gap-3">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#1d5b8f] text-white text-xs font-bold font-mono shadow-xs">
                01
            </span>
            <h2 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]">
                @lang('shop::app.checkout.onepage.address.title')
            </h2>
        </div>
    </div>

    <!-- If the customer is guest -->
    <template v-if="cart.is_guest">
        @include('shop::checkout.onepage.address.guest')
    </template>

    <!-- If the customer is logged in -->
    <template v-else>
        @include('shop::checkout.onepage.address.customer')
    </template>
</div>

{!! view_render_event('bagisto.shop.checkout.onepage.address.after') !!}