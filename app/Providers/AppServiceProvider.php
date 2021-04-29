<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\Manager\ProductManager;

use App\Factories\Manager\IProductManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(IProductManager::class, function ($app) {
            return new ProductManager($app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
