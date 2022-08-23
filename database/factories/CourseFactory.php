<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
            return [
                'title' => fake()->name(),
                'slug'=>fake()->url(),
                'statistic_id'=>fake()->numberBetween(1, 5),
                'description'=>fake()->text(1000),
                'begin_date'=>fake()->date(),
                'end_date'=>fake()->date(),
                'image'=>fake()->imageUrl(),
            ];

    }
}
