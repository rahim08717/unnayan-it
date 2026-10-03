<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Desktop Computer', 'code' => 'CAT-DESK', 'type' => 'hardware', 'description' => 'Desktop CPU and Monitor setups'],
            ['name' => 'Laptop Computer', 'code' => 'CAT-LAP', 'type' => 'hardware', 'description' => 'Portable laptops and notebooks'],
            ['name' => 'Printer & Scanner', 'code' => 'CAT-PRN', 'type' => 'hardware', 'description' => 'Laserjet, Inkjet, and Multi-function printers'],
            ['name' => 'Router & Network Equipment', 'code' => 'CAT-NET', 'type' => 'hardware', 'description' => 'Mikrotik routers, switches, access points'],
            ['name' => 'UPS & Power Backup', 'code' => 'CAT-UPS', 'type' => 'hardware', 'description' => 'Offline and Online UPS units'],
            ['name' => 'Software License & Operating System', 'code' => 'CAT-SW', 'type' => 'software', 'description' => 'Windows OS, Antivirus, MS Office licenses'],
        ];

        foreach ($categories as $cat) {
            AssetCategory::updateOrCreate(['code' => $cat['code']], $cat);
        }
    }
}