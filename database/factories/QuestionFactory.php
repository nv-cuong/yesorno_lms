<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category'=> $this->faker->randomElement([0]),
            'content'=>$this->faker->text(10),
            'course_id' =>$this -> faker->numberBetween(1,10),
            'score'=>$this -> faker->numberBetween(1, 100),
        ];
    }
}
