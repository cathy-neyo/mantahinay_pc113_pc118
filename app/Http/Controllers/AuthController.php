<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index(){
        return User::all();
    }

    public function login(Request $request)
    {
      if(Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,   
        ])){
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;      
        return response()->json([
          'message' => 'Login successful',
          'token' => $token,        
        ]);
    }
    return response()->json([
      'message' => 'Invalid email or password',
    ], 401);
}
}