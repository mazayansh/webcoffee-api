<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Traits\DemoDataTestTrait;
use App\Models\ShippingInformation;

class ShippingMethodControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, DemoDataTestTrait;

    public function test_get_shipping_method_list_success()
    {
        $this->basicSeeding();
        $cartId = $this->getIdNewCart();
        $this->createShippingInformation([
            'shippingable_id' => $cartId,
            'city_code' => '352'
        ]);

        $response = $this->disableCookieEncryption()
                        ->withHeaders([
                            'accept' => 'application/json',
                            'key' => env('RAJAONGKIR_API_KEY')
                        ])->withCookie(
                            config('constants.cookie_name.cart'), 
                            $cartId
                        )->get('/api/v1/cart/shipping-method');
        
        $response->assertStatus(200)
                ->assertJson(fn (AssertableJson $json) => 
                    $json->has('data', 2,fn ($json) =>
                        $json->hasAll([
                                'shipping_method',
                                'shipping_description',
                                'shipping_cost',
                                'shipping_estimated_days'
                            ])
                            ->etc()
                        )
                        ->etc()
                );
    }
}
