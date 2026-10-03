<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use App\Models\AssetCategory;
use App\Models\Vendor;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Branches
        $headOffice = Branch::create([
            'name' => 'Head Office',
            'code' => 'HO-01',
            'location' => 'Dhaka',
            'is_active' => true,
        ]);

        $branchMirpur = Branch::create([
            'name' => 'Mirpur Branch',
            'code' => 'BR-02',
            'location' => 'Mirpur, Dhaka',
            'is_active' => true,
        ]);

        // 2. Create Default Users
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'branch_id' => $headOffice->id,
        ]);

        User::create([
            'name' => 'Mirpur Branch Officer',
            'email' => 'mirpur@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'branch_user',
            'branch_id' => $branchMirpur->id,
        ]);

        // 3. Create Sample Categories
        AssetCategory::create(['name' => 'Laptop / Desktop', 'code' => 'COMP']);
        AssetCategory::create(['name' => 'Printer / Scanner', 'code' => 'PRNT']);
        AssetCategory::create(['name' => 'Networking (Router/Switch)', 'code' => 'NET']);
        AssetCategory::create(['name' => 'UPS / Power Supply', 'code' => 'PWR']);

        // 4. Create Sample Vendor
        Vendor::create([
            'company_name' => 'Star Tech Ltd',
            'contact_person' => 'Sales Team',
            'phone' => '01900000000',
            'email' => 'sales@startech.com.bd',
            'address' => 'Multiplan Center, Dhaka',
        ]);

        // 5. Create Sample Employee
        Employee::create([
            'name' => 'Rahim Uddin',
            'employee_id' => 'EMP-1001',
            'designation' => 'Senior Officer',
            'department' => 'Accounts',
            'phone' => '01711111111',
            'email' => 'rahim@unnayan.org',
            'branch_id' => $headOffice->id,
        ]);
    }
}