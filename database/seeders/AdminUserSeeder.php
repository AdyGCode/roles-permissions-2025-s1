<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Prompts\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\ProgressBar;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $seedAdminUsers = [
            [
                'id' => 100,
                'name' => 'Ad Ministrator',
                'email' => 'admin@example.com',
                'password' => 'Password1',
                'email_verified_at' => now(),
                'roles'=>['staff','admin',]
            ],
            [
                'id' => 99,
                'name' => 'System Administrator',
                'email' => 'systemadmin@example.com',
                'password' => 'Password1',
                'email_verified_at' => now(),
                'roles'=>['super-admin',]
            ],
        ];


        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, count($seedAdminUsers));
        $progress->start();

        foreach ($seedAdminUsers as $user) {
            $roles = $user['roles'] ?? null;
            unset($user['roles']);

            $adminUser = User::updateOrCreate(
                ['id' => $user['id']],
                $user
            );

            $adminUser->assignRole($roles);
            $progress->advance();
        }

        $progress->finish();
        $output->writeln("");

    }
}
