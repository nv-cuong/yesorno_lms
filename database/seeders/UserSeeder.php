<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();

        $this->call(RoleSeeder::class);

        $users = [
            [
                'email' => 'admin@example.com',
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'phone' => '0906216933',
                'birthday' => fake()->date(),
                'address' => fake()->address(),
                'age' => fake()->numberBetween(1, 100),
                'gender' => fake()->randomElement(['male', 'female']),
                'stu_id' => 'AD001',
            ],
            [
                'email' => 'manager@example.com',
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'phone' => '0906216933',
                'birthday' => fake()->date(),
                'address' => fake()->address(),
                'age' => fake()->numberBetween(1, 100),
                'gender' => fake()->randomElement(['male', 'female']),
                'stu_id' => 'QL001',
            ],
            [
                'email' => 'teacher@example.com',
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'phone' => '0906216933',
                'birthday' => fake()->date(),
                'address' => fake()->address(),
                'age' => fake()->numberBetween(1, 100),
                'gender' => fake()->randomElement(['male', 'female']),
                'stu_id' => 'GV001',
            ],
            [
                'email' => 'student@example.com',
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'phone' => '0906216933',
                'birthday' => fake()->date(),
                'address' => fake()->address(),
                'age' => fake()->numberBetween(1, 100),
                'gender' => fake()->randomElement(['male', 'female']),
                'stu_id' => 'SV001',
            ],
            [
                'email' => 'classmanager@example.com',
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'phone' => '0906216933',
                'birthday' => fake()->date(),
                'address' => fake()->address(),
                'age' => fake()->numberBetween(1, 100),
                'gender' => fake()->randomElement(['male', 'female']),
                'stu_id' => 'QLL001',
            ],
        ];

        foreach ($users as $userItem) {
            //$user  =  \App\Models\User::factory()->create($userItem);
            $userItem['password'] = '1234567@';
            $user = Sentinel::registerAndActivate($userItem);
            switch ($userItem['email']) {
                case 'admin@example.com':
                    $role = Sentinel::findRoleBySlug('admin');
                    $role->users()->attach($user);
                    break;
                case 'manager@example.com':
                    $role = Sentinel::findRoleBySlug('manager');
                    $role->users()->attach($user);
                    break;
                case 'classmanager@example.com':
                    $role = Sentinel::findRoleBySlug('class-manager');
                    $role->users()->attach($user);
                    break;
                case 'teacher@example.com':
                    $role = Sentinel::findRoleBySlug('teacher');
                    $role->users()->attach($user);
                    break;
                case 'student@example.com':
                    $role = Sentinel::findRoleBySlug('student');
                    $role->users()->attach($user);
                    break;
            }
        }
    }
}
