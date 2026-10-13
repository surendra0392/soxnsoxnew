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
                color: #172c1e;
                background: #ffffff;
                padding: 24px 28px;
            }

            .header-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 18px;
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
                margin-bottom: 3px;
            }

            .brand-subtitle {
                font-size: 10px;
                color: #566d5c;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .slip-badge {
                text-align: right;
            }

            .slip-title {
                font-size: 18px;
                font-weight: bold;
                color: #133b63;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 3px;
            }

            .slip-meta {
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

            .highlight-badge {
                display: inline-block;
                padding: 2px 6px;
                border-radius: 3px;
                font-size: 9.5px;
                font-weight: bold;
            }

            .badge-prepaid {
                background-color: #e3f3e9;
                color: #1e5a33;
                border: 1px solid #c2e2cc;
            }

            .badge-cod {
                background-color: #fcf4e8;
                color: #92540b;
                border: 1px solid #f2ddbf;
            }

            .delivery-card {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 18px;
                border: 1px solid #dbe5dc;
                border-left: 4px solid #133b63;
                border-radius: 6px;
                background-color: #ffffff;
            }

            .delivery-card td {
                padding: 12px 16px;
                vertical-align: top;
            }

            .card-heading {
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: #133b63;
                margin-bottom: 6px;
                border-bottom: 1px solid #eaf0eb;
                padding-bottom: 4px;
            }

            .card-body {
                font-size: 11px;
                line-height: 1.5;
                color: #293d2f;
            }

            .items-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 18px;
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
                font-size: 10.5px;
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

            .summary-bar {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 18px;
                background-color: #f7f9f6;
                border: 1px solid #dbe5dc;
            }

            .summary-bar td {
                padding: 8px 14px;
                font-size: 10px;
            }

            .pod-container {
                border: 1.5px solid #133b63;
                border-radius: 6px;
                padding: 12px 16px;
                background-color: #fcfdfc;
                margin-bottom: 16px;
            }

            .pod-title {
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #133b63;
                margin-bottom: 6px;
            }

            .pod-declaration {
                font-size: 9px;
                color: #4b6051;
                line-height: 1.4;
                margin-bottom: 14px;
                font-style: italic;
            }

            .pod-table {
                width: 100%;
                border-collapse: collapse;
            }

            .pod-table td {
                width: 50%;
                vertical-align: top;
                padding: 0 10px;
            }

            .pod-table td:first-child {
                padding-left: 0;
            }

            .pod-table td:last-child {
                padding-right: 0;
            }

            .pod-field {
                margin-bottom: 12px;
            }

            .pod-field-label {
                font-size: 8.5px;
                font-weight: bold;
                text-transform: uppercase;
                color: #5c7263;
                margin-bottom: 4px;
            }

            .pod-field-line {
                border-bottom: 1px solid #94aa9a;
                height: 18px;
            }

            .checkbox-group {
                font-size: 9.5px;
                color: #2b3e31;
                margin-top: 4px;
            }

            .check-square {
                width: 12px;
                height: 12px;
                border: 1.5px solid #5c7263;
                border-radius: 2px;
                display: inline-block;
                margin-right: 4px;
                vertical-align: middle;
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

            $items = $shipment ? $shipment->items : $order->items;
            $slipNumber = $shipment ? 'DS-' . str_pad($shipment->id, 6, '0', STR_PAD_LEFT) : 'DS-ORD-' . $order->increment_id;
            $slipDate = $shipment ? $shipment->created_at : $order->created_at;
            $carrierTitle = $shipment?->carrier_title ?? $order->shipping_title ?? 'Express Delivery';
            $trackNumber = $shipment?->track_number ?: 'Local / Direct Handover';
            $sourceName = $shipment?->inventory_source?->name ?? $shipment?->inventory_source_name ?? 'Soxnsox Central Hub';
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
                    <div class="brand-subtitle">India's Premier Bamboo & Diabetic Socks • Delivery Challan</div>
                </td>
                <td class="slip-badge" style="width: 42%;">
                    <div class="slip-title">DELIVERY SLIP</div>
                    <div class="slip-meta">
                        <strong>Delivery Doc #:</strong> {{ $slipNumber }} &nbsp;|&nbsp;
                        <strong>Date:</strong> {{ core()->formatDate($slipDate, 'd M, Y') }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Logistics Overview Grid -->
        <table class="meta-grid-table">
            <tr>
                <td>
                    <div class="meta-label">Order Reference</div>
                    <div class="meta-value">#{{ $order->increment_id }}</div>
                </td>
                <td>
                    <div class="meta-label">Order Date</div>
                    <div class="meta-value">{{ core()->formatDate($order->created_at, 'd M, Y') }}</div>
                </td>
                <td>
                    <div class="meta-label">Logistics Carrier</div>
                    <div class="meta-value">{{ $carrierTitle }}</div>
                </td>
                <td>
                    <div class="meta-label">Payment Status</div>
                    <div class="meta-value">
                        @if ($order->payment && $order->payment->method === 'cashondelivery')
                            <span class="highlight-badge badge-cod">
                                COD: {{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}
                            </span>
                        @else
                            <span class="highlight-badge badge-prepaid">
                                PREPAID (Collect: {{ core()->formatPrice(0, $order->order_currency_code) }})
                            </span>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <!-- Destination Address Card -->
        <table class="delivery-card">
            <tr>
                <td style="width: 65%;">
                    <div class="card-heading">Delivery Destination (Deliver To)</div>
                    <div class="card-body">
                        @if ($order->shipping_address)
                            <strong style="font-size: 12px; color: #173622;">{{ $order->shipping_address->name }}</strong><br>
                            @if ($order->shipping_address->company_name)
                                <span>{{ $order->shipping_address->company_name }}</span><br>
                            @endif
                            <span>{{ $order->shipping_address->address1 }}</span><br>
                            @if ($order->shipping_address->address2)
                                <span>{{ $order->shipping_address->address2 }}</span><br>
                            @endif
                            <span>{{ $order->shipping_address->city }}, {{ $order->shipping_address->state }} {{ $order->shipping_address->postcode }}</span><br>
                            <span>{{ core()->country_name($order->shipping_address->country) }}</span>
                        @else
                            <em>No delivery address specified</em>
                        @endif
                    </div>
                </td>
                <td style="width: 35%; border-left: 1px solid #eef3ef;">
                    <div class="card-heading">Contact & Tracking</div>
                    <div class="card-body">
                        <strong>Customer Phone:</strong><br>
                        <span style="font-size: 11px; color: #133b63; font-weight: bold;">
                            {{ $order->shipping_address?->phone ?? 'N/A' }}
                        </span><br><br>
                        <strong>Tracking Number:</strong><br>
                        <span>{{ $trackNumber }}</span><br><br>
                        <strong>Email:</strong><br>
                        <span>{{ $order->customer_email }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Shipped Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 6%;" class="text-center">#</th>
                    <th style="width: 22%;">SKU</th>
                    <th style="width: 52%;">Product Description</th>
                    <th style="width: 10%;" class="text-center">Qty</th>
                    <th style="width: 10%;" class="text-center">Delivered</th>
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
                        <td class="text-center">
                            <span class="qty-badge">{{ $item->qty ?? $item->qty_ordered }}</span>
                        </td>
                        <td class="text-center">
                            <div class="check-square"></div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Bar -->
        <table class="summary-bar">
            <tr>
                <td>
                    <strong>Dispatch Hub:</strong>
                    {{ $sourceName }}
                </td>
                <td class="text-right">
                    <strong>Total Line Items:</strong> {{ count($items) }} &nbsp;&nbsp;|&nbsp;&nbsp;
                    <strong>Total Delivered Units:</strong> <span style="font-size: 12px; font-weight: bold; color: #133b63;">{{ $totalUnits }}</span>
                </td>
            </tr>
        </table>

        <!-- Proof of Delivery (POD) Sign-Off Box -->
        <div class="pod-container">
            <div class="pod-title">Acknowledgment & Proof of Delivery (POD)</div>
            <div class="pod-declaration">
                "I hereby confirm that I have received the parcel(s) and items listed above in good physical condition with original seals intact."
            </div>

            <table class="pod-table">
                <tr>
                    <td>
                        <div class="pod-field">
                            <div class="pod-field-label">Received By (Print Full Name)</div>
                            <div class="pod-field-line"></div>
                        </div>

                        <div class="pod-field">
                            <div class="pod-field-label">Receiver's Contact / Phone Number</div>
                            <div class="pod-field-line"></div>
                        </div>

                        <div class="checkbox-group">
                            <span class="check-square"></span> Parcel Intact &amp; Undamaged &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="check-square"></span> Discrepancy Noted
                        </div>
                    </td>
                    <td>
                        <div class="pod-field">
                            <div class="pod-field-label">Receiver's Signature</div>
                            <div class="pod-field-line"></div>
                        </div>

                        <div class="pod-field">
                            <div class="pod-field-label">Date &amp; Time of Handover</div>
                            <div class="pod-field-line"></div>
                        </div>

                        <div class="pod-field">
                            <div class="pod-field-label">Courier Executive Name &amp; Signature</div>
                            <div class="pod-field-line"></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer Notice -->
        <div class="footer-notes">
            For support, damage claims, or return assistance within 48 hours of delivery, please contact <strong>{{ core()->getSenderEmailDetails()['email'] ?? 'support@soxnsox.com' }}</strong>.<br>
            Thank you for shopping with Soxnsox. Pure by Nature, Made for You.
        </div>
    </body>
</html>
