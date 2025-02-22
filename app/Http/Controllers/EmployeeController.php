<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('firstname', 'like', "%$search%")
                ->orWhere('lastname', 'like', "%$search%")
                ->orWhere('age', 'like', "%$search%")
                ->orWhere('gender', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        }

        $employees = $query->get();
        return response()->json($employees, 200);
    }
}
