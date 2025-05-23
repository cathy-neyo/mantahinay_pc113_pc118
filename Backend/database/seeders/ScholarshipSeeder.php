<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scholarship;
use Illuminate\Support\Carbon;

class ScholarshipSeeder extends Seeder
{
    public function run(): void
    {
        $scholarships = [
            [
                'title' => 'STEM Excellence Grant',
                'description' => 'Scholarship for outstanding students in STEM fields.',
                'amount' => '20000',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(20),
                'requirements' => 'Minimum GPA of 90, recommendation letter from science teacher.',
            ],
            [
                'title' => 'Art & Culture Fund',
                'description' => 'Support for students in fine arts and humanities.',
                'amount' => '15000',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(25),
                'requirements' => 'Portfolio, essay about goals, and community involvement.',
            ]
        ];

        foreach ($scholarships as $scholarship) {
            Scholarship::create($scholarship);
        }
    }
}
