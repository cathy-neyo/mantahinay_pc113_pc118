<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
       
        $query = Student::query();
        if ($request->has('search')) {
          $search = $request->input('search');
          $query->where('firstname', 'like', "%$search%")
            ->orWhere('lastname', 'like', "%$search%")
            ->orWhere('age', 'like', "%$search%")
            ->orWhere('gender', 'like', "%$search%")
            ->orWhere('address', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('course', 'like', "%$search%")
            ->orWhere('contact_number', 'like', "%$search%");

        }
        $students = $query->get();
        return response()->json($students, 200);
    }
}