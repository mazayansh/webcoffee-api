<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $productVariant = \App\Models\ProductVariant::inRandomOrder()->first();
        $quantity = rand(1, 10);

        return [
            'order_id' => \App\Models\Order::inRandomOrder()->first()->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => $quantity,
            'grind_size' => \App\Enums\GrindSizeEnum::random(),
            'subtotal_price' => $quantity * $productVariant->price,
            'created_at' => now(),
            'updated_at' => null
        ];
    }
}
