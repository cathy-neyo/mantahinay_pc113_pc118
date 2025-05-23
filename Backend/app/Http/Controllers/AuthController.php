<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 1 // Default role (e.g., Evaluator or Student)
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Registration successful',
        'user' => $user
    ]);
}



public function login(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user,
        'redirect_url' => $user->role == 0 ? 'admin-dashboard.php' :
                         ($user->role == 1 ? 'coordinator-dashboard.php' : 'evaluator-dashboard.php')
    ]);
}

  // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}




// class AuthController extends Controller
// {
//     public function index()
//     {
//         try {
//             return response()->json(User::all(), 200);
//         } catch (Exception $e) {
//             return response()->json([
//                 'error' => 'Failed to fetch users',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }

//     public function login(Request $request)
//     {
//         try {
//             if (Auth::attempt([
//                 'email' => $request->email,
//                 'password' => $request->password,
//             ])) {
//                 $user = Auth::user();
//                 $token = $user->createToken('auth_token')->plainTextToken;
//                 return response()->json([
//                     'user' => $user,
//                     'role' => $user->role,
//                     'message' => 'Login successful',
//                     'token' => $token,
//                 ], 200);
//             }

//             return response()->json([
//                 'message' => 'Invalid email or password',
//             ], 401);
//         } catch (Exception $e) {
//             return response()->json([
//                 'error' => 'Login failed',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }
// }