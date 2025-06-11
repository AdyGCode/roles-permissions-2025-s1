<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Prompts\Output\ConsoleOutput;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $seedPermissions = [

            'browse post',
            'read any post',
            'read own post',
            'read any unpublished post',
            'read own unpublished post',
            'edit any post',
            'edit own post',
            'add post',
            'delete any post',
            'delete own post',
            'publish any post',
            'publish own post',
            'restore any post',
            'restore own post',
            'trash any post',
            'trash own post',


            'browse user',
            'read user',
            'edit user',
            'add user',
            'delete user',

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

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, count($seedPermissions));
        $output->writeln("");
        $output->writeln('Seed Permissions');
        $progress->start();

        foreach ($seedPermissions as $newPermission) {
            $permission = Permission::firstOrCreate(['name' => $newPermission]);
            $progress->advance();
        }

        $progress->finish();
        $output->writeln('');

        /* Allocate Permissions to Roles */

        /* Create Super-Admin Role and Sync Permissions */

        $progress = new ProgressBar($output, 4);
        $output->writeln("");
        $output->writeln('Grant Permissions to Roles');
        $progress->start();

        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super-admin']);

        $roleSuperAdmin->syncPermissions();
        $progress->advance();

        /* Create Admin Role and Sync Permissions */

        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);

        $adminPermissions = [
            'browse user', 'read user', 'edit user', 'add user', 'delete user',
            'browse post', 'read post', 'edit post', 'add post', 'delete post', 'publish post',
            'browse permission', 'read permission', 'edit permission', 'add permission', 'delete permission',
            'browse role', 'read role', 'edit role', 'add role', 'delete role',
        ];

        $roleAdmin->syncPermissions($adminPermissions);
        $progress->advance();

        /* Create Staff Role and Sync Permissions */

        $roleStaff = Role::firstOrCreate(['name' => 'staff']);

        $staffPermissions = [
            'browse user', 'read user', 'edit user', 'add user', 'delete user',
            'browse permission', 'read permission',
            'browse role', 'read role',
            'browse post', 'read post', 'edit post', 'add post', 'delete post',
        ];

        $roleStaff->syncPermissions($staffPermissions);
        $progress->advance();

        /* Create Client Role and Sync Permissions */

        $roleClient = Role::firstOrCreate(['name' => 'client']);

        $clientPermissions = [
            'browse post', 'read post', 'edit post', 'add post', 'delete post', 'publish post',
        ];

        $roleClient->syncPermissions($clientPermissions);
        $progress->advance();

        $progress->finish();
        $output->writeln("");

    }
}
