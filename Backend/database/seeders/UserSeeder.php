<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


public function run()
{
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Coordinator User',
        'email' => 'coordinator@example.com',
        'password' => Hash::make('password'),
        'role' => 'coordinator',
    ]);

    User::create([
        'name' => 'Evaluator User',
        'email' => 'evaluator@example.com',
        'password' => Hash::make('password'),
        'role' => 'evaluator',
    ]);
}

}
