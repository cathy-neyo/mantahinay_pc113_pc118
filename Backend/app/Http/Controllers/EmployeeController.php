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
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'phone' => 'required|string|max:20',
        ]);

        $employee = Employee::create($validatedData);
        return response()->json([
            'message' => 'Employee created successfully',
            'employee' => $employee,
        ], 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee);
    }
    
    public function update(Request $request,$id){
        $employee = Employee::find($id);
        if (is_null($employee)) {
            return response()->json(['message' => 'Employee Not Found'], 404);
        }

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,'.$id,
            'phone' => 'required|string|max:20',  
        ]);
        
        $employee->update($validatedData);
        return response()->json([
            'message' => 'Employee Updated Successfully',
            'employee' => $employee
        ]);
        
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (is_null($employee)) {
            return response()->json(['message' => 'Employee Not Found'], 404);
        }

        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }
}
