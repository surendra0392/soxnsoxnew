<?php

namespace Webkul\Shipping\Carriers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Services\DelhiveryService;

class DelhiveryShipping extends AbstractShipping
{
    /**
     * Shipping method carrier code.
     *
     * @var string
     */
    protected $code = 'delhivery';

    /**
     * Shipping method code.
     *
     * @var string
     */
    protected $method = 'delhivery_express';

    /**
     * Calculate rate for Delhivery shipping.
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        $cart = Cart::getCart();

        if (! $cart) {
            return false;
        }

        $shippingAddress = $cart->shipping_address;

        if (! $shippingAddress || ! $shippingAddress->postcode) {
            return false;
        }

        // If API token is configured, optionally check PIN code serviceability
        $delhiveryService = app(DelhiveryService::class);

        if ($delhiveryService->isConfigured()) {
            $serviceability = $delhiveryService->checkPincodeServiceability($shippingAddress->postcode);

            if (! empty($serviceability) && isset($serviceability['serviceable']) && ! $serviceability['serviceable']) {
                return false;
            }
        }

        return $this->getRate();
    }

    /**
     * Get rate.
     */
    public function getRate(): CartShippingRate
    {
        $cart = Cart::getCart();

        $cartShippingRate = new CartShippingRate;

        $title = $this->getTitle() ?: 'Delhivery Express';
        $description = $this->getDescription() ?: 'Doorstep delivery via Delhivery';

        $cartShippingRate->carrier = $this->getCode();
        $cartShippingRate->carrier_title = $title;
        $cartShippingRate->method = $this->getMethod();
        $cartShippingRate->method_title = $title;
        $cartShippingRate->method_description = $description;

        $defaultRate = (float) ($this->getConfigData('default_rate') ?? 0);
        $rate = $defaultRate;

        $cartShippingRate->price = core()->convertPrice($rate);
        $cartShippingRate->base_price = $rate;

        return $cartShippingRate;
    }
}
