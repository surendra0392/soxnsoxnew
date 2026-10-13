<?php

namespace Webkul\Shipping\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\Shipping\Services\DelhiveryService;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/../Http/helpers.php';

        $this->registerConfig();

        $this->app->singleton(DelhiveryService::class, function () {
            return new DelhiveryService;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            'sales.shipment.save.after',
            'Webkul\Shipping\Listeners\ShipmentListener@afterShipmentCreated'
        );
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/carriers.php', 'carriers'
        );
    }
}
