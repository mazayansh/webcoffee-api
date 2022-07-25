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
    ShippingInformationRepositoryInterface,
    BillingAddressRepositoryInterface,
    OrderRepositoryInterface,
    PaymentRepositoryInterface
};
use App\Repositories\{
    UserRepository,
    CustomerRepository,
    RoastRepository,
    TypeRepository,
    ProductRepository,
    CartRepository,
    CartItemRepository,
    ShippingInformationRepository,
    BillingAddressRepository,
    OrderRepository,
    PaymentRepository
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
        $this->app->bind(BillingAddressRepositoryInterface::class, BillingAddressRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
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
