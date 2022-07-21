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
        $cityCodes = ['151','22','398','445','444','255'];

        return [
            'shippingable_type' => 'App\Models\Cart',
            'shippingable_id' => fake()->uuid,
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->safeEmail,
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'city' => fake()->city,
            'city_code' => $cityCodes[array_rand($cityCodes)],
            'state' => fake()->state,
            'postcode' => fake()->postcode,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
