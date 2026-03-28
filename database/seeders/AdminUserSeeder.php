<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if users table is empty
        if (User::count() == 0) {
            // Create BEBARS admin (Super Admin)
            User::create([
                'name' => 'BEBARS',
                'email' => 'bebarsstudio@gmail.com',
                'password' => Hash::make('admin1'),
                'is_admin' => true,
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]);

            // Create Ahmed admin
            User::create([
                'name' => 'Ahmed',
                'email' => 'ahmed@example.com',
                'password' => Hash::make('admin2'),
                'is_admin' => true,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin users created successfully!');
            $this->command->info('   BEBARS: bebarsstudio@gmail.com / admin1');
            $this->command->info('   Ahmed: ahmed@example.com / admin2');
        } else {
            $this->command->info('⚠️ Users already exist, skipping seed.');
        }
    }
}