<div class="w-full lg:w-[380px] xl:w-[420px] shrink-0">
    <div class="rounded-3xl border border-soxnsox-border/80 bg-white p-6 sm:p-8 shadow-soxnsox-subtle space-y-6">
        {!! view_render_event('bagisto.shop.checkout.cart.summary.title.before') !!}

        <div class="border-b border-soxnsox-border/60 pb-4">
            <h2 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]" role="heading" aria-level="2">
                @lang('shop::app.checkout.cart.summary.cart-summary')
            </h2>
        </div>

        {!! view_render_event('bagisto.shop.checkout.cart.summary.title.after') !!}

        <!-- Cart Totals Breakdown -->
        <div class="space-y-4 text-sm">
            <!-- Estimate Tax and Shipping (If Configured) -->
            @if (core()->getConfigData('sales.checkout.shopping_cart.estimate_shipping'))
                <template v-if="cart.have_stockable_items">
                    @include('shop::checkout.cart.summary.estimate-shipping')
                </template>
            @endif

            <!-- Sub Total -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.sub_total.before') !!}

            <!-- Original Subtotal / MRP (When discount exists) -->
            <div class="flex justify-between items-center text-xs text-[#64748b]" v-if="cart.has_discount">
                <span>Original Price (MRP)</span>
                <span class="line-through font-medium">@{{ cart.formatted_regular_sub_total }}</span>
            </div>

            <!-- Discount Savings Row -->
            <div class="flex justify-between items-center text-xs font-semibold text-[#208a86]" v-if="cart.has_discount">
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-tag text-xs"></i>
                    Product Discount & Savings
                </span>
                <span>- @{{ cart.formatted_total_discount }}</span>
            </div>

            <div class="flex justify-between items-center text-soxnsox-slate pt-1 border-t border-[#e5e7eb]/60" :class="{'!border-t-0 !pt-0': !cart.has_discount}">
                <span class="font-medium">@lang('shop::app.checkout.cart.summary.sub-total')</span>

                <span class="font-bold text-soxnsox-charcoal">
                    <template v-if="displayTax.subtotal == 'including_tax'">
                        @{{ cart.formatted_sub_total_incl_tax }}
                    </template>
                    <template v-else-if="displayTax.subtotal == 'both'">
                        @{{ cart.formatted_sub_total_incl_tax }}
                        <span class="text-xs text-soxnsox-muted block text-right font-normal">(@lang('shop::app.checkout.cart.summary.excl-tax') @{{ cart.formatted_sub_total }})</span>
                    </template>
                    <template v-else>
                        @{{ cart.formatted_sub_total }}
                    </template>
                </span>
            </div>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.sub_total.after') !!}

            <!-- Discount Amount (Coupon / Cart Rule) -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.discount_amount.before') !!}

            <template v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
                <div class="flex justify-between items-center text-emerald-700 bg-emerald-50 px-3 py-2 rounded-xl border border-emerald-200 text-xs font-semibold">
                    <span>@lang('shop::app.checkout.cart.summary.discount-amount')</span>
                    <span>- @{{ cart.formatted_discount_amount }}</span>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.discount_amount.after') !!}

            <!-- Apply Coupon Section -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.coupon.before') !!}

            <div class="pt-2 pb-2 border-t border-soxnsox-border/60">
                @include('shop::checkout.coupon')
            </div>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.coupon.after') !!}

            <!-- Shipping / Delivery Charges -->
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}

            <div class="flex justify-between items-center text-soxnsox-slate" v-if="cart.selected_shipping_rate || cart.shipping_method">
                <span>@lang('shop::app.checkout.cart.summary.delivery-charges')</span>
                <span class="font-semibold text-soxnsox-charcoal">
                    <template v-if="parseFloat(cart.shipping_amount || 0) <= 0">
                        <span class="text-[#1d5b8f] font-bold">FREE</span>
                    </template>
                    <template v-else-if="displayTax.shipping == 'including_tax'">
                        + @{{ cart.formatted_shipping_amount_incl_tax }}
                    </template>
                    <template v-else>
                        + @{{ cart.formatted_shipping_amount }}
                    </template>
                </span>
            </div>
            <div class="flex justify-between items-center text-xs text-soxnsox-muted" v-else>
                <span>Estimated Shipping</span>
                <span>Calculated at checkout</span>
            </div>

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

            <!-- Taxes -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.tax.before') !!}

            <div class="flex justify-between items-center text-soxnsox-slate" v-if="cart.tax_total && parseFloat(cart.tax_total) > 0">
                <span>@lang('shop::app.checkout.cart.summary.tax')</span>
                <span class="font-semibold text-soxnsox-charcoal">+ @{{ cart.formatted_tax_total }}</span>
            </div>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.tax.after') !!}

            <!-- Cart Grand Total -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.grand_total.before') !!}

            <div class="pt-4 border-t border-soxnsox-border/80 flex justify-between items-baseline">
                <span class="font-display text-base font-bold text-[#133b63]">
                    @lang('shop::app.checkout.cart.summary.grand-total')
                </span>

                <span class="font-display text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                    @{{ cart.formatted_grand_total }}
                </span>
            </div>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.grand_total.after') !!}

            <!-- Action Buttons -->
            <div class="pt-4 space-y-2.5">
                {!! view_render_event('bagisto.shop.checkout.cart.summary.proceed_to_checkout.before') !!}

                <a
                    href="{{ route('shop.checkout.onepage.index') }}"
                    class="soxnsox-btn-primary soxnsox-btn-shimmer h-12 w-full text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 shadow-soxnsox-card active:scale-95 transition-all duration-300"
                >
                    <span>@lang('shop::app.checkout.cart.summary.proceed-to-checkout')</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>

                {!! view_render_event('bagisto.shop.checkout.cart.summary.proceed_to_checkout.after') !!}

                <a
                    href="{{ route('shop.search.index') }}"
                    class="soxnsox-btn-outline h-11 w-full text-xs uppercase tracking-widest font-semibold flex items-center justify-center gap-2"
                >
                    <span>Continue Shopping</span>
                </a>
            </div>

            <!-- Trust Badges -->
            <div class="pt-4 border-t border-soxnsox-border/60 space-y-2 text-[11px] text-soxnsox-muted">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-[#2ca7a3]"></i>
                    <span>100% Bamboo Comfort <i class="fa-solid fa-circle text-[4px] mx-1"></i> Seamless Blister Defense</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-lock text-[#1d5b8f]"></i>
                    <span>Secure Encrypted Checkout</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-box text-[#f29a38]"></i>
                    <span>Direct Express Dispatch</span>
                </div>
            </div>
        </div>
    </div>
</div>