<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|string',
        'password' => 'required|string|min:8',
    ]);

    $validatedData['password'] = bcrypt($validatedData['password']); 
    $user = User::create($validatedData);

    return response()->json([
        'message' => 'User created successfully',
        'user' => $user,
    ], 201);
}

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:0,1',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
