<?php

namespace Webkul\Shop\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Event;
use Webkul\Shop\Http\Requests\Customer\LoginRequest;

class CustomerController extends APIController
{
    /**
     * Login Customer
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $credentials['channel_id'] = core()->getCurrentChannel()->id;

        if (! auth()->guard('customer')->attempt($credentials)) {
            return response()->json([
                'message' => trans('shop::app.customers.login-form.invalid-credentials'),
            ], Response::HTTP_FORBIDDEN);
        }

        $customer = auth()->guard('customer')->user();

        if (! $customer->status) {
            auth()->guard('customer')->logout();

            return response()->json([
                'message' => trans('shop::app.customers.login-form.not-activated'),
            ], Response::HTTP_FORBIDDEN);
        }

        if ($customer->is_suspended) {
            auth()->guard('customer')->logout();

            return response()->json([
                'message' => trans('shop::app.checkout.cart.suspended-account-message'),
            ], Response::HTTP_FORBIDDEN);
        }

        if (! $customer->is_verified) {
            Cookie::queue(Cookie::make('enable-resend', 'true', 1));

            Cookie::queue(Cookie::make('email-for-resend', $request->get('email'), 1));

            auth()->guard('customer')->logout();

            return response()->json([
                'message' => trans('shop::app.customers.login-form.verify-first'),
            ], Response::HTTP_FORBIDDEN);
        }

        $request->session()->regenerate();

        /**
         * Event passed to prepare cart after login.
         */
        Event::dispatch('customer.after.login', auth()->guard('customer')->user());

        return response()->json([]);
    }
}
