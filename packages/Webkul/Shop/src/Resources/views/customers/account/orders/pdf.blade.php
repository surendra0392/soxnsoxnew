<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>
    <head>
        <meta
            http-equiv="Cache-control"
            content="no-cache"
        >

        <meta
            http-equiv="Content-Type"
            content="text/html; charset=utf-8"
        />

        @php
            $fontPath = [];

            if (app()->getLocale() == 'en' && $orderCurrencyCode == 'INR') {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            }  else {
                $fontFamily = [
                    'regular' => 'DejaVu Sans, Arial, sans-serif',
                    'bold'    => 'DejaVu Sans, Arial, sans-serif',
                ];
            }

            if (in_array(app()->getLocale(), ['ar', 'he', 'fa', 'tr', 'ru', 'uk'])) {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            } elseif (app()->getLocale() == 'zh_CN') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSC-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSC-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans SC',
                    'bold'    => 'Noto Sans SC Bold',
                ];
            } elseif (app()->getLocale() == 'ja') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansJP-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansJP-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans JP',
                    'bold'    => 'Noto Sans JP Bold',
                ];
            } elseif (app()->getLocale() == 'hi_IN') {
                $fontPath = [
                    'regular' => asset('fonts/Hind-Regular.ttf'),
                    'bold'    => asset('fonts/Hind-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Hind',
                    'bold'    => 'Hind Bold',
                ];
            } elseif (app()->getLocale() == 'bn') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansBengali-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansBengali-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans Bengali',
                    'bold'    => 'Noto Sans Bengali Bold',
                ];
            } elseif (app()->getLocale() == 'sin') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSinhala-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSinhala-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans Sinhala',
                    'bold'    => 'Noto Sans Sinhala Bold',
                ];
            }
        @endphp

        <!-- Language Fonts Inclusion -->
        <style type="text/css">
            @if (! empty($fontPath['regular']))
                @font-face {
                    src: url({{ $fontPath['regular'] }}) format('truetype');
                    font-family: {{ $fontFamily['regular'] }};
                }
            @endif

            @if (! empty($fontPath['bold']))
                @font-face {
                    src: url({{ $fontPath['bold'] }}) format('truetype');
                    font-family: {{ $fontFamily['bold'] }};
                    font-style: bold;
                }
            @endif

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: {{ $fontFamily['regular'] }};
            }

            body {
                font-size: 10px;
                line-height: 1.4;
                color: #172c1e;
                background: #ffffff;
                padding: 24px 28px;
            }

            b, th {
                font-family: {{ $fontFamily['bold'] }};
            }

            .header-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 18px;
                border-bottom: 2px solid #1d5b8f;
                padding-bottom: 12px;
            }

            .header-table td {
                vertical-align: top;
                border: none;
                padding: 0;
            }

            .brand-title {
                font-size: 24px;
                font-weight: bold;
                letter-spacing: 2px;
                color: #1d5b8f;
                text-transform: uppercase;
                margin-bottom: 3px;
            }

            .brand-subtitle {
                font-size: 9.5px;
                color: #566d5c;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .invoice-badge {
                text-align: right;
            }

            .invoice-title {
                font-size: 20px;
                font-weight: bold;
                color: #1d5b8f;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                margin-bottom: 4px;
            }

            .invoice-meta {
                font-size: 10px;
                color: #4a5e50;
            }

            .meta-grid-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 16px;
                background-color: #f7f9f6;
                border: 1px solid #dbe5dc;
                border-radius: 6px;
            }

            .meta-grid-table td {
                padding: 8px 12px;
                vertical-align: top;
                width: 25%;
                border-right: 1px solid #e2ece3;
            }

            .meta-grid-table td:last-child {
                border-right: none;
            }

            .meta-label {
                font-size: 8.5px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #5c7263;
                margin-bottom: 3px;
            }

            .meta-value {
                font-size: 11px;
                font-weight: bold;
                color: #173622;
            }

            .address-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 16px;
            }

            .address-table td {
                width: 50%;
                vertical-align: top;
                padding: 0;
            }

            .address-box {
                background: #ffffff;
                border: 1px solid #dbe5dc;
                border-radius: 6px;
                padding: 10px 14px;
            }

            .address-box.billing {
                margin-right: 8px;
                border-left: 3px solid #1d5b8f;
            }

            .address-box.shipping {
                margin-left: 8px;
                border-left: 3px solid #6b8473;
            }

            .address-header {
                font-size: 9.5px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: #1d5b8f;
                margin-bottom: 6px;
                border-bottom: 1px solid #eaf0eb;
                padding-bottom: 4px;
            }

            .address-content {
                font-size: 10px;
                line-height: 1.45;
                color: #293d2f;
            }

            .methods-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 16px;
                background-color: #f7f9f6;
                border: 1px solid #dbe5dc;
                border-radius: 6px;
            }

            .methods-table td {
                padding: 8px 14px;
                vertical-align: top;
                width: 50%;
                border-right: 1px solid #e2ece3;
            }

            .methods-table td:last-child {
                border-right: none;
            }

            .items-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 18px;
            }

            .items-table th {
                background-color: #1d5b8f;
                color: #ffffff;
                font-size: 9px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                padding: 8px 10px;
                text-align: left;
                border: 1px solid #1d5b8f;
            }

            .items-table td {
                padding: 8px 10px;
                font-size: 10px;
                border: 1px solid #e0eae1;
                vertical-align: middle;
            }

            .items-table tr:nth-child(even) td {
                background-color: #fafcf9;
            }

            .text-center {
                text-align: center !important;
            }

            .text-right {
                text-align: right !important;
            }

            .item-name {
                font-weight: bold;
                color: #173622;
                font-size: 10.5px;
                margin-bottom: 2px;
            }

            .item-sku {
                font-size: 8.5px;
                color: #647b6b;
            }

            .item-options {
                font-size: 8.5px;
                color: #556d5c;
                margin-top: 2px;
            }

            .summary-container {
                width: 100%;
                margin-bottom: 20px;
            }

            .summary-table {
                float: right;
                width: 280px;
                border-collapse: collapse;
                background-color: #f7f9f6;
                border: 1px solid #dbe5dc;
                border-radius: 6px;
            }

            .summary-table td {
                padding: 5px 12px;
                font-size: 9.5px;
                color: #293d2f;
                border: none;
            }

            .summary-table td:nth-child(2) {
                text-align: center;
                width: 15px;
            }

            .summary-table td:nth-child(3) {
                text-align: right;
                font-weight: 600;
            }

            .grand-total-row {
                background-color: #1d5b8f !important;
                color: #ffffff !important;
                font-weight: bold !important;
            }

            .grand-total-row td {
                color: #ffffff !important;
                font-size: 11px !important;
                font-weight: bold !important;
                padding: 8px 12px !important;
            }

            .footer-notes {
                clear: both;
                border-top: 1px solid #dbe5dc;
                padding-top: 12px;
                font-size: 8.5px;
                color: #6b7f71;
                text-align: center;
                line-height: 1.4;
            }

            .small-text {
                font-size: 7.5px;
                color: #738a7a;
            }
        </style>
    </head>

        @php
            $logoBase64 = null;
            $customLogoPath = core()->getConfigData('sales.invoice_settings.pdf_print_outs.logo');
            if ($customLogoPath && Storage::disk('public')->exists($customLogoPath)) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(Storage::disk('public')->get($customLogoPath));
            } elseif (file_exists(public_path('images/brand/soxnsox_logo_horizontal.png'))) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/brand/soxnsox_logo_horizontal.png')));
            } elseif (file_exists(public_path('storage/admin/logo.png'))) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/admin/logo.png')));
            } elseif (file_exists(public_path('storage/channel/1/logo.png'))) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/channel/1/logo.png')));
            }
        @endphp

        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 58%;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" style="max-height: 48px; max-width: 220px; margin-bottom: 6px; display: block;" alt="SOXNSOX" />
                    @else
                        <div class="brand-title">{{ core()->getConfigData('general.design.admin_logo.title') ?? 'SOXNSOX' }}</div>
                    @endif
                    <div class="brand-subtitle">India's Premier Bamboo &amp; Diabetic Socks &mdash; Official Tax Invoice</div>
                </td>
                <td class="invoice-badge" style="width: 42%;">
                    <div class="invoice-title">@lang('shop::app.customers.account.orders.invoice-pdf.invoice')</div>
                    <div class="invoice-meta">
                        <strong>Invoice #:</strong> #{{ $invoice->increment_id ?? $invoice->id }} &nbsp;|&nbsp;
                        <strong>Date:</strong> {{ core()->formatDate($invoice->created_at, 'd M, Y') }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Metadata Grid -->
        <table class="meta-grid-table">
            <tr>
                <td>
                    <div class="meta-label">@lang('shop::app.customers.account.orders.invoice-pdf.order-id')</div>
                    <div class="meta-value">#{{ $invoice->order->increment_id }}</div>
                </td>
                <td>
                    <div class="meta-label">@lang('shop::app.customers.account.orders.invoice-pdf.order-date')</div>
                    <div class="meta-value">{{ core()->formatDate($invoice->order->created_at, 'd M, Y') }}</div>
                </td>
                <td>
                    <div class="meta-label">Seller / Store</div>
                    <div class="meta-value">{{ core()->getConfigData('sales.shipping.origin.store_name') ?: 'Soxnsox Official Store' }}</div>
                </td>
                <td>
                    <div class="meta-label">Currency</div>
                    <div class="meta-value">{{ $orderCurrencyCode }}</div>
                </td>
            </tr>
        </table>

        <!-- Store Origin Details if configured -->
        @if (! empty(core()->getConfigData('sales.shipping.origin.country')) || ! empty(core()->getConfigData('sales.shipping.origin.bank_details')))
            <table class="meta-grid-table" style="margin-top: -8px;">
                <tr>
                    @if (! empty(core()->getConfigData('sales.shipping.origin.country')))
                        <td style="width: 50%;">
                            <div class="meta-label">Registered Office & Origin</div>
                            <div style="font-size: 9.5px; color: #293d2f; line-height: 1.4;">
                                {{ core()->getConfigData('sales.shipping.origin.address') }}<br>
                                {{ core()->getConfigData('sales.shipping.origin.zipcode') . ' ' . core()->getConfigData('sales.shipping.origin.city') }}, {{ core()->getConfigData('sales.shipping.origin.state') }}, {{ core()->getConfigData('sales.shipping.origin.country') }}
                            </div>
                        </td>
                    @endif

                    <td style="width: 50%;">
                        @if ($invoice->hasPaymentTerm())
                            <div style="margin-bottom: 6px;">
                                <div class="meta-label">@lang('shop::app.customers.account.orders.invoice-pdf.payment-terms')</div>
                                <div style="font-size: 9.5px; color: #293d2f;">{{ $invoice->getFormattedPaymentTerm() }}</div>
                            </div>
                        @endif

                        @if (core()->getConfigData('sales.shipping.origin.bank_details'))
                            <div>
                                <div class="meta-label">@lang('shop::app.customers.account.orders.invoice-pdf.bank-details')</div>
                                <div style="font-size: 9px; color: #293d2f;">{!! nl2br(core()->getConfigData('sales.shipping.origin.bank_details')) !!}</div>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        @endif

        <!-- Billing & Shipping Addresses -->
        <table class="address-table">
            <tr>
                @if ($invoice->order->billing_address)
                    <td>
                        <div class="address-box billing">
                            <div class="address-header">@lang('shop::app.customers.account.orders.invoice-pdf.bill-to')</div>
                            <div class="address-content">
                                <strong>{{ $invoice->order->billing_address->name }}</strong><br>
                                @if ($invoice->order->billing_address->company_name)
                                    {{ $invoice->order->billing_address->company_name }}<br>
                                @endif
                                {{ $invoice->order->billing_address->address1 }}<br>
                                @if ($invoice->order->billing_address->address2)
                                    {{ $invoice->order->billing_address->address2 }}<br>
                                @endif
                                {{ $invoice->order->billing_address->city }}, {{ $invoice->order->billing_address->state }} {{ $invoice->order->billing_address->postcode }}<br>
                                {{ core()->country_name($invoice->order->billing_address->country) }}<br>
                                <strong>@lang('shop::app.customers.account.orders.invoice-pdf.contact'):</strong> {{ $invoice->order->billing_address->phone }}
                            </div>
                        </div>
                    </td>
                @endif

                @if ($invoice->order->shipping_address)
                    <td>
                        <div class="address-box shipping">
                            <div class="address-header">@lang('shop::app.customers.account.orders.invoice-pdf.ship-to')</div>
                            <div class="address-content">
                                <strong>{{ $invoice->order->shipping_address->name }}</strong><br>
                                @if ($invoice->order->shipping_address->company_name)
                                    {{ $invoice->order->shipping_address->company_name }}<br>
                                @endif
                                {{ $invoice->order->shipping_address->address1 }}<br>
                                @if ($invoice->order->shipping_address->address2)
                                    {{ $invoice->order->shipping_address->address2 }}<br>
                                @endif
                                {{ $invoice->order->shipping_address->city }}, {{ $invoice->order->shipping_address->state }} {{ $invoice->order->shipping_address->postcode }}<br>
                                {{ core()->country_name($invoice->order->shipping_address->country) }}<br>
                                <strong>@lang('shop::app.customers.account.orders.invoice-pdf.contact'):</strong> {{ $invoice->order->shipping_address->phone }}
                            </div>
                        </div>
                    </td>
                @endif
            </tr>
        </table>

        <!-- Payment & Shipping Methods -->
        <table class="methods-table">
            <tr>
                <td>
                    <div class="meta-label">@lang('shop::app.customers.account.orders.invoice-pdf.payment-method')</div>
                    <div style="font-size: 10px; color: #173622; font-weight: 600;">
                        {{ core()->getConfigData('sales.payment_methods.' . $invoice->order->payment->method . '.title') ?? $invoice->order->payment->method_title ?? 'Online Payment' }}
                    </div>
                    @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($invoice->order->payment->method); @endphp
                    @if (! empty($additionalDetails))
                        <div class="small-text" style="margin-top: 2px;">
                            {{ $additionalDetails['title'] }}: {{ $additionalDetails['value'] }}
                        </div>
                    @endif
                </td>
                @if ($invoice->order->shipping_address)
                    <td>
                        <div class="meta-label">@lang('shop::app.customers.account.orders.invoice-pdf.shipping-method')</div>
                        <div style="font-size: 10px; color: #173622; font-weight: 600;">
                            {{ $invoice->order->shipping_title ?? 'Standard Delivery' }}
                        </div>
                    </td>
                @endif
            </tr>
        </table>

        <!-- Invoice Line Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 18%;">@lang('shop::app.customers.account.orders.invoice-pdf.sku')</th>
                    <th style="width: 44%;">@lang('shop::app.customers.account.orders.invoice-pdf.product-name')</th>
                    <th style="width: 14%;" class="text-right">@lang('shop::app.customers.account.orders.invoice-pdf.price')</th>
                    <th style="width: 8%;" class="text-center">@lang('shop::app.customers.account.orders.invoice-pdf.qty')</th>
                    <th style="width: 16%;" class="text-right">@lang('shop::app.customers.account.orders.invoice-pdf.subtotal')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>
                            <span class="item-sku">{{ $item->getTypeInstance()->getOrderedItem($item)->sku }}</span>
                        </td>
                        <td>
                            <div class="item-name">{{ $item->name }}</div>
                            @if (isset($item->additional['attributes']))
                                <div class="item-options">
                                    @foreach ($item->additional['attributes'] as $attribute)
                                        @if (! isset($attribute['attribute_type']) || $attribute['attribute_type'] !== 'file')
                                            <span><strong>{{ $attribute['attribute_name'] }}:</strong> {{ $attribute['option_label'] }}</span>@if(! $loop->last), @endif
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="text-right" style="color: #293d2f;">
                            @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                {!! core()->formatPrice($item->price_incl_tax, $orderCurrencyCode) !!}
                            @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                {!! core()->formatPrice($item->price_incl_tax, $orderCurrencyCode) !!}
                                <div class="small-text">
                                    @lang('shop::app.customers.account.orders.invoice-pdf.excl-tax'): {{ core()->formatPrice($item->price, $orderCurrencyCode) }}
                                </div>
                            @else
                                {!! core()->formatPrice($item->price, $orderCurrencyCode) !!}
                            @endif
                        </td>
                        <td class="text-center" style="font-weight: 600; color: #1d5b8f;">
                            {{ $item->qty }}
                        </td>
                        <td class="text-right" style="font-weight: bold; color: #173622;">
                            @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                {!! core()->formatPrice($item->total_incl_tax, $orderCurrencyCode) !!}
                            @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                {!! core()->formatPrice($item->total_incl_tax, $orderCurrencyCode) !!}
                                <div class="small-text">
                                    @lang('shop::app.customers.account.orders.invoice-pdf.excl-tax'): {{ core()->formatPrice($item->total, $orderCurrencyCode) }}
                                </div>
                            @else
                                {!! core()->formatPrice($item->total, $orderCurrencyCode) !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary & Totals Table -->
        <div class="summary-container">
            <table class="summary-table">
                <tbody>
                    @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.subtotal')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($invoice->sub_total_incl_tax, $orderCurrencyCode) !!}</td>
                        </tr>
                    @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.subtotal-incl-tax')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($invoice->sub_total_incl_tax, $orderCurrencyCode) !!}</td>
                        </tr>
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.subtotal-excl-tax')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($invoice->sub_total, $orderCurrencyCode) !!}</td>
                        </tr>
                    @else
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.subtotal')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($invoice->sub_total, $orderCurrencyCode) !!}</td>
                        </tr>
                    @endif

                    @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.shipping-handling')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($invoice->shipping_amount_incl_tax, $orderCurrencyCode) !!}</td>
                        </tr>
                    @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.shipping-handling-incl-tax')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($invoice->shipping_amount_incl_tax, $orderCurrencyCode) !!}</td>
                        </tr>
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.shipping-handling-excl-tax')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($invoice->shipping_amount, $orderCurrencyCode) !!}</td>
                        </tr>
                    @else
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.shipping-handling')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($invoice->shipping_amount, $orderCurrencyCode) !!}</td>
                        </tr>
                    @endif

                    @php
                        $storeState = core()->getConfigData('sales.shipping.origin.state') ?? 'MH';
                        $customerState = $invoice->order->shipping_address ? $invoice->order->shipping_address->state : ($invoice->order->billing_address ? $invoice->order->billing_address->state : '');
                        $isIgst = ($storeState !== $customerState);
                        $taxAmount = (float) $invoice->tax_amount;
                    @endphp
                    @if($taxAmount > 0)
                        @if($isIgst)
                            <tr>
                                <td>IGST</td>
                                <td>:</td>
                                <td>{!! core()->formatPrice($taxAmount, $orderCurrencyCode) !!}</td>
                            </tr>
                        @else
                            <tr>
                                <td>CGST (50%)</td>
                                <td>:</td>
                                <td>{!! core()->formatPrice($taxAmount / 2, $orderCurrencyCode) !!}</td>
                            </tr>
                            <tr>
                                <td>SGST (50%)</td>
                                <td>:</td>
                                <td>{!! core()->formatPrice($taxAmount / 2, $orderCurrencyCode) !!}</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.tax')</td>
                            <td>:</td>
                            <td>{!! core()->formatPrice($taxAmount, $orderCurrencyCode) !!}</td>
                        </tr>
                    @endif

                    @if ($invoice->discount_amount > 0)
                        <tr>
                            <td>@lang('shop::app.customers.account.orders.invoice-pdf.discount')</td>
                            <td>:</td>
                            <td style="color: #1d5b8f;">-{!! core()->formatPrice($invoice->discount_amount, $orderCurrencyCode) !!}</td>
                        </tr>
                    @endif

                    <tr class="grand-total-row">
                        <td>@lang('shop::app.customers.account.orders.invoice-pdf.grand-total')</td>
                        <td>:</td>
                        <td>{!! core()->formatPrice($invoice->grand_total, $orderCurrencyCode) !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Notice -->
        <div class="footer-notes">
            This is a computer-generated tax invoice and does not require a physical signature. For support or order inquiries, contact <strong>{{ core()->getSenderEmailDetails()['email'] ?? 'support@soxnsox.com' }}</strong>.<br>
            Thank you for shopping with Soxnsox. Pure by Nature, Made for You.
        </div>
    </body>
</html>
