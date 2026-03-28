<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create BEBARS admin
        User::updateOrCreate(
            ['email' => 'bebarsstudio@gmail.com'],
            [
                'name' => 'BEBARS',
                'password' => Hash::make('admin1'),
                'is_admin' => true,
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Ahmed admin
        User::updateOrCreate(
            ['email' => 'ahmed@example.com'],
            [
                'name' => 'Ahmed',
                'password' => Hash::make('admin2'),
                'is_admin' => true,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create a regular user for testing
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Users created:');
        $this->command->info('   Admin (Super): bebarsstudio@gmail.com / admin1');
        $this->command->info('   Admin: ahmed@example.com / admin2');
        $this->command->info('   User: user@example.com / password');
    }
}