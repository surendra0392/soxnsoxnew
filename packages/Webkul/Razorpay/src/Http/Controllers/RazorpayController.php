<?php

namespace Webkul\Razorpay\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Razorpay\Api\Errors\Error as RazorpayApiError;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Razorpay\Payment\RazorpayPayment;
use Webkul\Sales\Models\Invoice;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Sales\Transformers\OrderResource;

class RazorpayController extends Controller
{
    /**
     * Payment captured constant.
     */
    public const PAYMENT_CAPTURED = 'captured';

    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected RazorpayPayment $razorpayPayment,
        protected OrderRepository $orderRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
        protected InvoiceRepository $invoiceRepository,
        protected CartRepository $cartRepository,
    ) {}

    /**
     * Create a Razorpay order via JSON API.
     */
    public function createOrderApi(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'integer', 'min:'.RazorpayPayment::MIN_AMOUNT_PAISE],
            'currency' => ['sometimes', 'string', 'size:3'],
            'receipt' => ['nullable', 'string', 'max:40'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 400);
        }

        if (! $this->razorpayPayment->hasValidCredentials()) {
            return response()->json([
                'message' => 'Razorpay authentication credentials are not configured.',
            ], 401);
        }

        $validated = $validator->validated();

        try {
            $order = $this->razorpayPayment->createOrderFromAmount(
                (int) $validated['amount'],
                $validated['currency'] ?? 'INR',
                $validated['receipt'] ?? null
            );

            return response()->json([
                'order_id' => $order['order_id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        } catch (RazorpayApiError $e) {
            report($e);

            $status = (int) $e->getHttpStatusCode();

            if ($status === 401) {
                return response()->json([
                    'message' => 'Razorpay authentication failed.',
                ], 401);
            }

            return response()->json([
                'message' => 'Razorpay order creation failed.',
            ], 500);
        } catch (\Throwable $e) {
            report($e);

            if ((int) $e->getCode() === 401) {
                return response()->json([
                    'message' => 'Razorpay authentication failed.',
                ], 401);
            }

            return response()->json([
                'message' => 'Razorpay order creation failed.',
            ], 500);
        }
    }

    /**
     * Verify Razorpay Checkout payment signature via JSON API.
     */
    public function verifyPaymentApi(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'verified' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 400);
        }

        if (! $this->razorpayPayment->hasValidCredentials()) {
            return response()->json([
                'verified' => false,
                'message' => 'Razorpay authentication credentials are not configured.',
            ], 401);
        }

        $validated = $validator->validated();

        if (! $this->razorpayPayment->verifySignature(
            $validated['razorpay_order_id'],
            $validated['razorpay_payment_id'],
            $validated['razorpay_signature']
        )) {
            return response()->json([
                'verified' => false,
                'message' => 'Payment signature mismatch.',
            ], 400);
        }

        return response()->json([
            'verified' => true,
            'order_id' => $validated['razorpay_order_id'],
            'payment_id' => $validated['razorpay_payment_id'],
        ]);
    }

    /**
     * Redirects to checkout.
     */
    public function redirect(): RedirectResponse|View
    {
        if (! $this->razorpayPayment->hasValidCredentials()) {
            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->back();
        }

        $cart = Cart::getCart();

        if (! $cart) {
            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->route('shop.checkout.cart.index');
        }

        if (Cart::hasError()) {
            session()->flash('error', trans('shop::app.checkout.cart.inventory-warning'));

            return redirect()->route('shop.checkout.cart.index');
        }

        try {
            $currency = strtoupper($cart->base_currency_code ?? core()->getBaseCurrencyCode());

            if (! $this->razorpayPayment->isCurrencySupported($currency)) {
                session()->flash('error', trans('razorpay::app.response.supported-currency-error', [
                    'currency' => $currency,
                    'supportedCurrencies' => implode(', ', $this->razorpayPayment->getSupportedCurrencies()),
                ]));

                return redirect()->back();
            }

            $razorpayOrder = $this->razorpayPayment->createOrder($cart);

            session()->put('razorpay_pending_order', [
                'order_id' => $razorpayOrder['id'] ?? $razorpayOrder['order_id'] ?? '',
                'cart_id' => (int) $cart->id,
                'amount' => (int) ($razorpayOrder['amount'] ?? round((float) $cart->base_grand_total * 100)),
                'currency' => $currency,
            ]);

            $payment = $this->razorpayPayment->preparePaymentData($cart, $razorpayOrder);

            return view('razorpay::drop-in-ui', compact('payment'));
        } catch (\Throwable $e) {
            report($e);

            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->back();
        }
    }

    /**
     * Payment success.
     */
    public function paymentSuccess(Request $request): RedirectResponse
    {
        if (! $this->razorpayPayment->hasValidCredentials()) {
            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $razorpayOrderId = $request->input('razorpay_order_id');

        if (! $razorpayOrderId) {
            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->route('shop.checkout.cart.index');
        }

        if ($request->has('error')) {
            return $this->handlePaymentError($request);
        }

        $isValidSignature = $this->razorpayPayment->verifySignature(
            $request->input('razorpay_order_id'),
            $request->input('razorpay_payment_id'),
            $request->input('razorpay_signature')
        );

        if (! $isValidSignature) {
            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $cart = Cart::getCart();

        if (! $cart || $cart->payment?->method !== 'razorpay') {
            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $pendingOrder = session('razorpay_pending_order');

        if (
            is_array($pendingOrder)
            && (
                (int) ($pendingOrder['cart_id'] ?? 0) !== (int) $cart->id
                || ($pendingOrder['order_id'] ?? '') !== $razorpayOrderId
            )
        ) {
            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->route('shop.checkout.cart.index');
        }

        Cart::setCart($cart);
        Cart::collectTotals();
        $cart = Cart::getCart();

        if (Cart::hasError()) {
            session()->flash('error', trans('shop::app.checkout.cart.inventory-warning'));

            return redirect()->route('shop.checkout.cart.index');
        }

        if (! $this->razorpayPayment->verifyCapturedPayment(
            (string) $razorpayOrderId,
            (string) $request->input('razorpay_payment_id'),
            $cart
        )) {
            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->route('shop.checkout.cart.index');
        }

        return $this->handlePaymentSuccess($request, $cart);
    }

    /**
     * Payment fail.
     */
    public function paymentFail(): RedirectResponse
    {
        session()->forget('razorpay_pending_order');
        session()->flash('error', trans('razorpay::app.response.payment.cancelled'));

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Handle payment error.
     */
    protected function handlePaymentError(Request $request): RedirectResponse
    {
        $errorDescription = $request->input('error.description', trans('razorpay::app.response.something-went-wrong'));

        session()->flash('error', $errorDescription);

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Handle successful payment.
     */
    protected function handlePaymentSuccess(Request $request, $cart): RedirectResponse
    {
        try {
            $order = Cache::lock("razorpay_order_{$cart->id}", 15)->block(10, function () use ($request, $cart) {
                $existingOrder = $this->orderRepository->findOneWhere(['cart_id' => $cart->id]);

                if ($existingOrder) {
                    return $existingOrder;
                }

                $orderData = (new OrderResource($cart))->jsonSerialize();

                $order = $this->orderRepository->create($orderData);

                if ($order->payment) {
                    $order->payment->update([
                        'additional' => [
                            'status' => Invoice::STATUS_PAID,
                            'razorpay_order_id' => $request->input('razorpay_order_id'),
                            'razorpay_payment_id' => $request->input('razorpay_payment_id'),
                        ],
                    ]);
                }

                $this->orderRepository->update(['status' => Order::STATUS_PROCESSING], $order->id);

                $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order->id));

                $this->orderTransactionRepository->create([
                    'transaction_id' => $request->input('razorpay_payment_id'),
                    'status' => self::PAYMENT_CAPTURED,
                    'type' => $order->payment->method,
                    'payment_method' => $order->payment->method,
                    'order_id' => $order->id,
                    'invoice_id' => $invoice->id,
                    'amount' => $orderData['base_grand_total'] ?? 0,
                    'data' => json_encode([
                        'razorpay_order_id' => $request->input('razorpay_order_id'),
                        'razorpay_payment_id' => $request->input('razorpay_payment_id'),
                        'razorpay_signature' => $request->input('razorpay_signature'),
                    ]),
                ]);

                Cart::deActivateCart();

                session()->forget('razorpay_pending_order');

                return $order;
            });

            session()->flash('order_id', $order?->id);

            return redirect()->route('shop.checkout.onepage.success');
        } catch (\Throwable $e) {
            report($e);

            session()->flash('error', trans('razorpay::app.response.something-went-wrong'));

            return redirect()->route('shop.checkout.cart.index');
        }
    }

    /**
     * Handle incoming webhook notifications from Razorpay.
     */
    public function webhook(Request $request): JsonResponse
    {
        $webhookSignature = $request->header('X-Razorpay-Signature');
        $webhookSecret = config('services.razorpay.webhook_secret') ?? $this->razorpayPayment->getApiSecret();

        $rawBody = $request->getContent();

        if (! $webhookSecret) {
            return response()->json(['status' => 'webhook_secret_not_configured'], 500);
        }

        if (! $webhookSignature) {
            return response()->json(['status' => 'missing_signature'], 400);
        }

        $expectedSignature = hash_hmac('sha256', $rawBody, $webhookSecret);

        if (! hash_equals($expectedSignature, $webhookSignature)) {
            return response()->json(['status' => 'invalid_signature'], 400);
        }

        $payload = $request->all();
        $event = $payload['event'] ?? null;

        if (! in_array($event, ['payment.captured', 'order.paid'], true)) {
            return response()->json(['status' => 'ignored_event'], 200);
        }

        $paymentEntity = $payload['payload']['payment']['entity'] ?? null;
        $cartId = $paymentEntity['notes']['cart_id'] ?? null;

        if (! $cartId) {
            return response()->json(['status' => 'cart_not_found'], 200);
        }

        $cart = $this->cartRepository->find($cartId);

        if (! $cart || ! $cart->is_active || $cart->payment?->method !== 'razorpay') {
            return response()->json(['status' => 'cart_inactive'], 200);
        }

        $existingOrder = $this->orderRepository->findOneWhere(['cart_id' => $cartId]);

        if ($existingOrder) {
            return response()->json(['status' => 'order_already_exists', 'order_id' => $existingOrder->id], 200);
        }

        Cart::setCart($cart);
        Cart::collectTotals();
        $cart = Cart::getCart() ?? $cart;

        $expectedAmountPaise = (int) round((float) $cart->base_grand_total * 100);
        $expectedCurrency = strtoupper((string) ($cart->base_currency_code ?? core()->getBaseCurrencyCode()));
        $paidAmountPaise = (int) ($paymentEntity['amount'] ?? 0);
        $paidCurrency = strtoupper((string) ($paymentEntity['currency'] ?? ''));

        if ($paidCurrency !== $expectedCurrency || $paidAmountPaise < $expectedAmountPaise) {
            return response()->json(['status' => 'amount_mismatch'], 200);
        }

        $order = Cache::lock("razorpay_order_{$cartId}", 15)->block(10, function () use ($cart, $paymentEntity) {
            $existing = $this->orderRepository->findOneWhere(['cart_id' => $cart->id]);

            if ($existing) {
                return $existing;
            }

            Cart::setCart($cart);
            Cart::collectTotals();

            $orderData = (new OrderResource($cart))->jsonSerialize();

            $order = $this->orderRepository->create($orderData);

            if ($order->payment) {
                $order->payment->update([
                    'additional' => [
                        'status' => Invoice::STATUS_PAID,
                        'razorpay_order_id' => $paymentEntity['order_id'] ?? '',
                        'razorpay_payment_id' => $paymentEntity['id'] ?? '',
                        'source' => 'webhook',
                    ],
                ]);
            }

            $this->orderRepository->update(['status' => Order::STATUS_PROCESSING], $order->id);

            $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order->id));

            $this->orderTransactionRepository->create([
                'transaction_id' => $paymentEntity['id'] ?? '',
                'status' => self::PAYMENT_CAPTURED,
                'type' => $order->payment->method,
                'payment_method' => $order->payment->method,
                'order_id' => $order->id,
                'invoice_id' => $invoice->id,
                'amount' => $orderData['base_grand_total'] ?? 0,
                'data' => json_encode($paymentEntity),
            ]);

            Cart::deActivateCart();

            return $order;
        });

        return response()->json(['status' => 'success', 'order_id' => $order?->id], 200);
    }

    /**
     * Prepares invoice data.
     */
    protected function prepareInvoiceData(?int $orderId = null): array
    {
        try {
            $order = $orderId
                ? $this->orderRepository->findOrFail($orderId)
                : $this->orderRepository->orderBy('created_at', 'desc')->first();

            if (! $order) {
                return [];
            }

            $invoiceItems = [];

            foreach ($order->items as $item) {
                if ($item->qty_to_invoice > 0) {
                    $invoiceItems[$item->id] = $item->qty_to_invoice;
                }
            }

            if (empty($invoiceItems)) {
                return [];
            }

            return [
                'order_id' => $order->id,
                'invoice' => [
                    'items' => $invoiceItems,
                ],
            ];
        } catch (\Throwable $e) {
            report($e);

            return [];
        }
    }
}
