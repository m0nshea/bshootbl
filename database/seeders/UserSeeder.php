<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Bshoot',
            'email' => 'admin@bshoot.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@bshoot.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
        ]);

        // Create additional test users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}
