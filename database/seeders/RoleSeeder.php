<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPermissions       = require __DIR__ . '/permissions/admin.php';
        $managerPermissions     = require __DIR__ . '/permissions/manager.php';
        $teacherPermissions     = require __DIR__ . '/permissions/teacher.php';
        $classMngPermissions    = require __DIR__ . '/permissions/classManager.php';
        $studentPermissions     = require __DIR__ . '/permissions/student.php';

        $roles = [
            [
                'name'          => 'Admin',
                'slug'          => 'admin',
                'permissions'   => json_encode($adminPermissions, JSON_FORCE_OBJECT),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Manager',
                'slug'          => 'manager',
                'permissions'   => json_encode($managerPermissions, JSON_FORCE_OBJECT),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Teacher',
                'slug'          => 'teacher',
                'permissions'   => json_encode($teacherPermissions, JSON_FORCE_OBJECT),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Class Manager',
                'slug'          => 'class-manager',
                'permissions'   => json_encode($classMngPermissions, JSON_FORCE_OBJECT),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Student',
                'slug'          => 'student',
                'permissions'   => json_encode($studentPermissions, JSON_FORCE_OBJECT),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];
        Role::insert($roles);
    }
}
