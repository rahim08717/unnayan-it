<?php

namespace Database\Seeders;

use App\Models\WorkCategory;
use Illuminate\Database\Seeder;

class WorkCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Hardware Support',
            'Software Support',
            'Network Support',
            'Printer Support',
            'CCTV Support',
            'Server Support',
            'Website Management',
            'Database Management',
            'IT Asset Management',
            'System Administration',
            'User Support',
            'Installation',
            'Configuration',
            'Maintenance',
            'Troubleshooting',
            'Training',
            'Meeting',
            'Documentation',
            'Reporting',
            'Other',
        ];

        foreach ($categories as $cat) {
            WorkCategory::firstOrCreate(
                ['name' => $cat],
                ['code' => strtoupper(substr(str_replace(' ', '', $cat), 0, 4)), 'is_active' => true]
            );
        }
    }
}