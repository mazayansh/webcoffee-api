<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cart_id' => \App\Models\Cart::inRandomOrder()->first()->id,
            'product_variant_id' => \App\Models\ProductVariant::inRandomOrder()->first()->id,
            'quantity' => rand(1, 10),
            'grind_size' => \App\Enums\GrindSizeEnum::random(),
            'created_at' => now(),
            'updated_at' => null
        ];
    }
}
