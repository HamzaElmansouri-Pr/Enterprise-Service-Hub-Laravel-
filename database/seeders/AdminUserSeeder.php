<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'hamza.elmansouri.100@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        
        // Create additional admin users if needed
        User::create([
            'name' => 'Content Manager',
            'email' => 'content@test.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        
        $this->command->info('Admin users created successfully!');
        $this->command->info('Email: hamza.elmansouri.100@gmail.com');
        $this->command->info('Password: 123456');
    }
}