<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin / IT Head
        User::create([
            'name' => 'IT Head Admin',
            'email' => 'admin@unnayan.org',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'phone' => '01700000001',
            'is_active' => true,
        ]);

        // 2. IT Support Officer
        User::create([
            'name' => 'IT Support Officer',
            'email' => 'support@unnayan.org',
            'password' => Hash::make('password123'),
            'role' => 'it_support',
            'phone' => '01700000002',
            'is_active' => true,
        ]);

        // 3. Branch Manager
        User::create([
            'name' => 'Branch Manager (Dhaka)',
            'email' => 'branch.dhaka@unnayan.org',
            'password' => Hash::make('password123'),
            'role' => 'branch_manager',
            'phone' => '01700000003',
            'is_active' => true,
        ]);
    }
}