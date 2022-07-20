<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    UserRepositoryInterface,
    CustomerRepositoryInterface,
    RoastRepositoryInterface,
    TypeRepositoryInterface,
    ProductRepositoryInterface,
    CartRepositoryInterface,
    CartItemRepositoryInterface,
    ShippingInformationRepositoryInterface
};
use App\Repositories\{
    UserRepository,
    CustomerRepository,
    RoastRepository,
    TypeRepository,
    ProductRepository,
    CartRepository,
    CartItemRepository,
    ShippingInformationRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(RoastRepositoryInterface::class, RoastRepository::class);
        $this->app->bind(TypeRepositoryInterface::class, TypeRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartItemRepositoryInterface::class, CartItemRepository::class);
        $this->app->bind(ShippingInformationRepositoryInterface::class, ShippingInformationRepository::class);
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
