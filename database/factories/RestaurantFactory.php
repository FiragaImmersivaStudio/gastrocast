<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Restaurant',
            'category' => fake()->randomElement(['Fast Food', 'Fine Dining', 'Casual Dining', 'Cafe']),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'timezone' => 'Asia/Jakarta',
            'currency' => 'IDR',
            'is_active' => true,
        ];
    }
}
