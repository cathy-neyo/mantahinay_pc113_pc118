<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Scholarship;

class AdminController extends Controller
{
    public function getDashboardTotals()
    {
        try {
            $coordinators = User::where('role', 1)->count();
            $evaluators = User::where('role', 2)->count();
            $scholarships = Scholarship::count();

            return response()->json([
                'coordinators' => $coordinators,
                'evaluators' => $evaluators,
                'scholarships' => $scholarships
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
