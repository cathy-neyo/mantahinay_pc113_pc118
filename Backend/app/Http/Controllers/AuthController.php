<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Exception; // Import for catching generic exceptions

class AuthController extends Controller
{
    public function index()
    {
        try {
            // Fetch all users
            $users = User::all();
            return response()->json(['users' => $users], 200);
        } catch (Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to fetch users: ' . $e->getMessage()], 500);
        }
    }

    
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    
        try {
            // Attempt to log in user
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                ], 200);
            }

            // Login failed
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        } catch (Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Login failed: ' . $e->getMessage()], 500);
        }
    }

    public function getUser(Request $request)
    {
        try {
            // Return the authenticated user's data
            return response()->json($request->user(), 200);
        } catch (Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to retrieve user: ' . $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/l ogin');
    }
}
