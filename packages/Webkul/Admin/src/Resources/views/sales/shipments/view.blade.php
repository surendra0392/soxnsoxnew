<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.sales.shipments.view.title', ['shipment_id' => $shipment->id])
    </x-slot>

    @php $order = $shipment->order; @endphp

    <div class="grid">
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold leading-6 text-gray-800">
                @lang('admin::app.sales.shipments.view.title', ['shipment_id' => $shipment->id])
            </p>

            <div class="flex items-center gap-x-2.5">
                @php
                    $isDelhiveryActive = (bool) core()->getConfigData('sales.carriers.delhivery.active');
                @endphp

                @if ($isDelhiveryActive)
                    @if (empty($shipment->track_number))
                        <form
                            action="{{ route('admin.sales.shipments.delhivery.create', $shipment->id) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('Book shipment on Delhivery and generate AWB number?');"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="primary-button flex items-center gap-1.5 !bg-[#f29a38] !border-[#f29a38] hover:!bg-[#d98220]"
                            >
                                <span class="icon-ship text-xl"></span>
                                Push to Delhivery
                            </button>
                        </form>
                    @else
                        <a
                            href="{{ route('admin.sales.shipments.delhivery.label', $shipment->id) }}"
                            class="secondary-button flex items-center gap-1.5"
                            target="_blank"
                            title="Download Delhivery Shipping Label"
                        >
                            <span class="icon-product text-xl"></span>
                            Delhivery Label
                        </a>

                        <a
                            href="{{ route('admin.sales.shipments.delhivery.track', $shipment->id) }}"
                            class="secondary-button flex items-center gap-1.5 !text-blue-600"
                            target="_blank"
                            title="Live Track Package"
                        >
                            <span class="icon-view text-xl"></span>
                            Track on Delhivery
                        </a>
                    @endif
                @endif

                <!-- Print Packing Slip Button -->
                <a
                    href="{{ route('admin.sales.shipments.print', $shipment->id) }}"
                    class="secondary-button flex items-center gap-1.5"
                    target="_blank"
                >
                    <span class="icon-product text-xl"></span>
                    Print Packing Slip
                </a>

                <!-- Print Delivery Slip Button -->
                <a
                    href="{{ route('admin.sales.shipments.delivery_slip.print', $shipment->id) }}"
                    class="primary-button flex items-center gap-1.5"
                    target="_blank"
                >
                    <span class="icon-ship text-xl"></span>
                    Print Delivery Slip
                </a>

                <!-- Back Button -->
                <a
                    href="{{ route('admin.sales.shipments.index') }}"
                    class="transparent-button hover:bg-gray-200"
                >
                    @lang('admin::app.account.edit.back-btn')
                </a>
            </div>
        </div>
    </div>

    <!-- Filter row -->
    <div class="flex items-center justify-between gap-4 mt-4 max-md:flex-wrap">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
            <a
                href="{{ route('admin.sales.shipments.print', $shipment->id) }}"
                class="inline-flex w-full max-w-max cursor-pointer items-center justify-between gap-x-2 px-1 py-1.5 text-center font-semibold text-gray-600 transition-all hover:rounded-md hover:bg-gray-200"
                target="_blank"
            >
                <span class="text-2xl icon-product"></span>

                Print Packing Slip
            </a>

            <a
                href="{{ route('admin.sales.shipments.delivery_slip.print', $shipment->id) }}"
                class="inline-flex w-full max-w-max cursor-pointer items-center justify-between gap-x-2 px-1 py-1.5 text-center font-semibold text-gray-600 transition-all hover:rounded-md hover:bg-gray-200"
                target="_blank"
            >
                <span class="text-2xl icon-ship"></span>

                Print Delivery Slip
            </a>
        </div>
    </div>
        </div>
    </div>

    <!-- body content -->
    <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
        <!-- Left sub-component -->
        <div class="flex flex-col flex-1 gap-2 max-xl:flex-auto">
            <!-- General -->
            <div class="bg-white rounded box-shadow">
                <p class="p-4 mb-4 text-base font-semibold text-gray-800">
                    @lang('admin::app.sales.shipments.view.ordered-items') ({{count($shipment->items)}})
                </p>

                <div class="grid">
                    <!-- Shipment Items -->
                    @foreach ($shipment->items as $index => $item)
                        <div class="flex justify-between gap-2.5 px-4 py-6">
                            <div class="flex gap-2.5">
                                <!-- Image -->
                                @if ($item->product?->base_image_url)
                                    <img
                                        class="relative h-[60px] max-h-[60px] w-full max-w-[60px] rounded"
                                        src="{{ $item->product->base_image_url }}"
                                    >
                                @else
                                    <div class="relative h-[60px] max-h-[60px] w-full max-w-[60px] rounded border border-dashed border-gray-300">
                                        <img src="{{ bagisto_asset('images/product-placeholders/front.svg') }}">

                                        <p class="absolute bottom-1.5 w-full text-center text-[6px] font-semibold text-gray-400">
                                            @lang('admin::app.sales.invoices.view.product-image')
                                        </p>
                                    </div>
                                @endif

                                <div class="grid place-content-start gap-1.5">
                                    <p
                                        class="text-base font-semibold text-gray-800 break-all"
                                        v-pre
                                    >
                                        {{ $item->name }}
                                    </p>

                                    <div class="flex flex-col place-items-start gap-1.5">
                                        @if (isset($item->additional['attributes']))
                                            @foreach ($item->additional['attributes'] as $attribute)
                                                <p
                                                    class="text-gray-600"
                                                    v-pre
                                                >
                                                    @if (
                                                        ! isset($attribute['attribute_type'])
                                                        || $attribute['attribute_type'] !== 'file'
                                                    )
                                                        {{ $attribute['attribute_name'] }} : {{ $attribute['option_label'] }}
                                                    @else
                                                        {{ $attribute['attribute_name'] }} :

                                                        <a
                                                            href="{{ Storage::url($attribute['option_label']) }}"
                                                            class="text-[#133b63] hover:underline"
                                                            download="{{ File::basename($attribute['option_label']) }}"
                                                        >
                                                            {{ File::basename($attribute['option_label']) }}
                                                        </a>
                                                    @endif
                                                </p>
                                            @endforeach
                                        @endif

                                        <p class="text-gray-600">
                                            @lang('admin::app.sales.shipments.view.sku', ['sku' =>  $item->sku ])
                                        </p>

                                        <p class="text-gray-600">
                                            @lang('admin::app.sales.shipments.view.qty', ['qty' =>  $item->qty ])
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($index < count($shipment->items) - 1)
                            <span class="block w-full border-b"></span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right sub-component -->
        <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
            <!-- component 1 -->
            <x-admin::accordion>
                <x-slot:header>
                    <p class="p-2.5 text-base font-semibold text-gray-600">
                        @lang('admin::app.sales.shipments.view.customer')
                    </p>
                </x-slot>

                <x-slot:content v-pre>
                    <div class="flex flex-col pb-4">
                        <!-- Customer Full Name -->
                        <p 
                            class="font-semibold text-gray-800"
                            v-text="'{{ $shipment->order->customer_full_name }}'"
                        >
                        </p>

                        <!-- Customer Email -->
                        <p class="text-gray-600">
                            @lang('admin::app.sales.shipments.view.email', ['email' =>  $shipment->order->customer_email ])
                        </p>
                    </div>

                    <span class="block w-full border-b"></span>

                    @if ($order->billing_address || $order->shipping_address)
                        <!-- Billing Address -->
                        @if ($order->billing_address)
                            <div class="flex items-center justify-between">
                                <p class="py-4 text-base font-semibold text-gray-600">
                                    @lang('admin::app.sales.shipments.view.billing-address')
                                </p>
                            </div>

                            @include ('admin::sales.address', ['address' => $order->billing_address])

                        @endif

                        <!-- Shipping Address -->
                        @if ($order->shipping_address)
                            <span class="block w-full mt-4 border-b"></span>

                            <div class="flex items-center justify-between">
                                <p class="py-4 text-base font-semibold text-gray-600">
                                    @lang('admin::app.sales.shipments.view.shipping-address')
                                </p>
                            </div>

                            @include ('admin::sales.address', ['address' => $order->shipping_address])

                        @endif
                    @endif
                </x-slot>
            </x-admin::accordion>

            <!-- component 2 -->
            <x-admin::accordion>
                <x-slot:header>
                    <p class="p-2.5 text-base font-semibold text-gray-600">
                        @lang('admin::app.sales.shipments.view.order-information')
                    </p>
                </x-slot>

                <x-slot:content>
                    <div class="flex justify-start w-full gap-5">
                        <div class="flex flex-col gap-y-1.5">
                            <p class="text-gray-600">
                                @lang('admin::app.sales.shipments.view.order-id')
                            </p>

                            <p class="text-gray-600">
                                @lang('admin::app.sales.shipments.view.order-date')
                           </p>

                            <p class="text-gray-600">
                                @lang('admin::app.sales.shipments.view.order-status')
                            </p>

                            <p class="text-gray-600">
                                @lang('admin::app.sales.shipments.view.channel')
                            </p>
                        </div>

                        <div class="flex flex-col gap-y-1.5">
                            <!-- Order Id -->
                            <p class="font-semibold text-[#133b63]">
                                <a href="{{ route('admin.sales.orders.view', $order->id) }}">
                                    #{{ $order->increment_id }}
                                </a>
                            </p>

                            <!-- Order Date -->
                            <p class="text-gray-600">
                                {{ core()->formatDate($order->created_at) }}
                            </p>

                            <!-- Order Status -->
                            <p class="text-gray-600">
                                {{ $order->status_label }}
                            </p>

                            <!-- Order Channel -->
                            <p 
                                class="text-gray-600"
                                v-pre
                            >
                                {{ $order->channel_name }}
                            </p>
                        </div>
                    </div>
                </x-slot>
            </x-admin::accordion>

            <!-- Component 3 -->
            <x-admin::accordion>
                <x-slot:header>
                    <p class="p-2.5 text-base font-semibold text-gray-600">
                        @lang('admin::app.sales.shipments.view.payment-and-shipping')
                    </p>
                </x-slot>

                <x-slot:content>
                    <div class="pb-4">
                        <!-- Payment method -->
                        <p class="font-semibold text-gray-800">
                            {{ core()->getConfigData('sales.payment_methods.' . $order->payment->method . '.title') }}
                        </p>

                        <p class="text-gray-600">
                            @lang('admin::app.sales.shipments.view.payment-method')
                        </p>

                        <!-- Currency Code -->
                        <p class="pt-4 font-semibold text-gray-800">
                            {{ $order->order_currency_code }}
                        </p>

                        <p class="text-gray-600">
                            @lang('admin::app.sales.shipments.view.currency')
                        </p>
                    </div>

                    <!-- Horizontal Line -->
                    <span class="block w-full border-b"></span>

                    <div class="pt-4">
                        <!-- Shipping Method -->
                        <p
                            class="font-semibold text-gray-800"
                            v-pre
                        >
                            {{ $order->shipping_title }}
                        </p>

                        <p class="text-gray-600">
                            @lang('admin::app.sales.shipments.view.shipping-method')
                        </p>

                        <!-- Inventory Source -->
                        <p class="pt-4 font-semibold text-gray-800">
                            {{ core()->formatBasePrice($order->base_shipping_amount) }}
                        </p>

                        <p class="text-gray-600">
                            @lang('admin::app.sales.shipments.view.shipping-price')
                        </p>

                        @if (
                            $shipment->inventory_source
                            || $shipment->inventory_source_name
                        )
                            <p
                                class="pt-4 font-semibold text-gray-800"
                                v-pre
                            >
                                {{ $shipment->inventory_source ? $shipment->inventory_source->name : $shipment->inventory_source_name }}
                            </p>

                            <p class="text-gray-600">
                                @lang('admin::app.sales.shipments.view.inventory-source')
                            </p>
                        @endif

                        @if ($shipment->carrier_title)
                            <p
                                class="pt-4 font-semibold text-gray-800"
                                v-pre
                            >
                                {{ $shipment->carrier_title }}
                            </p>

                            <p class="text-gray-600">
                                @lang('admin::app.sales.shipments.view.carrier-title')
                            </p>
                        @endif

                        @if ($shipment->track_number)
                            <p class="pt-4 font-semibold text-[#133b63]">
                                <a
                                    href="https://www.delhivery.com/track/package/{{ $shipment->track_number }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-1.5 text-[#1d5b8f] hover:underline"
                                    title="Track package on Delhivery"
                                >
                                    {{ $shipment->track_number }}
                                    <span class="icon-view text-base"></span>
                                </a>
                            </p>

                            <p class="text-gray-600">
                                @lang('admin::app.sales.shipments.view.tracking-number')
                            </p>
                        @endif
                    </div>
                </x-slot>
            </x-admin::accordion>
        </div>
    </div>
</x-admin::layouts>
