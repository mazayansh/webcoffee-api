<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Traits\DemoDataTestTrait;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, DemoDataTestTrait;

    public function test_cart_checkout_validation_fail()
    {
        $this->basicSeeding();
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
        $this->basicSeeding();
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
}
