<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Log;

Route::post('/applications/{id}/approve', [ApplicationController::class, 'approveApplication']);
Route::post('/applications/{id}/reject', [ApplicationController::class, 'rejectApplication']);


Route::get('/applications/pending', [ApplicationController::class, 'getPendingApplications']);

// web.php
Route::get('/test-mail', function () {
    \Mail::raw('This is a test message!', function ($message) {
        $message->to('anyone@example.com') // recipient doesn't matter in Mailtrap
                ->subject('Test Email from Laravel');
    });

    return 'Email sent!';
});

// Route::get('/applications/pending', function () {
//     return Application::where('status', 'pending')->get();
// });

// Route::post('/applications/{id}/approve', function ($id) {
//     $app = Application::findOrFail($id);
//     $app->status = 'approved';
//     $app->save();

//     // Simulate SMS sending
//     Log::info("SMS sent to {$app->phone_number}: Your application has been APPROVED.");

//     return response()->json(['message' => 'Approved']);
// });

// Route::post('/applications/{id}/reject', function ($id) {
//     $app = Application::findOrFail($id);
//     $app->status = 'rejected';
//     $app->save();

//     // Simulate SMS sending
//     Log::info("SMS sent to {$app->phone_number}: Your application has been REJECTED.");

//     return response()->json(['message' => 'Rejected']);
// });



Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
//forgot password

// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);


Route::middleware(['auth', 'allowedRoles:0'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin-dashboard');
    });
});
Route::middleware(['auth', 'allowedRoles:1'])->group(function () {
    Route::get('/coordinator-dashboard', function () {
        return view('coordinator-dashboard');
    });
});



Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
});


// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

//total users and scholarships sa admin dashboard
    Route::get('/total-users', [UserController::class, 'getTotalUsers']);
    Route::get('/total-scholarships', [ScholarshipController::class, 'totalScholarships']);



Route::get('/scholarships', [ScholarshipController::class, 'index']);
Route::post('/scholarships', [ScholarshipController::class, 'store']);
Route::resource('scholarships', ScholarshipController::class);
Route::get('/scholarships/{id}', [ScholarshipController::class, 'show']);
Route::put('/scholarships/{id}', [ScholarshipController::class, 'update']);
Route::delete('/scholarships/{id}', [ScholarshipController::class, 'destroy']);



Route::get('/applications/pending', [ApplicationController::class, 'pending']);
Route::get('/applications/{id}', [ApplicationController::class, 'show']);
Route::post('/applications/{id}/approve', [ApplicationController::class, 'approve']);
Route::post('/applications/{id}/reject', [ApplicationController::class, 'reject']);

Route::get('/evaluate-applications', [ApplicationController::class, 'index']);
Route::post('/evaluate-application/{id}', [ApplicationController::class, 'evaluate']);
Route::get('/applications/pending', [ApplicationController::class, 'getPendingApplications']);
Route::post('/applications/{id}/approve', [ApplicationController::class, 'approveApplication']);
Route::post('/applications/{id}/reject', [ApplicationController::class, 'rejectApplication']);
Route::get('/applications/{id}', [ApplicationController::class, 'viewApplication']);


// });




// // GET route to list all coordinators
// Route::get('/coordinators', [CoordinatorController::class, 'index']);

// // POST route to store a new coordinator
// Route::post('/coordinators', [CoordinatorController::class, 'store']);


// // evaluate application
// Route::get('/applications', [ApplicationController::class, 'index']);
// Route::post('/applications/{id}/approve', [ApplicationController::class, 'approve']);
// Route::post('/applications/{id}/reject', [ApplicationController::class, 'reject']);



// Route::resource('scholarships', ScholarshipController::class);

// Route::post('/scholarships', [ScholarshipController::class, 'store']);
// Route::get('/scholarships', [ScholarshipController::class, 'index']);

//sa dashboard controller ni
// Route::middleware('auth:sanctum')->get('/dashboard-totals', [AdminController::class, 'getDashboardTotals']);






// Route::get('/users', function (Request $request) {
//     $role = $request->query('role');
//     $users = User::where('role', $role)->get();
//     return response()->json($users);
// });

// Route::get('/coordinators', [UserController::class, 'getCoordinators']);
// Route::get('/coordinators', [CoordinatorController::class, 'index']);
// Route::post('/coordinators', [CoordinatorController::class, 'store']);
// Route::get('/coordinators/{id}', [CoordinatorController::class, 'show']);
// Route::put('/coordinators/{id}', [CoordinatorController::class, 'update']);
// Route::delete('/coordinators/{id}', [CoordinatorController::class, 'destroy']);


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



//SA USA NI KA SYSTEM 


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



// Route::post('/login', [AuthController::class, 'login']);
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



// // Route::get('/users', [AuthController::class, 'index']);



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