<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingInformation>
 */
class ShippingInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cities = ['Jakarta Pusat', 'Bandung', 'Semarang', 'Solo', 'Surabaya', 'Malang'];
        $cityCodes = ['152','22','398','445','444','255'];
        $randIndex = array_rand($cities);

        return [
            'shippingable_type' => 'App\Models\Cart',
            'shippingable_id' => fake()->uuid(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'city' => $cities[$randIndex],
            'city_code' => $cityCodes[$randIndex],
            'state' => fake()->state(),
            'postcode' => fake()->postcode(),
            'shipping_method' => 'REG',
            'shipping_cost' => 24000.00,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
