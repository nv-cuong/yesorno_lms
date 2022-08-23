<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Course::factory()
        ->count(10)
        ->create();

        $courses = Course::all();

        foreach ($courses as $course)
        {
            $course->slug = \Str::slug($course->title);
            $course->save();
        }
    }
}
