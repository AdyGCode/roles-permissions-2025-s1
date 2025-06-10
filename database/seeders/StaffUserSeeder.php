<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Prompts\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\ProgressBar;

class StaffUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $seedStaffUsers = [
            [
                'id' => 200,
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'password' => 'Password1',
                'email_verified_at' => now(),
                'roles' => ['staff',],
            ],
            [
                'id' => 201,
                'name' => 'Staff User 2',
                'email' => 'staff2@example.com',
                'password' => 'Password1',
                'email_verified_at' => now(),
                'roles' => ['staff', 'client'],
            ],
            [
                'id' => 203,
                'name' => 'Staff User 3',
                'email' => 'staff3@example.com',
                'password' => 'Password1',
                'email_verified_at' => now(),
                'roles' => ['staff'],
            ],
        ];

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, count($seedStaffUsers));
        $progress->start();

        foreach ($seedStaffUsers as $user) {
            $roles = $user['roles'] ?? null;
            unset($user['roles']);

            $staffUser = User::updateOrCreate(
                ['id' => $user['id']],
                $user
            );

            $staffUser->assignRole($roles);
            $progress->advance();
        }

        $progress->finish();
        $output->writeln("");

    }
}
