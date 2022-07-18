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
    User
};
use App\Repositories\UserRepository;
use App\Repositories\CustomerRepository;
use App\Services\UserService;

class CartControllerTest extends TestCase
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

    public function test_create_new_cart_success()
    {
        $response = $this->postJson('/api/v1/cart');

        $response->assertStatus(200)->assertCookieNotExpired('KOPISLUR-CART-ID');
    }

    public function test_get_cart_items_by_cart_id_cookie_ref_success()
    {
        $cartId = $this->getIdNewCart();

        $response = $this->disableCookieEncryption()->withHeaders([
                            'accept' => 'application/json'
                        ])->withCookie('KOPISLUR-CART-ID', $cartId)
                        ->get('/api/v1/cart');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 3, fn ($json) => 
                    $json->hasAll([
                            'id','cart_id','product_id','product_name','grind_size','weight','quantity','price'
                        ])
                        ->where('cart_id', $cartId)
                )
            );
    }

    public function test_get_cart_items_by_cart_id_user_ref_success()
    {
        $this->generateAccessToken();
        $cartId = $this->getIdNewCart();

        $response = $this->getJson('/api/v1/cart');

        $response->assertStatus(200)
                ->assertCookieNotExpired('KOPISLUR-CART-ID')
                ->assertJson(fn (AssertableJson $json) =>
                    $json->has('data', 3, fn ($json) => 
                        $json->hasAll([
                                'id','cart_id','product_id','product_name','grind_size','weight','quantity','price'
                            ])
                            ->where('cart_id', $cartId)
                    )
                );
    }

    public function test_get_cart_items_by_cart_id_no_cookie_ref_success()
    {
        $response = $this->get('/api/v1/cart');

        $response->assertStatus(200)
                ->assertCookieNotExpired('KOPISLUR-CART-ID')
                ->assertJson(fn (AssertableJson $json) =>
                    $json->has('data', 0)
                );
    }
}
