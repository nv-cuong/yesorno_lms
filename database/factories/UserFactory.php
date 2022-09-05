<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => fake()->safeEmail(),
            'password' => fake()->password(), // password
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'birthday' => fake()->date(),
            'address' => fake()->address(),
            'age' => fake()->numberBetween(1, 100),
            'gender' => fake()->randomElement(['male', 'female','other']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
