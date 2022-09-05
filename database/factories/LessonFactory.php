<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
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
        $title = fake()->text(10);
        $slug = Str::slug($title, '-');

        return [
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->text(200),
            'config' => fake()->randomElement(['must', 'optional']),
            'published' => fake()->date(),
        ];
    }
}
