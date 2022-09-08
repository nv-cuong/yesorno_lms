<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schema::disableForeignKeyConstraints();
        // DB::table('tests')->truncate();
        // DB::table('test_questions')->truncate();
        // DB::table('user_tests')->truncate();
        // DB::table('course_tests')->truncate();
        // DB::table('user_test_answers')->truncate();
        // Schema::enableForeignKeyConstraints();
        // DB::table('tests')->insert([
        //     'id' => '4',
        //     'category' => 'Tự luận',
        //     'amount' => '12',
        //     'title' => 'abc',
        //     'time' => '60',
        //     'description' => 'abcdefgh'
        // ]);


        // DB::table('test_questions')->insert([
        //     'test_id' => '4',
        //     'question_id' => '6',
        // ]);

        // DB::table('user_tests')->insert([
        //     [
        //         'user_id' => '4',
        //         'test_id' => '4',
        //         'status' => '0'
        //     ],
        //     [
        //         'user_id' => '2',
        //         'test_id' => '4',
        //         'status' => '0'
        //     ],
        //     [
        //         'user_id' => '1',
        //         'test_id' => '4',
        //         'status' => '1'
        //     ],
        // ]);

        // DB::table('course_tests')->insert([
        //     'course_id' => '1',
        //     'test_id' => '4',
        // ]);

        // DB::table('user_test_answers')->insert([
        //     'user_test_id' => '1',
        //     'question_id' => '4',
        //     'answer' => 'asdasd'
        // ]);

    }
}
