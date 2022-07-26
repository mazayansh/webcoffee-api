<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Traits\DemoDataTestTrait;

class CartItemControllerTest extends TestCase
{
    use RefreshDatabase, DemoDataTestTrait;

    private $cartId;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->cartId = $this->getIdNewCart();
    }

    public function test_add_cart_item_success()
    {
        $response = $this->disableCookieEncryption()
                        ->withHeaders([
                            'accept' => 'application/json'
                        ])
                        ->withCookie(
                            config('constants.cookie_name.cart'), 
                            $this->cartId
                        )
                        ->post('/api/v1/cart/cart-items', [
                            'product_variant_id' => 2,
                            'grind_size' => 'coarse',
                            'quantity' => 2
                        ]);
                    
        $response->assertStatus(201)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->where('created', true)
                        ->has('cart_item', fn ($json) =>
                            $json->where('product_name', 'BALI BLUE MOON SINGLE ORIGIN DARK ROAST COFFEE')
                                ->where('grind_size', 'coarse')
                                ->where('quantity', 2)
                                ->etc()
                        )
                        ->etc()
                );
    }

    public function test_update_cart_item_success()
    {
        $response = $this->putJson('/api/v1/cart/cart-items/2', [
                            'quantity' => 24
                        ]);
                
        $response->assertStatus(200)
            ->assertJson(['updated' => true]);
    }

    public function test_update_cart_item_failed_not_found()
    {
        $response = $this->putJson('/api/v1/cart/cart-items/200', [
                            'quantity' => 24
                        ]);
                
        $response->assertStatus(404)
            ->assertJson(['updated' => false]);
    }

    public function test_remove_cart_item_success()
    {
        $response = $this->deleteJson('/api/v1/cart/cart-items/2');
                
        $response->assertStatus(200)
            ->assertJson(['deleted' => true]);
    }

    public function test_remove_cart_item_failed_not_found()
    {
        $response = $this->deleteJson('/api/v1/cart/cart-items/200');
                
        $response->assertStatus(404)
            ->assertJson(['deleted' => false]);
    }
}
