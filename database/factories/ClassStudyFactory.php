<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClassStudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->text(30);
        $slug = Str::slug($name, '-');
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->text(1000),
            'schedule' => fake()->numberBetween(0, 2),
        ];
    }
}
