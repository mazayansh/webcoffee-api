<?php

namespace App\Traits;

use Database\Seeders\{
    RoastSeeder,
    TypeSeeder,
    ProductSeeder,
    ProductVariantSeeder
};
use App\Models\{
    Cart,
    CartItem,
    Customer,
    User,
    ShippingInformation
};
use App\Repositories\UserRepository;
use App\Repositories\CustomerRepository;
use App\Services\UserService;

/**
 * Trait for demo data for test
 */
trait DemoDataTestTrait
{
    private function insertUserRecord(): void
    {
        Customer::factory()->create([
            'first_name' => 'User',
            'last_name' => 'Example',
            'email' => 'user@example.com'
        ]);

        User::factory()->create([
            'customer_id' => 1,
            'email' => 'user@example.com',
            'password' => '$2y$10$9wouA3lix1KLH.r1TMuBM.6thdEO7piwlzSuU2kF8pfDL1VvD77fO'//12345678,
        ]);
    }

    private function generateAccessToken(): void
    {
        $this->insertUserRecord();

        $userService = new UserService(new UserRepository, new CustomerRepository);
        $loginResponse = $userService->login([
            'email' => 'user@example.com',
            'password' => '12345678'
        ]);
    }

    private function getIdNewCart()
    {
        $this->seed([
            RoastSeeder::class,
            TypeSeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class
        ]);

        $cart = Cart::factory()->create([
            'user_id' => optional(auth()->user())->id ?? null
        ]);
        CartItem::factory()->count(3)->create([
            'cart_id'  => $cart->id
        ]);

        return $cart->id;
    }

    private function createShippingInformation(array $shippingInfoDetails)
    {
        ShippingInformation::factory()->create($shippingInfoDetails);
    }
}

