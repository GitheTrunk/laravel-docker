<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AudienceUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'veasna', 'email' => 'veasna@test.com', 'password' => 'password123'],
            ['name' => 'samnang', 'email' => 'samnang@test.com', 'password' => 'password123'],
            ['name' => 'ratana', 'email' => 'ratana@test.com', 'password' => 'password123'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                ]
            );
        }

        $this->command->info('Audience users created successfully!');
    }
}
