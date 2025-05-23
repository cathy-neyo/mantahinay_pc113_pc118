<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Fetch all users
    public function index()
    {
        $users = User::all(); // Get all users
        return response()->json($users);
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'required|in:0,1,2',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return response()->json($user, 201);
}

    // Fetch a single user by ID
    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    // Update a user by ID
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validate the incoming data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|integer',
        ]);

        // Check if the password needs to be updated
        $password = $request->password ? Hash::make($request->password) : $user->password;

        // Update the user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $password,
        ]);

        return response()->json(['message' => 'User updated successfully']);
    }

    // Delete a user by ID
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
    public function getTotalUsers()
    {
        $total = User::count();

        return response()->json([
            'status' => true,
            'total_users' => $total
        ]);
    }
}
