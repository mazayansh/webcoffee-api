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

    public function test_get_cart_items_by_cart_id_cookie_ref_success()
    {
        $cartId = $this->getIdNewCart();

        $response = $this->disableCookieEncryption()->withHeaders([
                            'accept' => 'application/json'
                        ])->withCookie(config('constants.cookie_name.cart'), $cartId)
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
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 3, fn ($json) => 
                    $json->hasAll([
                            'id','cart_id','product_id','product_name','grind_size','weight','quantity','price'
                        ])
                        ->where('cart_id', $cartId)
                )
            );
    }

    public function test_get_cart_items_by_cart_id_new_cookie_ref_success()
    {
        $cartId = $this->getIdNewCart();

        $response = $this->getJson('/api/v1/cart');

        $response->assertStatus(200)
                ->assertCookieNotExpired(config('constants.cookie_name.cart'))
                ->assertJson(fn (AssertableJson $json) =>
                    $json->has('data', 0)
                );
    }

    public function test_cart_checkout_validation_fail()
    {
        $cartId = $this->getIdNewCart();

        $response = $this->disableCookieEncryption()
                        ->withHeaders([
                            'accept' => 'application/json'
                        ])->withCookie(
                            config('constants.cookie_name.cart'), 
                            $cartId
                        )->post('/api/v1/cart/checkout');

        $response->assertStatus(422)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->hasAll(['message','errors'])
                );
    }

    public function test_cart_checkout_empty()
    {
        $response = $this->postJson('/api/v1/cart/checkout', [
                        'email' => 'imam@example.com',
                        'first_name' => 'Imam',
                        'last_name' => 'Setiawan',
                        'phone' => '013412',
                        'address' => 'Wungusari RT 16, Tegaldowo',
                        'city' => 'Sragen',
                        'city_code' => '427',
                        'state' => 'Jawa Tengah',
                        'postcode' => '57274'
                    ]);

        $response->assertStatus(400)
                ->assertCookieNotExpired(config('constants.cookie_name.cart'))
                ->assertJson([
                    'message' =>'Your cart is empty. Please add our special coffee product to your cart first.'
                ]);
    }

    public function test_cart_checkout_success()
    {
        $cartId = $this->getIdNewCart();

        $response = $this->disableCookieEncryption()
                        ->withHeaders([
                            'accept' => 'application/json'
                        ])->withCookie(
                            config('constants.cookie_name.cart'), 
                            $cartId
                        )->post('/api/v1/cart/checkout', [
                            'email' => 'imam@example.com',
                            'first_name' => 'Imam',
                            'last_name' => 'Setiawan',
                            'phone' => '013412',
                            'address' => 'Wungusari RT 16, Tegaldowo',
                            'city' => 'Sragen',
                            'city_code' => '427',
                            'state' => 'Jawa Tengah',
                            'postcode' => '57274'
                        ]);

        $response->assertStatus(201)
                ->assertJson(fn (AssertableJson $json) => 
                    $json->has('shipping_address', fn ($json) =>
                        $json->where('shippingable_id', $cartId)
                            ->where('shippingable_type', 'App\Models\Cart')
                            ->where('email', 'imam@example.com')
                            ->where('first_name', 'Imam')
                            ->where('last_name', 'Setiawan')
                            ->where('phone', '013412')
                            ->where('address', 'Wungusari RT 16, Tegaldowo')
                            ->where('city', 'Sragen')
                            ->where('state', 'Jawa Tengah')
                            ->where('postcode', '57274')
                            ->etc()
                        )
                        ->etc()
                );
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
