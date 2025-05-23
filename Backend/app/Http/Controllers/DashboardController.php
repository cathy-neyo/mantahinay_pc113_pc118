<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Scholarship;

class DashboardController extends Controller
{
    public function getTotalUsers()
    {
        $totalUsers = User::where('role', '!=', 0)->count(); // Exclude admin
        return response()->json([
            'status' => true,
            'total_users' => $totalUsers
        ]);
    }

    public function getTotalScholarships()
    {
        $totalScholarships = Scholarship::count();
        return response()->json([
            'status' => true,
            'total_scholarships' => $totalScholarships
        ]);
    }
}
