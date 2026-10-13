<div class="rounded-3xl border border-[#e5e7eb] bg-white p-6 sm:p-8 shadow-sm space-y-6">
    <!-- Header -->
    <div class="border-b border-[#e5e7eb]/60 pb-4">
        <h2 class="font-display text-xl sm:text-2xl font-extrabold text-[#133b63]" role="heading" aria-level="2">
            @lang('shop::app.checkout.onepage.summary.cart-summary')
            <span class="text-xs font-sans font-normal text-[#64748b]" v-if="cart?.items?.length">
                (@{{ cart.items.length }} @{{ cart.items.length === 1 ? 'item' : 'items' }})
            </span>
        </h2>
    </div>

    <!-- Cart Items (Compact) -->
    <div class="divide-y divide-soxnsox-border/60 max-h-64 overflow-y-auto pr-1">
        <div
            class="py-3.5 first:pt-0 last:pb-0 flex gap-3 items-center justify-between"
            v-for="item in cart.items"
        >
            <div class="flex items-center gap-3 min-w-0">
                {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.before') !!}

                <div class="shrink-0 w-12 h-12 rounded-xl bg-[#f8fafc] border border-soxnsox-border/70 overflow-hidden flex items-center justify-center">
                    <img
                        class="w-full h-full object-cover"
                        :src="item.base_image.small_image_url"
                        :alt="item.name"
                    />
                </div>

                {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.after') !!}

                <div class="min-w-0">
                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.before') !!}

                    <p class="font-display text-xs sm:text-sm font-bold text-[#133b63] truncate">
                        @{{ item.name }}
                    </p>

                    {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.after') !!}

                    <template v-if="item.options && item.options.length">
                        <p class="text-[10px] text-[#64748b] truncate">
                            <span v-for="(opt, idx) in item.options" :key="idx" class="mr-1.5">
                                @{{ opt.attribute_name }}: <strong class="text-[#133b63]">@{{ opt.option_label }}</strong>
                            </span>
                        </p>
                    </template>

                    <p class="text-[11px] text-soxnsox-muted">
                        Qty: @{{ item.quantity }}
                    </p>
                </div>
            </div>

            <div class="text-right shrink-0">
                <span class="font-display text-xs sm:text-sm font-bold text-[#133b63]">
                    <template v-if="displayTax.prices == 'including_tax'">
                        @{{ item.formatted_total_incl_tax }}
                    </template>
                    <template v-else>
                        @{{ item.formatted_total }}
                    </template>
                </span>
            </div>
        </div>
    </div>

    <!-- Cart Totals Breakdown -->
    <div class="border-t border-soxnsox-border/60 pt-4 space-y-3 text-xs sm:text-sm">
        <!-- Original Price (MRP) when discount exists -->
        <div class="flex justify-between items-center text-xs text-[#64748b]" v-if="cart.has_discount">
            <span>Original Price (MRP)</span>
            <span class="line-through font-medium">@{{ cart.formatted_regular_sub_total }}</span>
        </div>

        <!-- Discount Savings Row -->
        <div class="flex justify-between items-center text-xs font-semibold text-[#1d5b8f]" v-if="cart.has_discount">
            <span class="inline-flex items-center gap-1.5">
                <i class="fa-solid fa-tag text-xs"></i>
                Discount & Savings
            </span>
            <span>- @{{ cart.formatted_total_discount }}</span>
        </div>

        <!-- Sub Total -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.before') !!}

        <div class="flex justify-between items-center text-soxnsox-slate" :class="{'pt-1 border-t border-[#e5e7eb]/60': cart.has_discount}">
            <span>@lang('shop::app.checkout.onepage.summary.sub-total')</span>

            <span class="font-semibold text-soxnsox-charcoal">
                <template v-if="displayTax.subtotal == 'including_tax'">
                    @{{ cart.formatted_sub_total_incl_tax }}
                </template>
                <template v-else-if="displayTax.subtotal == 'both'">
                    @{{ cart.formatted_sub_total_incl_tax }}
                    <span class="text-xs text-soxnsox-muted block text-right font-normal">(@lang('shop::app.checkout.onepage.summary.excl-tax') @{{ cart.formatted_sub_total }})</span>
                </template>
                <template v-else>
                    @{{ cart.formatted_sub_total }}
                </template>
            </span>
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.after') !!}

        <!-- Discount Amount (Coupon) -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.before') !!}

        <template v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
            <div class="flex justify-between items-center text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200 text-xs font-semibold">
                <span>@lang('shop::app.checkout.onepage.summary.discount-amount')</span>
                <span>- @{{ cart.formatted_discount_amount }}</span>
            </div>
        </template>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.after') !!}

        <!-- Coupon Application -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.before') !!}

        <div class="pt-1 pb-1 border-t border-soxnsox-border/60">
            @include('shop::checkout.coupon')
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.after') !!}

        <!-- Delivery / Shipping Charges -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}

        <div class="flex justify-between items-center text-soxnsox-slate" v-if="cart.selected_shipping_rate || cart.shipping_method">
            <span>@lang('shop::app.checkout.onepage.summary.delivery-charges')</span>
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
        <div class="flex justify-between items-center text-xs text-soxnsox-muted" v-else-if="cart.have_stockable_items">
            <span>Shipping</span>
            <span>Calculated automatically</span>
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

        <!-- Taxes -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.before') !!}

        <div class="flex justify-between items-center text-soxnsox-slate" v-if="cart.tax_total && parseFloat(cart.tax_total) > 0">
            <span>@lang('shop::app.checkout.onepage.summary.tax')</span>
            <span class="font-semibold text-soxnsox-charcoal">+ @{{ cart.formatted_tax_total }}</span>
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.after') !!}

        <!-- Grand Total -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.before') !!}

        <div class="pt-3 border-t border-soxnsox-border/80 flex justify-between items-baseline">
            <span class="font-display text-base font-bold text-[#133b63]">
                @lang('shop::app.checkout.onepage.summary.grand-total')
            </span>

            <span class="font-display text-2xl sm:text-3xl font-extrabold text-[#133b63]">
                @{{ cart.formatted_grand_total }}
            </span>
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.after') !!}

        <!-- Mobile Place Order CTA -->
        <div class="block lg:hidden pt-3" v-if="canPlaceOrder">
            <x-shop::button
                type="button"
                class="soxnsox-btn-primary h-12 w-full text-xs uppercase tracking-widest font-semibold flex items-center justify-center gap-2 shadow-soxnsox-card"
                :title="trans('shop::app.checkout.onepage.summary.place-order')"
                ::disabled="isPlacingOrder"
                ::loading="isPlacingOrder"
                @click="placeOrder"
            />
        </div>

        <!-- Trust Badges -->
        <div class="pt-3 border-t border-soxnsox-border/60 space-y-1.5 text-[11px] text-soxnsox-muted">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-lock text-xs text-[#1d5b8f]"></i>
                <span>256-Bit Encrypted Secure Checkout</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-box text-xs text-[#f29a38]"></i>
                <span>Fresh Sealed Dispatch from Certified Facility</span>
            </div>
        </div>
    </div>
</div>
