<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    UserServiceInterface,
    RoastServiceInterface,
    TypeServiceInterface,
    ProductServiceInterface
};
use App\Services\{
    UserService,
    RoastService,
    TypeService,
    ProductService
};

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(RoastServiceInterface::class, RoastService::class);
        $this->app->bind(TypeServiceInterface::class, TypeService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
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
