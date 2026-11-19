<?php

namespace Webkul\Razorpay\Payment;

use Illuminate\Support\Facades\Storage;
use Razorpay\Api\Api;
use Webkul\Checkout\Facades\Cart;
use Webkul\Payment\Payment\Payment;

class RazorpayPayment extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'razorpay';

    /**
     * Supported currencies.
     *
     * @var array
     */
    protected $supportedCurrencies = ['INR'];

    /**
     * Receipt prefix.
     */
    public const RECEIPT_PREFIX = 'receipt_';

    /**
     * Get redirect url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('razorpay.payment.redirect');
    }

    /**
     * Check if payment method is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        return parent::isAvailable() && $this->hasValidCredentials();
    }

    /**
     * Get payment method title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getConfigData('title') ?? trans('razorpay::app.title');
    }

    /**
     * Get payment method description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getConfigData('description') ?? trans('razorpay::app.description');
    }

    /**
     * Returns payment method image.
     *
     * @return string
     */
    public function getImage()
    {
        $url = $this->getConfigData('image');

        return $url ? Storage::url($url) : bagisto_asset('images/razorpay.png', 'shop');
    }

    /**
     * Check if sandbox mode is enabled.
     *
     * @return bool
     */
    public function isSandbox()
    {
        return (bool) $this->getConfigData('sandbox');
    }

    /**
     * Get Razorpay API Key (Client ID).
     *
     * @return string|null
     */
    public function getApiKey()
    {
        if ($this->isSandbox()) {
            return $this->getConfigData('test_client_id')
                ?? config('services.razorpay.key_id');
        }

        return $this->getConfigData('client_id')
            ?? config('services.razorpay.key')
            ?? config('services.razorpay.key_id');
    }

    /**
     * Get Razorpay API Secret (Client Secret).
     *
     * @return string|null
     */
    public function getApiSecret()
    {
        if ($this->isSandbox()) {
            return $this->getConfigData('test_client_secret')
                ?? config('services.razorpay.key_secret');
        }

        return $this->getConfigData('client_secret')
            ?? config('services.razorpay.secret')
            ?? config('services.razorpay.key_secret');
    }

    /**
     * Get merchant name.
     *
     * @return string|null
     */
    public function getMerchantName()
    {
        return $this->getConfigData('merchant_name');
    }

    /**
     * Get merchant description.
     *
     * @return string|null
     */
    public function getMerchantDescription()
    {
        return $this->getConfigData('merchant_desc');
    }

    /**
     * Check if required credentials are configured.
     *
     * @return bool
     */
    public function hasValidCredentials()
    {
        return $this->getApiKey() && $this->getApiSecret();
    }

    /**
     * Get supported currencies.
     *
     * @return array
     */
    public function getSupportedCurrencies()
    {
        return $this->supportedCurrencies;
    }

    /**
     * Check if currency is supported.
     *
     * @param  string  $currency
     * @return bool
     */
    public function isCurrencySupported($currency)
    {
        return in_array(strtoupper($currency), $this->supportedCurrencies);
    }

    /**
     * Get Razorpay API instance.
     *
     * @return Api
     */
    public function getApi()
    {
        return new Api($this->getApiKey(), $this->getApiSecret());
    }

    /**
     * Minimum allowed order amount in smallest currency unit (100 paise = ₹1.00).
     */
    public const MIN_AMOUNT_PAISE = 100;

    /**
     * Create a Razorpay order for an explicit amount in paise.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function createOrderFromAmount(
        int $amountInPaise,
        string $currency = 'INR',
        ?string $receipt = null,
        array $notes = []
    ): array {
        $currency = strtoupper($currency);

        if ($amountInPaise < self::MIN_AMOUNT_PAISE) {
            throw new \InvalidArgumentException('Amount must be at least 100 paise.');
        }

        if (! $this->isCurrencySupported($currency)) {
            throw new \InvalidArgumentException(trans('razorpay::app.response.supported-currency-error', [
                'currency' => $currency,
                'supportedCurrencies' => implode(', ', $this->supportedCurrencies),
            ]));
        }

        if (! $this->hasValidCredentials()) {
            throw new \RuntimeException('Razorpay credentials are missing or invalid.', 401);
        }

        $payload = [
            'amount' => $amountInPaise,
            'currency' => $currency,
            'receipt' => $receipt ?: self::RECEIPT_PREFIX.uniqid(),
            'payment_capture' => 1,
        ];

        if (! empty($notes)) {
            $payload['notes'] = $notes;
        }

        $order = $this->getApi()->order->create($payload);
        $orderArray = is_array($order) ? $order : $order->toArray();

        return array_merge($orderArray, [
            'order_id' => $orderArray['id'],
            'amount' => (int) ($orderArray['amount'] ?? $amountInPaise),
            'currency' => strtoupper((string) ($orderArray['currency'] ?? $currency)),
        ]);
    }

    /**
     * Create Razorpay order.
     *
     * @param  \Webkul\Checkout\Contracts\Cart|null  $cart
     * @return array
     *
     * @throws \Exception
     */
    public function createOrder($cart = null)
    {
        if (! $cart) {
            $cart = Cart::getCart();
        }

        $currency = strtoupper($cart->base_currency_code ?? core()->getBaseCurrencyCode());
        $amountInPaise = (int) round((float) $cart->base_grand_total * 100);

        return $this->createOrderFromAmount(
            $amountInPaise,
            $currency,
            self::RECEIPT_PREFIX.$cart->id,
            ['cart_id' => $cart->id]
        );
    }

    /**
     * Prepare payment data for checkout.
     *
     * @param  \Webkul\Checkout\Contracts\Cart  $cart
     * @param  array  $razorpayOrder
     * @return array
     */
    public function preparePaymentData($cart, $razorpayOrder)
    {
        return [
            'key' => $this->getApiKey(),
            'amount' => (int) ($razorpayOrder['amount'] ?? round((float) $cart->base_grand_total * 100)),
            'currency' => strtoupper($cart->base_currency_code ?? core()->getBaseCurrencyCode()),
            'name' => $this->getMerchantName(),
            'description' => $this->getMerchantDescription(),
            'image' => $this->getImage(),
            'order_id' => $razorpayOrder['id'] ?? $razorpayOrder['order_id'],
            'theme_color' => '#0041FF',
            'prefill' => [
                'name' => $cart->billing_address?->name,
                'email' => $cart->billing_address?->email,
                'contact' => $cart->billing_address?->phone,
            ],
        ];
    }

    /**
     * Verify Razorpay payment signature.
     *
     * @param  string  $orderId
     * @param  string  $paymentId
     * @param  string  $signature
     * @return bool
     */
    public function verifySignature($orderId, $paymentId, $signature)
    {
        if (! $orderId || ! $paymentId || ! $signature) {
            return false;
        }

        $expectedSignature = $orderId.'|'.$paymentId;

        $generatedSignature = hash_hmac('sha256', $expectedSignature, $this->getApiSecret());

        return hash_equals($generatedSignature, $signature);
    }

    /**
     * Fetch and verify Razorpay payment details against cart totals and cart ID binding.
     */
    public function verifyCapturedPayment(string $orderId, string $paymentId, $cart): bool
    {
        if (! $orderId || ! $paymentId || ! $cart) {
            return false;
        }

        try {
            $api = $this->getApi();
            $payment = $api->payment->fetch($paymentId);
            $paymentData = is_array($payment) ? $payment : $payment->toArray();

            $status = strtolower((string) ($paymentData['status'] ?? ''));

            if (! in_array($status, ['captured', 'authorized'], true)) {
                return false;
            }

            if ((string) ($paymentData['order_id'] ?? '') !== $orderId) {
                return false;
            }

            $expectedCurrency = strtoupper((string) ($cart->base_currency_code ?? core()->getBaseCurrencyCode()));
            $expectedAmountPaise = (int) round((float) $cart->base_grand_total * 100);

            if (
                strtoupper((string) ($paymentData['currency'] ?? '')) !== $expectedCurrency
                || (int) ($paymentData['amount'] ?? 0) !== $expectedAmountPaise
            ) {
                return false;
            }

            $order = $api->order->fetch($orderId);
            $orderData = is_array($order) ? $order : $order->toArray();
            $noteCartId = $orderData['notes']['cart_id'] ?? $paymentData['notes']['cart_id'] ?? null;

            if ($noteCartId === null || (int) $noteCartId !== (int) $cart->id) {
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            report($e);

            return false;
        }
    }
}
