<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = fake()->text(10);
        $slug = Str::slug($title, '-');

        return [
            'title' => $title,
            'slug' => $slug,
            'statistic_id' => fake()->numberBetween(1, 1000),
            'description' => fake()->text(1000),
            'status'=> fake()->boolean(),
            'begin_date' => fake()->date(),
            'end_date' => fake()->date(),
            'image' => fake()->imageUrl(),
        ];
    }
}
