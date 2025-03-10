<?php

namespace Database\Seeders;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvenets;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Employee::factory()->count(10)->create(); // Ensure EmployeeFactory is defined.
    }
}