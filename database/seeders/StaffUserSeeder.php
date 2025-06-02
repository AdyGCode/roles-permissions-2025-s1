<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class StaffUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedUser = [

            'id' => 200,
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => 'Password1',
            'email_verified_at' => null,
        ];

        $staffUser = User::updateOrCreate(
            ['id' => $seedUser['id']],
            $seedUser
        );


        $staffUser->assignRole('staff');
    }
}
