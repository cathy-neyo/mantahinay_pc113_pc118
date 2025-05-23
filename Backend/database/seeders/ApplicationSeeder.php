<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    public function run()
    {
        Application::create([
            'name' => 'Juan Dela Cruz',
            'scholarship_title' => 'Barangay Scholarship 2025',
            'date_applied' => now()->toDateString(),
            'status' => 'pending',
            'phone_number' => '09123456789'
        ]);

        Application::create([
            'name' => 'Maria Santos',
            'scholarship_title' => 'Youth Assistance Grant',
            'date_applied' => now()->toDateString(),
            'status' => 'pending',
            'phone_number' => '09519116862'
        ]);
    }
}
