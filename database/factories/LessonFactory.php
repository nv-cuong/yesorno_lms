<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'unit_id'=>	fake()->numberBetween(1, 10),
            'title'	=> fake()->name(),
            'slug'	=>fake()->url(),
            'content'	=>fake()->text(100),
            'config'	=> fake()->randomElement(['must', 'option']),
            'path'    =>fake()->url(),
            'published'=>fake()->date(),
        ];
    }
}
