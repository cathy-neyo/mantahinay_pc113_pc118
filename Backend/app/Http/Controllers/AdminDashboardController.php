<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Scholarship;

class AdminDashboardController extends Controller
{
    public function getTotalUsers()
    {
        $total = User::whereIn('role', [1, 2])->count(); // 1 = coordinator, 2 = evaluator
        return response()->json(['status' => true, 'total_users' => $total]);
    }

    public function getTotalScholarships()
    {
        $total = Scholarship::count(); // Adjust if model/table name is different
        return response()->json(['status' => true, 'total_scholarships' => $total]);
    }
}
