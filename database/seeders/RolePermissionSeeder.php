<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view tickets']);
        Permission::create(['name' => 'create tickets']);
        Permission::create(['name' => 'update tickets']);
        Permission::create(['name' => 'delete tickets']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view analytics']);
        Permission::create(['name' => 'assign tickets']);

        $student = Role::create(['name' => 'student']);
        $student->givePermissionTo(['view tickets', 'create tickets']);

        $faculty = Role::create(['name' => 'faculty']);
        $faculty->givePermissionTo(['view tickets', 'update tickets', 'delete tickets']);

        $staff = Role::create(['name' => 'staff']);
        $staff->givePermissionTo(['view tickets', 'update tickets', 'delete tickets', 'assign tickets']);

        $maintenance = Role::create(['name' => 'maintenance']);
        $maintenance->givePermissionTo(['view tickets', 'update tickets', 'delete tickets']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
