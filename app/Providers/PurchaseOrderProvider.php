<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Integrations\PurchaseOrderClient;
use App\Module\PurchaseOrder\PurchaseOrderCalculator;
use App\Module\PurchaseOrder\PurchaseOrderManager;

class PurchaseOrderProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $host = env('PURCHASE_ORDER_API');
        $username = env('PURCHASE_ORDER_USERNAME');
        $password = env('PURCHASE_ORDER_PASSWORD');
        $this->app->singleton('purchaseOrderClient', function() use ($host, $username, $password) {
            return new PurchaseOrderClient($host, $username, $password);
        });

        $this->app->singleton('purchaseOrderCalculator', function() use ($host, $username, $password) {
            return new PurchaseOrderCalculator($host, $username, $password);
        });

        $this->app->singleton('purchaseOrderManager', function() use ($host, $username, $password) {
            return new PurchaseOrderManager($this->app->make('purchaseOrderClient'), $this->app->make('purchaseOrderCalculator'));
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
