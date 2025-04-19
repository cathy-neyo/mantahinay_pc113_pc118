<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // REGISTER USER
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:0,1,2', // 0 = Admin, 1 = Coordinator, 2 = Evaluator
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'token'   => $token,
            'user'    => $user
        ]);
    }

    // LOGIN USER
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $user
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