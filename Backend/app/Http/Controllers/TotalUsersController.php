<?php

namespace App\Http\Controllers;

use App\Models\User; // assuming users are stored in the User model

class TotalUsersController extends Controller
{
    public function getTotalUsers()
    {
        $totalUsers = User::count(); // Count total users in your system
        return response()->json([
            'status' => true,
            'total_users' => $totalUsers
        ]);
    }
}
