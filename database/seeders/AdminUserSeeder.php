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
            'admin',
            'staff',
        ]);

    }
}
