<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //


        $seedPermissions = [
            'browse user',
            'read user',
            'edit user',
            'add user',
            'delete user',

            'browse post',
            'read post',
            'edit post',
            'add post',
            'delete post',
            'publish post',

            'browse permission',
            'read permission',
            'edit permission',
            'add permission',
            'delete permission',

            'browse role',
            'read role',
            'edit role',
            'add role',
            'delete role',

        ];

        foreach ($seedPermissions as $newPermision) {
            Permission::firstOrCreate(['name' => $newPermision]);
        }


        $roleSuperAdmin = Role::firstOrCreate(['name' => 'Super-Admin']);
        $roleSuperAdmin->syncPermissions();


        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $adminPermissions = [
            'browse user', 'read user', 'edit user', 'add user', 'delete user',
            'browse post', 'read post', 'edit post', 'add post', 'delete post', 'publish post',
            'browse permission', 'read permission', 'edit permission', 'add permission', 'delete permission',
            'browse role', 'read role', 'edit role', 'add role', 'delete role',
        ];
        $roleAdmin->syncPermissions($adminPermissions);


        $roleStaff = Role::firstOrCreate(['name' => 'Staff']);
        $staffPermissions = [
            'browse user', 'read user', 'edit user', 'add user', 'delete user',
            'browse permission', 'read permission',
            'browse role', 'read role',
        ];
        $roleStaff->syncPermissions($staffPermissions);


        $roleClient = Role::create(['name' => 'Client']);
        $clientPermissions = [
            'browse post', 'read post', 'edit post', 'add post', 'delete post', 'publish post',
        ];
        $roleClient->syncPermissions($clientPermissions);

    }
}
