<?php

namespace Webkul\Paypal\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Webkul\Checkout\Facades\Cart;
use Webkul\Paypal\Helpers\Ipn;
use Webkul\Paypal\Payment\Standard;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Transformers\OrderResource;

class StandardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected Ipn $ipnHelper
    ) {}

    /**
     * Redirects to the paypal.
     *
     * @return View
     */
    public function redirect()
    {
        return view('paypal::standard-redirect');
    }

    /**
     * Cancel payment from paypal.
     *
     * @return Response
     */
    public function cancel()
    {
        session()->flash('error', trans('shop::app.checkout.cart.paypal-payment-cancelled'));

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Success payment.
     *
     * @return Response
     */
    public function success()
    {
        $cart = Cart::getCart();

        if (
            ! $cart
            || ! app(Standard::class)->isAvailable()
            || $cart->payment?->method !== 'paypal_standard'
        ) {
            return redirect()->route('shop.checkout.cart.index');
        }

        if (Cart::hasError()) {
            session()->flash('error', trans('shop::app.checkout.cart.inventory-warning'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $order = Cache::lock("paypal_standard_order_{$cart->id}", 15)->block(10, function () use ($cart) {
            $existingOrder = $this->orderRepository->findOneWhere(['cart_id' => $cart->id]);

            if ($existingOrder) {
                return $existingOrder;
            }

            $data = (new OrderResource($cart))->jsonSerialize();

            $order = $this->orderRepository->create($data);

            Cart::deActivateCart();

            return $order;
        });

        session()->flash('order_id', $order?->id);

        return redirect()->route('shop.checkout.onepage.success');
    }

    /**
     * Paypal IPN listener.
     *
     * @return Response
     */
    public function ipn()
    {
        $this->ipnHelper->processIpn(request()->all());

        return response('OK', 200);
    }
}
