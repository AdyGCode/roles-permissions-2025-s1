<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Prompts\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\ProgressBar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedClientUsers = [
            [
                'id' => 501,
                'name' => 'Client User',
                'email' => 'client@example.com',
                'password' => 'Password1',
                'email_verified_at' => now(),
                'roles' => ['client',],
            ],
            [
                'id' => 502,
                'name' => 'Crystal Chantal-Lear',
                'email' => 'crystal@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
            ],
            [
                'id' => 503,
                'name' => 'Robyn Banks',
                'email' => 'robyn@example.com',
                'password' => 'Password1',
                'email_verified_at' => now(),
                'roles' => ['client',],
            ],
            [
                'id' => 504,
                'name' => 'Eileen Dover',
                'email' => 'eileen@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
                'roles' => ['client',],
            ],
        ];

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, count($seedClientUsers));
        $progress->start();

        foreach ($seedClientUsers as $user) {
            $roles = $user['roles'] ?? null;
            unset($user['roles']);

            $clientUser = User::updateOrCreate(
                ['id' => $user['id']],
                $user
            );

            if (isset($roles)) {
                $clientUser->assignRole($roles);
            }
            $progress->advance();
        }

        $progress->finish();
        $output->writeln("");

    }
}
