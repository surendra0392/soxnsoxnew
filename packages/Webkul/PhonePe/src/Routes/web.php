<?php

use Illuminate\Support\Facades\Route;
use Webkul\PhonePe\Http\Controllers\PhonePeController;

Route::group(['middleware' => ['web'], 'prefix' => 'phonepe'], function () {
    Route::get('/redirect', [PhonePeController::class, 'redirect'])
        ->name('phonepe.redirect');

    Route::match(['get', 'post'], '/callback', [PhonePeController::class, 'callback'])
        ->name('phonepe.callback');

    Route::get('/cancel', [PhonePeController::class, 'cancel'])
        ->name('phonepe.cancel');

    Route::post('/webhook', [PhonePeController::class, 'webhook'])
        ->name('phonepe.webhook');
});
