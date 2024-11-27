<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $manageStudents = Permission::create(['name' => 'manage students']);
        $viewReports = Permission::create(['name' => 'view reports']);

        $adminRole->givePermissionTo($manageStudents);
        $adminRole->givePermissionTo($viewReports);
        $userRole->givePermissionTo($viewReports);
    }
}
