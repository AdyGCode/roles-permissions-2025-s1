<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedUsers = [
// Admin now in the AdminUserSeeder
//            [
//                'id' => 100,
//                'name' => 'Ad Ministrator',
//                'email' => 'admin@example.com',
//                'password' => 'Password1',
//                'email_verified_at' => now(),
//            ],
//
// Staff User is now in the Staff User Seeder
//            [
//                'id' => 200,
//                'name' => 'Staff User',
//                'email' => 'staff@example.com',
//                'password' => 'Password1',
//                'email_verified_at' => null,
//            ],

            [
                'id' => 201,
                'name' => 'Client User',
                'email' => 'client@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
                'role' => 'client',
            ],

            [
                'id' => 202,
                'name' => 'Another User',
                'email' => 'another@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,

            ],
        ];

        foreach ($seedUsers as $user) {
            $role = $user['role']??null;
            unset($user['role']);

            $clientUser = User::updateOrCreate(
                ['id' => $user['id']],
                $user
            );

            if ($role === 'client') {
                $clientUser->assignRole('client');
            }
        }

    }
}
