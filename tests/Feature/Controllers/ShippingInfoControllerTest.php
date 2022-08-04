<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Traits\DemoDataTestTrait;
use App\Models\ShippingInformation;

class ShippingInfoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, DemoDataTestTrait;

    public function test_get_shipping_info_success()
    {
        $this->basicSeeding();
        $cartId = $this->getIdNewCart();
        $this->createShippingInformation([
            'shippingable_id' => $cartId,
            'city_code' => '151'
        ]);

        $response = $this->disableCookieEncryption()
                        ->withHeaders([
                            'accept' => 'application/json'
                        ])->withCookie(
                            config('constants.cookie_name.cart'), 
                            $cartId
                        )->get('/api/v1/cart/shipping-info');
        
        $response->assertStatus(200)
                ->assertJson(fn (AssertableJson $json) => 
                    $json->has('data', fn ($json) =>
                        $json->where('shippingable_id', $cartId)
                            ->where('shippingable_type', 'App\Models\Cart')
                            ->hasAll(['first_name','email','address','city','state','postcode'])
                            ->etc()
                        )
                        ->etc()
                );
    }
}
