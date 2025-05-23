<?php

namespace App\Http\Controllers;

use App\Models\Scholarship; // assuming you have a Scholarship model

class TotalScholarshipsController extends Controller
{
    public function getTotalScholarships()
    {
        $totalScholarships = Scholarship::count(); // Count total scholarships in your system
        return response()->json([
            'status' => true,
            'total_scholarships' => $totalScholarships
        ]);
    }
}
