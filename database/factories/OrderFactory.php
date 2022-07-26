<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => null,
            'payment_method' => \App\Enums\PaymentMethodEnum::random(),
            'status' => 'pending',
            'total_price' => 0.00,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
