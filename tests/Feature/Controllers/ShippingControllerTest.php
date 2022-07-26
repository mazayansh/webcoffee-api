<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Traits\DemoDataTestTrait;
use App\Models\ShippingInformation;

class ShippingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, DemoDataTestTrait;

    public function test_cart_add_shipping_success()
    {
        $cartId = $this->getIdNewCart();
        $this->createShippingInformation([
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
