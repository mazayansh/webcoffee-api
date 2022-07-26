<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id' => fake()->uuid(),
            'transaction_id' => fake()->uuid(),
            'transaction_time' => now(),
            'payment_type' => 'bank_transfer',
            'va_number' => '000',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
