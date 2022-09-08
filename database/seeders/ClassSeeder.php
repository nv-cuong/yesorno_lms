<?php

namespace Database\Seeders;

use App\Models\ClassStudy;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_studies')->truncate();

        // DB::table('class_studies')->insert([
        //     'name' => 'html css',
        //     'slug' => 'html-css',
        //     'description' => 'Học lập trình HTML CSS, Biết cách tạo giao diện trang web',
        //     'schedule' => '1'
        // ]);

        $class = ClassStudy::factory()
        ->count(15)
        ->create();

        // Schema::disableForeignKeyConstraints();
        // DB::table('class_study_users')->truncate();
        // Schema::enableForeignKeyConstraints();
        // DB::table('class_study_users')->insert([
        //     [
        //         'class_study_id' => '1',
        //         'user_id' => '1',
        //     ],
        //     [
        //         'class_study_id' => '1',
        //         'user_id' => '2',
        //     ],
        //     [
        //         'class_study_id' => '2',
        //         'user_id' => '1',
        //     ],
        //     [
        //         'class_study_id' => '3',
        //         'user_id' => '3',
        //     ],
        // ]);
    }
}
