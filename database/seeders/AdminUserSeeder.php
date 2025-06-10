<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /* Super Administrator Account */
        $seedSuperAdminUser = [
            'id' => 99,
            'name' => 'System Administrator',
            'email' => 'systemadmin@example.com',
            'password' => 'Password1',
            'email_verified_at' => now(),
        ];

        $adminUser = User::updateOrCreate(
            ['id' => $seedSuperAdminUser['id']],
            $seedSuperAdminUser
        );


        /* Administrator Account */
        $seedUser = [
            'id' => 100,
            'name' => 'Ad Ministrator',
            'email' => 'admin@example.com',
            'password' => 'Password1',
            'email_verified_at' => now(),
        ];


        $adminUser = User::updateOrCreate(
            ['id' => $seedUser['id']],
            $seedUser
        );

        $adminUser->assignRole([
            'Admin',
            'Staff',
        ]);

    }
}
