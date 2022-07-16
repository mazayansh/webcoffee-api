<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    UserServiceInterface,
    RoastServiceInterface,
    TypeServiceInterface,
    ProductServiceInterface,
    CartServiceInterface,
    CartItemServiceInterface
};
use App\Services\{
    UserService,
    RoastService,
    TypeService,
    ProductService,
    CartService,
    CartItemService
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
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(CartItemServiceInterface::class, CartItemService::class);
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
