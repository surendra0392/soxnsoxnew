<?php

use Webkul\Razorpay\Payment\RazorpayPayment;

return [
    'razorpay' => [
        'class' => RazorpayPayment::class,
        'code' => 'razorpay',
        'title' => 'Razorpay',
        'description' => 'Razorpay',
        'active' => true,
        'sandbox' => false,
        'test_client_id' => null,
        'test_client_secret' => null,
        'sort' => 2,
    ],
];
