<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Notification;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(ClassSeeder::class);
        $this->call(TestSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $notifications = [
            [
                'content' => 'Bạn đã được duyệt vào khóa học '
            ],
        ];
        Notification::insert($notifications);

        // Schema::disableForeignKeyConstraints();
        // DB::table('user_lessons')->truncate();
        // Schema::enableForeignKeyConstraints();
        // DB::table('user_lessons')->insert([
        //     'user_id' => '4',
        //     'lesson_id' => '1',
        //     'status' => '1'
        // ]);

        // Schema::disableForeignKeyConstraints();
        // DB::table('user_courses')->truncate();
        // Schema::enableForeignKeyConstraints();
        // DB::table('user_courses')->insert([
        //     'user_id' => '4',
        //     'course_id' => '1',
        //     'status' => '1'
        // ]);
    }
}
