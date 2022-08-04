<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Traits\DemoDataTestTrait;

class CartControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, DemoDataTestTrait;

    public function test_get_cart_items_by_cart_id_cookie_ref_success()
    {
        $this->basicSeeding();
        $cartId = $this->getIdNewCart();

        $response = $this->disableCookieEncryption()->withHeaders([
                            'accept' => 'application/json'
                        ])->withCookie(config('constants.cookie_name.cart'), $cartId)
                        ->get('/api/v1/cart');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 3, fn ($json) => 
                    $json->hasAll([
                            'id','cart_id','product_id','product_name','grind_size','weight','quantity','price','price_per_item','featured_image_url'
                        ])
                        ->where('cart_id', $cartId)
                )
            );
    }

    public function test_get_cart_items_by_cart_id_user_ref_success()
    {
        $this->generateAccessToken();
        $this->basicSeeding();
        $cartId = $this->getIdNewCart();

        $response = $this->getJson('/api/v1/cart');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 3, fn ($json) => 
                    $json->hasAll([
                            'id','cart_id','product_id','product_name','grind_size','weight','quantity','price','price_per_item','featured_image_url'
                        ])
                        ->where('cart_id', $cartId)
                )
            );
    }

    public function test_get_cart_items_by_cart_id_new_cookie_ref_success()
    {
        $this->basicSeeding();
        $cartId = $this->getIdNewCart();

        $response = $this->getJson('/api/v1/cart');

        $response->assertStatus(200)
                ->assertCookieNotExpired(config('constants.cookie_name.cart'))
                ->assertJson(fn (AssertableJson $json) =>
                    $json->has('data', 0)
                );
    }
}
