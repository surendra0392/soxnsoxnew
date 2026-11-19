<?php

use Illuminate\Support\Facades\Route;
use Webkul\Razorpay\Http\Controllers\RazorpayController;

Route::controller(RazorpayController::class)
    ->middleware('web')
    ->prefix('razorpay/payment')
    ->group(function () {
        Route::get('redirect', 'redirect')->name('razorpay.payment.redirect');

        Route::match(['get', 'post'], 'success', 'paymentSuccess')->name('razorpay.payment.success');

        Route::get('fail', 'paymentFail')->name('razorpay.payment.cancel');

        Route::post('webhook', 'webhook')->name('razorpay.payment.webhook');
    });

Route::controller(RazorpayController::class)
    ->middleware(['api', 'throttle:30,1'])
    ->prefix('api')
    ->group(function () {
        Route::post('create-order', 'createOrderApi')->name('razorpay.api.create_order');

        Route::post('verify-payment', 'verifyPaymentApi')->name('razorpay.api.verify_payment');
    });
