<?php

use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;

// Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/students', [StudentController::class, 'index']);

Route::get('/students/search', [StudentController::class, 'index']);
Route::get('/employees/search', [EmployeeController::class, 'index']);

Route::get('employees', [EmployeeController::class, 'index']);
Route::post('employees', [EmployeeController::class, 'store']);
Route::get('employees/{employee}', [EmployeeController::class, 'show']);
Route::put('employees/{employee}', [EmployeeController::class, 'update']);
Route::delete('employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('students', [StudentController::class, 'index']);
Route::post('students', [StudentController::class, 'store']);
Route::get('students/{student}', [StudentController::class, 'show']);
Route::put('students/{student}', [StudentController::class, 'update']);
Route::delete('students/{student}', [StudentController::class, 'destroy']);



Route::get('/users', [AuthController::class, 'index']);



Route::middleware(['auth:sanctum', 'role:0'])->get('/users', [AuthController::class, 'index']); //only a login user can access rhis api
Route::middleware(['auth:sanctum', 'role:1'])->get('/udashboard', [UserDashboardController::class, 'index']);
//new
Route::get('/dashboard', function () {
    return view('dashboard'); 
})->middleware('auth'); // Ensure user is logged in
Route::middleware('auth:sanctum')->get('/students', function () {
    return \App\Models\Student::all();
});
//kutob dire

Route::get('unknown', function () {
    return response()->json(['message' => 'ok']);


});