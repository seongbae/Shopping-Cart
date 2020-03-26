<?php

namespace App\Modules\Cart;

use App\Modules\Cart\Cart;
use App\Modules\Video\CartPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class CartServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(GateContract $gate) {

        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views', 'cart');

        $gate->policy(Product::class, CartPolicy::class);

        $this->mergeConfigFrom(
            __DIR__.'/module.php', 'cart'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}
}