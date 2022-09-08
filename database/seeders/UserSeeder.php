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
        // \App\Models\User::factory()->count(10)->create()->each(function($user) {
        //     DB::table('activations')->insert([
        //         'user_id' => $user->id,
        //         'code' => fake()->password(),
        //         'completed' => '1'
        //     ]);
        //     DB::table('role_users')->insert([
        //         'user_id' => $user->id,
        //         'role_id' => '5',
        //     ]);
        // });
        DB::table('role_users')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions'=> '{"dashboard":true,"acl.all":true,"user.status":true}',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'permissions'=> '{"dashboard":true,"acl.all":true,"user.status":true}',
            ],
            [
                'name' => 'Teacher',
                'slug' => 'teacher',
                'permissions'=> '{"dashboard":true,"acl.all":true,"user.status":true}',
            ],
            [
                'name' => 'Class Manager',
                'slug' => 'class-manager',
                'permissions'=> '{"dashboard":true,"acl.all":true,"user.status":true}',
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
                'permissions'=> '{"dashboard":true,"acl.all":true,"user.status":true}',
            ],
        ];

        Role::insert($roles);

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
