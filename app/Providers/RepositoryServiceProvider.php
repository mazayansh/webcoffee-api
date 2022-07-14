<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    UserRepositoryInterface,
    CustomerRepositoryInterface,
    RoastRepositoryInterface,
    TypeRepositoryInterface,
    ProductRepositoryInterface
};
use App\Repositories\{
    UserRepository,
    CustomerRepository,
    RoastRepository,
    TypeRepository,
    ProductRepository
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
