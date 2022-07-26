<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Traits\DemoDataTestTrait;

class OrderPaymentControllerTest extends TestCase
{
    use RefreshDatabase, DemoDataTestTrait;

    public function test_payment_notification_handle_success()
    {
        $this->basicSeeding();
        $orderId = (string) $this->getIdNewOrder();

        $data = <<<NOTIF
        {
            "va_numbers": [
                {
                    "va_number": "9887387133093468",
                    "bank": "bni"
                }
            ],
            "transaction_time": "2022-07-26 14:42:57",
            "transaction_status": "settlement",
            "transaction_id": "8f856f2d-a182-4893-952b-814f34cdec6d",
            "status_message": "midtrans payment notification",
            "status_code": "200",
            "signature_key": "0e23babd77e31b29d194030ed92ec562a9df55492a077e88e40b905397cbe4ebf44032bde964deb15fe2fbfe1c205611df14ddc0ecc9b4b61270b09546a8e56f",
            "settlement_time": "2022-07-26 14:43:42",
            "payment_type": "bank_transfer",
            "payment_amounts": [
                {
                    "paid_at": "2022-07-26 14:43:41",
                    "amount": "460028.00"
                }
            ],
            "order_id": "$orderId",
            "merchant_id": "G889573871",
            "gross_amount": "460028.00",
            "fraud_status": "accept",
            "currency": "IDR"
        }
        NOTIF;

        $response = $this->postJson('/api/v1/orders/payment/notification/handling', json_decode($data, true));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message', 'Order payment status successfully updated')
                    ->where('status', 'settlement')
            );
    }
}
