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
            'title'=> $this->faker->text(100),
            'slug'=>$this->faker->text(100),
            'statistic_id' =>$this -> faker->numberBetween(1, 1000),
            //'category_id'=>$this->faker->numberBetween(1,1000),
            'description'=> $this->faker->text(2000),
            'image'=>$this->faker->text(100),
            
        ];
    }
}
