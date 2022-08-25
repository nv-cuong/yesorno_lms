<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Unit;
use App\Models\Lesson;
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
        DB::table('courses')->truncate();
        DB::table('units')->truncate();
        DB::table('lessons')->truncate();
        \App\Models\Course::factory()
        ->count(5)
        ->has(
            Unit::factory()
            ->count(10)
            ->has(
                Lesson::factory()
                ->count(20)
                )
            )
        ->create();

        $courses = Course::all();

        foreach ($courses as $course)
        {
            $course->slug = \Str::slug($course->title);
            $course->save();
        }
    }
}
