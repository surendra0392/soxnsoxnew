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
            $fontFamily = [
                'regular' => 'DejaVu Sans, Arial, sans-serif',
                'bold'    => 'DejaVu Sans, Arial, sans-serif',
            ];
        @endphp

        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: {{ $fontFamily['regular'] }};
            }

            body {
                font-size: 11px;
                line-height: 1.4;
                color: #1c2b20;
                background: #ffffff;
                padding: 24px 28px;
            }

            .header-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                border-bottom: 2px solid #133b63;
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
                color: #133b63;
                text-transform: uppercase;
                margin-bottom: 4px;
            }

            .brand-subtitle {
                font-size: 10px;
                color: #5b6f61;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .slip-badge {
                text-align: right;
            }

            .slip-title {
                font-size: 20px;
                font-weight: bold;
                color: #133b63;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                margin-bottom: 4px;
            }

            .slip-meta {
                font-size: 10px;
                color: #4a5d50;
            }

            .meta-grid-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 18px;
                background-color: #f7f9f6;
                border: 1px solid #dbe5dc;
                border-radius: 6px;
            }

            .meta-grid-table td {
                padding: 10px 14px;
                vertical-align: top;
                width: 25%;
                border-right: 1px solid #e2ece3;
            }

            .meta-grid-table td:last-child {
                border-right: none;
            }

            .meta-label {
                font-size: 9px;
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
                margin-bottom: 20px;
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
                padding: 12px 16px;
            }

            .address-box.shipping {
                margin-right: 8px;
                border-left: 3px solid #133b63;
            }

            .address-box.billing {
                margin-left: 8px;
                border-left: 3px solid #8ba091;
            }

            .address-header {
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: #133b63;
                margin-bottom: 8px;
                border-bottom: 1px solid #eaf0eb;
                padding-bottom: 4px;
            }

            .address-content {
                font-size: 10px;
                line-height: 1.5;
                color: #293d2f;
            }

            .items-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 22px;
            }

            .items-table th {
                background-color: #133b63;
                color: #ffffff;
                font-size: 9px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                padding: 8px 10px;
                text-align: left;
                border: 1px solid #133b63;
            }

            .items-table td {
                padding: 9px 10px;
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
                font-size: 11px;
                margin-bottom: 2px;
            }

            .item-sku {
                font-size: 9px;
                color: #647b6b;
            }

            .item-options {
                font-size: 9px;
                color: #556d5c;
                margin-top: 2px;
            }

            .qty-badge {
                font-size: 12px;
                font-weight: bold;
                color: #133b63;
            }

            .check-box {
                width: 14px;
                height: 14px;
                border: 1.5px solid #8ca292;
                border-radius: 2px;
                display: inline-block;
            }

            .summary-bar {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 24px;
                background-color: #f7f9f6;
                border: 1px solid #dbe5dc;
            }

            .summary-bar td {
                padding: 8px 14px;
                font-size: 10px;
            }

            .sign-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
                margin-bottom: 20px;
            }

            .sign-table td {
                width: 33.33%;
                vertical-align: top;
                padding: 0 8px;
            }

            .sign-table td:first-child {
                padding-left: 0;
            }

            .sign-table td:last-child {
                padding-right: 0;
            }

            .sign-box {
                border: 1px dashed #a4b7a9;
                border-radius: 4px;
                padding: 10px 12px;
                height: 52px;
                background-color: #fdfefd;
            }

            .sign-title {
                font-size: 8px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #5c7263;
                margin-bottom: 18px;
            }

            .sign-line {
                border-bottom: 1px solid #a4b7a9;
            }

            .footer-notes {
                border-top: 1px solid #dbe5dc;
                padding-top: 10px;
                font-size: 8.5px;
                color: #6b7f71;
                text-align: center;
                line-height: 1.4;
            }
        </style>
    </head>

    <body>
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

        @php
            $items = $shipment ? $shipment->items : $order->items;
            $slipNumber = $shipment ? 'PK-' . str_pad($shipment->id, 6, '0', STR_PAD_LEFT) : 'PK-ORD-' . $order->increment_id;
            $slipDate = $shipment ? $shipment->created_at : $order->created_at;
            $carrierTitle = $shipment?->carrier_title ?? $order->shipping_title ?? 'Standard Delivery';
            $trackNumber = $shipment?->track_number ?: 'Pending / Local Delivery';
            $sourceName = $shipment?->inventory_source?->name ?? $shipment?->inventory_source_name ?? 'Soxnsox Central Warehouse';
            $totalUnits = $shipment?->total_qty ?? ($order->total_qty_ordered ?: $order->items->sum('qty_ordered'));
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
                    <div class="brand-subtitle">India's Premier Bamboo & Diabetic Socks • Packing Slip</div>
                </td>
                <td class="slip-badge" style="width: 42%;">
                    <div class="slip-title">PACKING SLIP</div>
                    <div class="slip-meta">
                        <strong>Slip #:</strong> {{ $slipNumber }} &nbsp;|&nbsp;
                        <strong>Date:</strong> {{ core()->formatDate($slipDate, 'd M, Y') }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Logistics Overview Grid -->
        <table class="meta-grid-table">
            <tr>
                <td>
                    <div class="meta-label">Order Number</div>
                    <div class="meta-value">#{{ $order->increment_id }}</div>
                </td>
                <td>
                    <div class="meta-label">Order Date</div>
                    <div class="meta-value">{{ core()->formatDate($order->created_at, 'd M, Y') }}</div>
                </td>
                <td>
                    <div class="meta-label">Carrier & Method</div>
                    <div class="meta-value">{{ $carrierTitle }}</div>
                </td>
                <td>
                    <div class="meta-label">Tracking Number</div>
                    <div class="meta-value">{{ $trackNumber }}</div>
                </td>
            </tr>
        </table>

        <!-- Address Cards -->
        <table class="address-table">
            <tr>
                <td>
                    <div class="address-box shipping">
                        <div class="address-header">Ship To (Recipient)</div>
                        <div class="address-content">
                            @if ($order->shipping_address)
                                <strong>{{ $order->shipping_address->name }}</strong><br>
                                @if ($order->shipping_address->company_name)
                                    {{ $order->shipping_address->company_name }}<br>
                                @endif
                                {{ $order->shipping_address->address1 }}<br>
                                @if ($order->shipping_address->address2)
                                    {{ $order->shipping_address->address2 }}<br>
                                @endif
                                {{ $order->shipping_address->city }}, {{ $order->shipping_address->state }} {{ $order->shipping_address->postcode }}<br>
                                {{ core()->country_name($order->shipping_address->country) }}<br>
                                <strong>Phone:</strong> {{ $order->shipping_address->phone }}
                            @else
                                <em>No shipping address specified</em>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div class="address-box billing">
                        <div class="address-header">Billing Information</div>
                        <div class="address-content">
                            @if ($order->billing_address)
                                <strong>{{ $order->billing_address->name }}</strong><br>
                                @if ($order->billing_address->company_name)
                                    {{ $order->billing_address->company_name }}<br>
                                @endif
                                {{ $order->billing_address->address1 }}<br>
                                @if ($order->billing_address->address2)
                                    {{ $order->billing_address->address2 }}<br>
                                @endif
                                {{ $order->billing_address->city }}, {{ $order->billing_address->state }} {{ $order->billing_address->postcode }}<br>
                                {{ core()->country_name($order->billing_address->country) }}<br>
                                <strong>Email:</strong> {{ $order->customer_email }}
                            @else
                                <em>Same as shipping address</em>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;" class="text-center">#</th>
                    <th style="width: 20%;">SKU</th>
                    <th style="width: 45%;">Product Description</th>
                    <th style="width: 10%;" class="text-center">Ordered</th>
                    <th style="width: 10%;" class="text-center">Qty to Pack</th>
                    <th style="width: 10%;" class="text-center">Verified</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $item)
                    <tr>
                        <td class="text-center" style="color: #647b6b; font-weight: bold;">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <span class="item-sku">{{ $item->sku ?? $item->getTypeInstance()->getOrderedItem($item)->sku ?? '' }}</span>
                        </td>
                        <td>
                            <div class="item-name">{{ $item->name }}</div>
                            @if (! empty($item->additional['attributes']))
                                <div class="item-options">
                                    @foreach ($item->additional['attributes'] as $attribute)
                                        <span><strong>{{ $attribute['attribute_name'] }}:</strong> {{ $attribute['option_label'] }}</span>@if(! $loop->last), @endif
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="text-center" style="font-weight: 600; color: #4a5d50;">
                            {{ $item->order_item->qty_ordered ?? $item->qty_ordered ?? $item->qty }}
                        </td>
                        <td class="text-center">
                            <span class="qty-badge">{{ $item->qty ?? $item->qty_ordered }}</span>
                        </td>
                        <td class="text-center">
                            <div class="check-box"></div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Shipped Summary Bar -->
        <table class="summary-bar">
            <tr>
                <td>
                    <strong>Fulfillment Source:</strong>
                    {{ $sourceName }}
                </td>
                <td class="text-right">
                    <strong>Total Line Items:</strong> {{ count($items) }} &nbsp;&nbsp;|&nbsp;&nbsp;
                    <strong>Total Units in Package:</strong> <span style="font-size: 12px; font-weight: bold; color: #133b63;">{{ $totalUnits }}</span>
                </td>
            </tr>
        </table>

        <!-- Warehouse Verification Sign-Off -->
        <table class="sign-table">
            <tr>
                <td>
                    <div class="sign-box">
                        <div class="sign-title">Packed By (Warehouse Associate)</div>
                        <div class="sign-line"></div>
                    </div>
                </td>
                <td>
                    <div class="sign-box">
                        <div class="sign-title">Inspected / Quality Checked By</div>
                        <div class="sign-line"></div>
                    </div>
                </td>
                <td>
                    <div class="sign-box">
                        <div class="sign-title">Dispatch Date & Courier Handover</div>
                        <div class="sign-line"></div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Footer Notice -->
        <div class="footer-notes">
            Please inspect all packages upon arrival. For questions regarding this shipment or to request a return, contact our support team at <strong>{{ core()->getSenderEmailDetails()['email'] ?? 'support@soxnsox.com' }}</strong>.<br>
            Thank you for choosing Soxnsox. Pure by Nature, Made for You.
        </div>
    </body>
</html>
