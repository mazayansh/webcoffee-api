<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\CustomerRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Interfaces\RoastRepositoryInterface;
use App\Repositories\RoastRepository;
use App\Interfaces\TypeRepositoryInterface;
use App\Repositories\TypeRepository;

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
