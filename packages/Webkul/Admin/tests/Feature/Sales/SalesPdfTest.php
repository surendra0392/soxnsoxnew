<?php

use Webkul\Sales\Models\Invoice;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Models\Shipment;
use Webkul\User\Models\Admin;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $admin = Admin::first() ?? Admin::factory()->create();
    actingAs($admin, 'admin');
});

it('should successfully download the invoice PDF from admin', function () {
    $invoice = Invoice::first();

    if (! $invoice) {
        $order = Order::factory()->create();
        $invoice = Invoice::factory()->create(['order_id' => $order->id]);
    }

    $response = get(route('admin.sales.invoices.print', $invoice->id));

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

it('should successfully download the shipment packing slip PDF from admin', function () {
    $shipment = Shipment::first();

    if (! $shipment) {
        $order = Order::factory()->create();
        $shipment = Shipment::factory()->create(['order_id' => $order->id]);
    }

    $response = get(route('admin.sales.shipments.print', $shipment->id));

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

it('should successfully download the shipment delivery slip PDF from admin', function () {
    $shipment = Shipment::first();

    if (! $shipment) {
        $order = Order::factory()->create();
        $shipment = Shipment::factory()->create(['order_id' => $order->id]);
    }

    $response = get(route('admin.sales.shipments.delivery_slip.print', $shipment->id));

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

it('should successfully download the order-level packing slip PDF from admin', function () {
    $order = Order::first();

    if (! $order) {
        $order = Order::factory()->create();
    }

    $response = get(route('admin.sales.orders.print', $order->id));

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

it('should successfully download the order-level delivery slip PDF from admin', function () {
    $order = Order::first();

    if (! $order) {
        $order = Order::factory()->create();
    }

    $response = get(route('admin.sales.orders.delivery_slip.print', $order->id));

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});
