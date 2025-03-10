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
   
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'contact_number' => 'required|string|max:20',
            'course' => 'required|string|max:255',
        ]);

        $student = Student::create($validatedData);

        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student,
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(Request $request,$id){
        $student = Student::find($id);
        if (is_null($student)) {
            return response()->json(['message' => 'Student Not Found'], 404);
        }

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,'.$id,
            'contact_number' => 'required|string|max:20',
            'course' => 'required|string|max:255'
             
        ]);
        
        $student->update($validatedData);
        return response()->json([
            'message' => 'Student Updated Successfully',
            'student' => $student
        ]);
        
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return response()->json(['message' => 'Student Not Found'], 404);
        }

        $student->delete();
        return response()->json(['message' => 'Student deleted successfully'], 200);
    }
    
}