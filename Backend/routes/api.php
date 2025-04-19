<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoordinatorController;
use Illuminate\Http\Request;





Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::get('/coordinators', [CoordinatorController::class, 'index']);
Route::post('/coordinators', [CoordinatorController::class, 'store']);
Route::get('/coordinators/{id}', [CoordinatorController::class, 'show']);
Route::put('/coordinators/{id}', [CoordinatorController::class, 'update']);
Route::delete('/coordinators/{id}', [CoordinatorController::class, 'destroy']);


// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);
// Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


// Route::get('/redirect-dashboard', function () {
//     $role = Auth::user()->role;

//     if ($role == 'admin') {
//         return redirect('/admin/dashboard');
//     } elseif ($role == 'scholarship_coordinator') {
//         return redirect('/coordinator/dashboard');
//     } elseif ($role == 'scholarship_evaluator') {
//         return redirect('/evaluator/dashboard');
//     } else {
//         abort(403); // unauthorized
//     }
// })->middleware(['auth']);


// // Admin Routes
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return 'Admin Dashboard';
//     });
// });
// // Coordinator Routes
// Route::middleware(['auth', 'role:coordinator'])->group(function () {
//     Route::get('/coordinator/dashboard', function () {
//         return 'Scholarship Coordinator Dashboard';
//     });
// });
// // Evaluator Routes
// Route::middleware(['auth', 'role:evaluator'])->group(function () {
//     Route::get('/evaluator/dashboard', function () {
//         return 'Scholarship Evaluator Dashboard';
//     });
// });






// Route::middleware('auth:sanctum')->group(function () {
//    Route::apiResource('users', UserController::class);
// });
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/users', [UserController::class, 'index']);
   
// });

// Route::post('/users', [UserController::class, 'store']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'destroy']);



// // Route::post('/login', [AuthController::class, 'login']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::get('/employees', [EmployeeController::class, 'index']);
// Route::get('/students', [StudentController::class, 'index']);

// Route::get('/students/search', [StudentController::class, 'index']);
// Route::get('/employees/search', [EmployeeController::class, 'index']);


// Route::get('employees', [EmployeeController::class, 'index']);
// Route::post('employees', [EmployeeController::class, 'store']);
// Route::get('employees/{id}', [EmployeeController::class, 'show']);
// Route::put('employees/{id}', [EmployeeController::class, 'update']);
// Route::delete('employees/{employee}', [EmployeeController::class, 'destroy']);

// Route::get('students', [StudentController::class, 'index']);
// Route::post('students', [StudentController::class, 'store']);
// Route::get('students/{student}', [StudentController::class, 'show']);
// Route::put('students/{student}', [StudentController::class, 'update']);
// Route::delete('students/{student}', [StudentController::class, 'destroy']);



// Route::get('/users', [AuthController::class, 'index']);



// Route::middleware(['auth:sanctum', 'role:0'])->get('/users', [AuthController::class, 'index']); //only a login user can access rhis api
// Route::middleware(['auth:sanctum', 'role:1'])->get('/udashboard', [UserDashboardController::class, 'index']);
// //new
// Route::get('/dashboard', function () {
//     return view('dashboard'); 
// })->middleware('auth'); // Ensure user is logged in
// Route::middleware('auth:sanctum')->get('/students', function () {
//     return \App\Models\Student::all();
// });
// //kutob dire

// Route::get('unknown', function () {
//     return response()->json(['message' => 'ok']);


// });