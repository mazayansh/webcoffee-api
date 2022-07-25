<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
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

class ShippingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

    public function test_cart_add_shipping_success()
    {
        $cartId = $this->getIdNewCart();
        ShippingInformation::factory()->create([
            'shippingable_id' => $cartId,
            'city_code' => '151'
        ]);

        $response = $this->disableCookieEncryption()
                        ->withHeaders([
                            'accept' => 'application/json',
                            'key' => env('RAJAONGKIR_API_KEY')
                        ])->withCookie(
                            config('constants.cookie_name.cart'), 
                            $cartId
                        )->post('/api/v1/cart/shipping', [
                            'shipping_method' => 'REG',
                        ]);
        
        $response->assertStatus(200)
                ->assertJson(fn (AssertableJson $json) => 
                    $json->has('shipping_info', fn ($json) =>
                        $json->where('shippingable_id', $cartId)
                            ->where('shippingable_type', 'App\Models\Cart')
                            ->where('city_code', '151')
                            ->where('shipping_method', 'REG')
                            ->has('shipping_cost')
                            ->etc()
                        )
                        ->etc()
                );
    }
}
