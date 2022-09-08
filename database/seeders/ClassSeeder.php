<?php

namespace Database\Seeders;

use App\Models\ClassStudy;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        // $class = ClassStudy::factory()
        // ->count(15)
        // ->create();
        DB::table('class_studies')->insert([
            'name' => 'html css',
            'slug'=> 'html-css',
            'description'=>'Học lập trình HTML CSS, Biết cách tạo giao diện trang web',
            'schedule' => '1'
        ]);
    }
}
