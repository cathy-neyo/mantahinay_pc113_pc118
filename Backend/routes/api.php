<?php

use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\UserController;


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});




// Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/students', [StudentController::class, 'index']);

Route::get('/students/search', [StudentController::class, 'index']);
Route::get('/employees/search', [EmployeeController::class, 'index']);


Route::get('employees', [EmployeeController::class, 'index']);
Route::post('employees', [EmployeeController::class, 'store']);
Route::get('employees/{id}', [EmployeeController::class, 'show']);
Route::put('employees/{id}', [EmployeeController::class, 'update']);
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