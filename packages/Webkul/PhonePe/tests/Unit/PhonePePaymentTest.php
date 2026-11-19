<?php

use Webkul\PhonePe\Payment\PhonePe;

beforeEach(function () {
    $this->phonePe = app(PhonePe::class);
});

it('returns the correct payment method code', function () {
    expect($this->phonePe->getCode())->toBe('phonepe');
});

it('generates a formatted merchant order id', function () {
    $merchantOrderId = $this->phonePe->generateMerchantOrderId(42);

    expect($merchantOrderId)->toStartWith('PHONE_PE_42_');
});

it('returns correct payment url depending on sandbox mode', function () {
    $url = $this->phonePe->getPaymentUrl();

    expect($url)->toBeIn([
        'https://api-preprod.phonepe.com/apis/pg-sandbox',
        'https://api.phonepe.com/apis/pg',
    ]);
});
