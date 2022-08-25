<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::factory()
        ->count(5)
        ->hasQuestions(10)
        ->has(
            Unit::factory()
            ->count(10)
            ->has(
                Lesson::factory()
                ->count(20)
            )
        )
        ->create();
    }
}
