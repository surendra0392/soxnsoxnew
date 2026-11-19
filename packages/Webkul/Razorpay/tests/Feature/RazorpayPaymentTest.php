<?php

use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\Cart as CartModel;
use Webkul\Core\Models\CoreConfig;
use Webkul\Razorpay\Payment\RazorpayPayment;
use Webkul\Sales\Models\Invoice;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Models\OrderTransaction;

beforeEach(function () {
    CoreConfig::where('code', 'like', 'sales.payment_methods.razorpay.%')->delete();
    CoreConfig::where('code', 'sales.order_settings.minimum_order.enable')->delete();
    cache()->flush();

    CoreConfig::factory()->create([
        'code' => 'sales.order_settings.minimum_order.enable',
        'value' => '0',
        'channel_code' => 'default',
    ]);

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.active',
        'value' => '1',
        'channel_code' => 'default',
    ]);

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.sandbox',
        'value' => '1',
        'channel_code' => 'default',
    ]);

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.test_client_id',
        'value' => 'rzp_test_fake_key',
        'channel_code' => 'default',
    ]);

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.test_client_secret',
        'value' => 'fake_test_secret',
        'channel_code' => 'default',
    ]);
});

it('redirects back when razorpay credentials are invalid', function () {
    // Arrange
    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.test_client_id',
        'value' => '',
        'channel_code' => 'default',
    ]);

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.test_client_secret',
        'value' => '',
        'channel_code' => 'default',
    ]);

    // Act
    $response = $this->get(route('razorpay.payment.redirect'));

    // Assert
    $response->assertRedirect();

    $response->assertSessionHas('error');
});

it('redirects back when cart is not found', function () {
    // Arrange
    Cart::shouldReceive('getCart')->andReturn(null);

    // Act
    $response = $this->get(route('razorpay.payment.redirect'));

    // Assert
    $response->assertRedirect();

    $response->assertSessionHas('error');
});

it('creates razorpay order and returns drop-in UI view', function () {
    // Arrange
    $cart = $this->createCartWithItems('razorpay', ['base_currency_code' => 'INR']);

    // Mock RazorpayPayment class to avoid actual API calls
    $mockRazorpay = $this->mock(RazorpayPayment::class)->makePartial();

    $mockRazorpay->shouldReceive('createOrder')->andReturn([
        'id' => 'order_test123',
        'amount' => 33415,
        'currency' => 'INR',
        'receipt' => 'receipt_'.$cart->id,
    ]);

    $mockRazorpay->shouldReceive('preparePaymentData')->andReturn([
        'key' => 'test_key',
        'amount' => 33415,
        'currency' => 'INR',
        'order_id' => 'order_test123',
    ]);

    $this->app->instance(RazorpayPayment::class, $mockRazorpay);

    // Act
    $response = $this->get(route('razorpay.payment.redirect'));

    // Assert
    $response->assertOk();

    $response->assertViewIs('razorpay::drop-in-ui');

    $response->assertViewHas('payment');
});

it('successfully processes razorpay payment and creates order with invoice', function () {
    // Arrange
    $cart = $this->createCartWithItems('razorpay', ['base_currency_code' => 'INR']);

    // Mock the RazorpayPayment methods
    $mockRazorpay = $this->mock(RazorpayPayment::class)->makePartial();

    $mockRazorpay->shouldReceive('verifySignature')->andReturn(true);
    $mockRazorpay->shouldReceive('verifyCapturedPayment')->andReturn(true);

    $this->app->instance(RazorpayPayment::class, $mockRazorpay);

    // Act
    $response = $this->get(route('razorpay.payment.success', [
        'razorpay_payment_id' => 'pay_test123',
        'razorpay_order_id' => 'order_test123',
        'razorpay_signature' => 'test_signature',
    ]));

    // Assert
    $response->assertRedirect(route('shop.checkout.onepage.success'));

    // Verify order was created
    $order = Order::where('cart_id', $cart->id)->first();

    expect($order)->not->toBeNull()
        ->and($order->status)->toBe('processing')
        ->and($order->customer_id)->toBe($cart->customer_id);

    // Verify invoice was created
    $invoice = Invoice::where('order_id', $order->id)->first();

    expect($invoice)->not->toBeNull()
        ->and($invoice->state)->toBe('paid');

    // Verify order transaction was created
    $orderTransaction = OrderTransaction::where('order_id', $order->id)->first();

    expect($orderTransaction)->not->toBeNull()
        ->and($orderTransaction->transaction_id)->toBe('pay_test123')
        ->and($orderTransaction->status)->toBe('captured')
        ->and($orderTransaction->type)->toBe('razorpay');
});

it('handles payment failure gracefully', function () {
    // Act
    $response = $this->get(route('razorpay.payment.success', [
        'razorpay_order_id' => 'order_fail_123',
        'error' => 'payment_failed',
    ]));

    // Assert
    $response->assertRedirect(route('shop.checkout.cart.index'));

    $response->assertSessionHas('error');
});

it('redirects to cart when signature verification fails', function () {
    // Arrange
    $cart = CartModel::factory()->create([
        'base_grand_total' => 100.00,
    ]);

    // Mock invalid signature
    $mockRazorpay = $this->mock(RazorpayPayment::class)->makePartial();

    $mockRazorpay->shouldReceive('verifySignature')->andReturn(false);

    $this->app->instance(RazorpayPayment::class, $mockRazorpay);

    // Act
    $response = $this->get(route('razorpay.payment.success', [
        'razorpay_payment_id' => 'pay_test_456',
        'razorpay_order_id' => 'order_test_456',
        'razorpay_signature' => 'invalid_signature',
    ]));

    // Assert
    $response->assertRedirect(route('shop.checkout.cart.index'));

    $response->assertSessionHas('error');
});

it('rejects amounts below 100 paise on api create-order endpoint', function () {
    $this->postJson(route('razorpay.api.create_order'), [
        'amount' => 99,
        'currency' => 'INR',
    ])->assertStatus(400);
});

it('returns 401 when credentials are missing on api create-order endpoint', function () {
    CoreConfig::where('code', 'like', 'sales.payment_methods.razorpay.%')->delete();
    config()->set('services.razorpay.key_id', null);
    config()->set('services.razorpay.key_secret', null);
    config()->set('services.razorpay.key', null);
    config()->set('services.razorpay.secret', null);

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.sandbox',
        'value' => '1',
        'channel_code' => 'default',
    ]);

    cache()->flush();

    $this->postJson(route('razorpay.api.create_order'), [
        'amount' => 50000,
        'currency' => 'INR',
    ])->assertStatus(401);
});

it('creates a razorpay order via api create-order endpoint', function () {
    $mockRazorpay = $this->mock(RazorpayPayment::class)->makePartial();
    $mockRazorpay->shouldReceive('hasValidCredentials')->andReturn(true);
    $mockRazorpay->shouldReceive('createOrderFromAmount')
        ->with(50000, 'INR', 'rcpt_100')
        ->andReturn([
            'id' => 'order_api_123',
            'order_id' => 'order_api_123',
            'amount' => 50000,
            'currency' => 'INR',
        ]);

    $this->app->instance(RazorpayPayment::class, $mockRazorpay);

    $this->postJson(route('razorpay.api.create_order'), [
        'amount' => 50000,
        'currency' => 'INR',
        'receipt' => 'rcpt_100',
    ])->assertOk()
        ->assertExactJson([
            'order_id' => 'order_api_123',
            'amount' => 50000,
            'currency' => 'INR',
        ]);
});

it('returns 500 when gateway fails on api create-order endpoint', function () {
    $failingRazorpay = $this->mock(RazorpayPayment::class)->makePartial();
    $failingRazorpay->shouldReceive('hasValidCredentials')->andReturn(true);
    $failingRazorpay->shouldReceive('createOrderFromAmount')
        ->andThrow(new RuntimeException('Gateway timeout'));

    $this->app->instance(RazorpayPayment::class, $failingRazorpay);

    $this->postJson(route('razorpay.api.create_order'), [
        'amount' => 50000,
        'currency' => 'INR',
    ])->assertStatus(500);
});

it('verifies payment signatures and returns 400 on missing fields or mismatch on api verify-payment', function () {
    CoreConfig::whereIn('code', [
        'sales.payment_methods.razorpay.sandbox',
        'sales.payment_methods.razorpay.test_client_id',
        'sales.payment_methods.razorpay.test_client_secret',
    ])->delete();

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.sandbox',
        'value' => '1',
        'channel_code' => 'default',
    ]);

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.test_client_id',
        'value' => 'rzp_test_fake_key',
        'channel_code' => 'default',
    ]);

    CoreConfig::factory()->create([
        'code' => 'sales.payment_methods.razorpay.test_client_secret',
        'value' => 'fake_test_secret',
        'channel_code' => 'default',
    ]);

    cache()->flush();

    // 1. Missing fields -> 400
    $this->postJson(route('razorpay.api.verify_payment'), [
        'razorpay_order_id' => 'order_123',
    ])->assertStatus(400)
        ->assertJsonPath('verified', false);

    // 2. Signature mismatch -> 400
    $this->postJson(route('razorpay.api.verify_payment'), [
        'razorpay_order_id' => 'order_123',
        'razorpay_payment_id' => 'pay_123',
        'razorpay_signature' => 'tampered_sig',
    ])->assertStatus(400)
        ->assertJsonPath('verified', false);

    // 3. Valid HMAC-SHA256 signature -> 200
    $validSignature = hash_hmac('sha256', 'order_123|pay_123', 'fake_test_secret');

    $this->postJson(route('razorpay.api.verify_payment'), [
        'razorpay_order_id' => 'order_123',
        'razorpay_payment_id' => 'pay_123',
        'razorpay_signature' => $validSignature,
    ])->assertOk()
        ->assertJson([
            'verified' => true,
            'order_id' => 'order_123',
            'payment_id' => 'pay_123',
        ]);
});

it('renders drop-in UI with checkout.js, payment.failed handler, and never leaks secret', function () {
    CoreConfig::where('code', 'sales.order_settings.minimum_order.enable')->delete();
    CoreConfig::factory()->create([
        'code' => 'sales.order_settings.minimum_order.enable',
        'value' => '0',
        'channel_code' => 'default',
    ]);
    cache()->flush();

    $cart = $this->createCartWithItems('razorpay', [
        'base_currency_code' => 'INR',
    ]);

    $mockRazorpay = $this->mock(RazorpayPayment::class)->makePartial();
    $mockRazorpay->shouldReceive('createOrder')->andReturn([
        'id' => 'order_ui_123',
        'order_id' => 'order_ui_123',
        'amount' => 54900,
        'currency' => 'INR',
    ]);

    $this->app->instance(RazorpayPayment::class, $mockRazorpay);

    $response = $this->get(route('razorpay.payment.redirect'))
        ->assertOk()
        ->assertSee('https://checkout.razorpay.com/v1/checkout.js', false)
        ->assertSee("razorpay.on('payment.failed'", false)
        ->assertSee('ondismiss', false)
        ->assertDontSee('fake_test_secret');

    if ($envSecret = config('services.razorpay.key_secret')) {
        $response->assertDontSee($envSecret);
    }
});

it('accepts POST callback on razorpay payment success route', function () {
    CoreConfig::where('code', 'sales.order_settings.minimum_order.enable')->delete();
    CoreConfig::factory()->create([
        'code' => 'sales.order_settings.minimum_order.enable',
        'value' => '0',
        'channel_code' => 'default',
    ]);
    cache()->flush();

    $cart = $this->createCartWithItems('razorpay', [
        'base_currency_code' => 'INR',
    ]);

    $mockRazorpay = $this->mock(RazorpayPayment::class)->makePartial();
    $mockRazorpay->shouldReceive('verifySignature')->andReturn(true);
    $mockRazorpay->shouldReceive('verifyCapturedPayment')->andReturn(true);
    $this->app->instance(RazorpayPayment::class, $mockRazorpay);

    $this->post(route('razorpay.payment.success'), [
        'razorpay_payment_id' => 'pay_post_123',
        'razorpay_order_id' => 'order_post_123',
        'razorpay_signature' => 'valid_sig',
    ])->assertRedirect(route('shop.checkout.onepage.success'));
});

it('rejects razorpay callback when server-side payment verification fails amount or cart binding', function () {
    CoreConfig::where('code', 'sales.order_settings.minimum_order.enable')->delete();
    CoreConfig::factory()->create([
        'code' => 'sales.order_settings.minimum_order.enable',
        'value' => '0',
        'channel_code' => 'default',
    ]);
    cache()->flush();

    $cart = $this->createCartWithItems('razorpay', [
        'base_currency_code' => 'INR',
    ]);

    $mockRazorpay = $this->mock(RazorpayPayment::class)->makePartial();
    $mockRazorpay->shouldReceive('verifySignature')->andReturn(true);
    $mockRazorpay->shouldReceive('verifyCapturedPayment')->andReturn(false);
    $this->app->instance(RazorpayPayment::class, $mockRazorpay);

    $this->post(route('razorpay.payment.success'), [
        'razorpay_payment_id' => 'pay_mismatched_123',
        'razorpay_order_id' => 'order_mismatched_123',
        'razorpay_signature' => 'valid_sig',
    ])->assertRedirect(route('shop.checkout.cart.index'))
        ->assertSessionHas('error');

    expect(Order::where('cart_id', $cart->id)->first())->toBeNull();
});
