<?php

namespace Webkul\Shipping\Carriers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Models\ShippingZone;

class SoxnsoxShipping extends AbstractShipping
{
    /**
     * Shipping method carrier code.
     *
     * @var string
     */
    protected $code = 'soxnsox';

    /**
     * Checks if shipping method is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        return true; // We manage availability at the Zone and Method level now.
    }

    /**
     * Returns shipping method title.
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Shipping';
    }

    /**
     * Returns shipping method description.
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Soxnsox Dynamic Shipping';
    }

    /**
     * Calculate rate for soxnsox shipping.
     *
     * @return array|false
     */
    public function calculate()
    {

        $cart = Cart::getCart();

        if (! $cart) {
            return false;
        }

        $shippingAddress = $cart->shipping_address;

        if (! $shippingAddress) {
            return false;
        }

        $cartWeight = 0;
        $cartSubTotal = $cart->base_sub_total;

        foreach ($cart->items as $item) {
            $cartWeight += $item->weight * $item->quantity;
        }

        $country = $shippingAddress->country;
        $state = $shippingAddress->state;
        $postcode = $shippingAddress->postcode;

        // Fetch all active zones with locations and active methods
        $zones = ShippingZone::where('is_active', 1)
            ->with(['locations', 'methods' => function ($q) {
                $q->where('is_active', 1)->orderBy('priority', 'asc');
            }])
            ->get();

        $matchedZone = null;
        $highestSpecificity = -1;

        foreach ($zones as $zone) {
            if ($zone->locations->isEmpty()) {
                // Global fallback (specificity 0)
                if ($highestSpecificity < 0) {
                    $matchedZone = $zone;
                    $highestSpecificity = 0;
                }

                continue;
            }

            foreach ($zone->locations as $location) {
                if ($location->location_type === 'postcode') {
                    // Support wildcards e.g. 9021*
                    $pattern = str_replace('*', '.*', preg_quote($location->location_code, '/'));
                    if (preg_match('/^'.$pattern.'$/i', $postcode)) {
                        if ($highestSpecificity < 3) {
                            $matchedZone = $zone;
                            $highestSpecificity = 3;
                        }
                    }
                } elseif ($location->location_type === 'state' && $location->location_code === $state) {
                    if ($highestSpecificity < 2) {
                        $matchedZone = $zone;
                        $highestSpecificity = 2;
                    }
                } elseif ($location->location_type === 'country' && $location->location_code === $country) {
                    if ($highestSpecificity < 1) {
                        $matchedZone = $zone;
                        $highestSpecificity = 1;
                    }
                }
            }
        }

        if (! $matchedZone || $matchedZone->methods->isEmpty()) {
            return false;
        }

        // First pass: Check if any free_shipping method is eligible in this matched zone
        $hasEligibleFreeShipping = false;
        foreach ($matchedZone->methods as $method) {
            if ($method->type === 'free_shipping') {
                $minSubtotal = (float) ($method->min_subtotal ?? 0);
                $maxSubtotal = (float) ($method->max_subtotal ?? 0);
                $minWeight = (float) ($method->min_weight ?? 0);
                $maxWeight = (float) ($method->max_weight ?? 0);

                if ($minSubtotal > 0 && $cartSubTotal < $minSubtotal) {
                    continue;
                }
                if ($maxSubtotal > 0 && $cartSubTotal > $maxSubtotal) {
                    continue;
                }
                if ($minWeight > 0 && $cartWeight < $minWeight) {
                    continue;
                }
                if ($maxWeight > 0 && $cartWeight > $maxWeight) {
                    continue;
                }

                $hasEligibleFreeShipping = true;
                break;
            }
        }

        $shippingRates = [];

        foreach ($matchedZone->methods as $method) {
            // If Free Shipping is unlocked for the zone, do not offer standard flat rate
            if ($hasEligibleFreeShipping && $method->type === 'flat_rate') {
                continue;
            }

            // Check Weight Conditions
            if (! empty($method->min_weight) && $method->min_weight > 0 && $cartWeight < $method->min_weight) {
                continue;
            }
            if (! empty($method->max_weight) && $method->max_weight > 0 && $cartWeight > $method->max_weight) {
                continue;
            }

            // Check Subtotal Conditions
            if (! empty($method->min_subtotal) && $method->min_subtotal > 0 && $cartSubTotal < $method->min_subtotal) {
                continue;
            }
            if (! empty($method->max_subtotal) && $method->max_subtotal > 0 && $cartSubTotal > $method->max_subtotal) {
                continue;
            }

            $cartShippingRate = new CartShippingRate;

            $cartShippingRate->carrier = $this->getCode();
            $cartShippingRate->carrier_title = $this->getConfigData('title') ?: 'Shipping';
            $cartShippingRate->method = $this->getCode().'_'.$method->id;
            $cartShippingRate->method_title = $method->title;
            $cartShippingRate->method_description = '';

            $price = $method->type === 'free_shipping' ? 0 : (float) $method->price;
            $cartShippingRate->price = core()->convertPrice($price);
            $cartShippingRate->base_price = $price;

            $shippingRates[] = $cartShippingRate;
        }

        if (empty($shippingRates)) {
            return false;
        }

        return $shippingRates;
    }
}
