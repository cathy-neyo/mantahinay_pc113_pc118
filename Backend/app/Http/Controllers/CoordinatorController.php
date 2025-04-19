<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoordinatorController extends Controller
{
    public function index()
    {
        return response()->json(Coordinator::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:coordinators,email',
            'barangay' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $coordinator = Coordinator::create([
            'name' => $request->name,
            'email' => $request->email,
            'barangay' => $request->barangay,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Coordinator created successfully!',
            'data' => $coordinator
        ], 201);
    }

    public function show($id)
    {
        $coordinator = Coordinator::find($id);
        if (!$coordinator) {
            return response()->json(['message' => 'Coordinator not found'], 404);
        }
        return response()->json($coordinator);
    }

    public function update(Request $request, $id)
    {
        $coordinator = Coordinator::find($id);
        if (!$coordinator) {
            return response()->json(['message' => 'Coordinator not found'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:coordinators,email,' . $id,
            'barangay' => 'required|string',
        ]);

        $coordinator->update($request->only(['name', 'email', 'barangay']));

        return response()->json([
            'message' => 'Coordinator updated successfully!',
            'data' => $coordinator
        ]);
    }

    public function destroy($id)
    {
        $coordinator = Coordinator::find($id);
        if (!$coordinator) {
            return response()->json(['message' => 'Coordinator not found'], 404);
        }

        $coordinator->delete();

        return response()->json(['message' => 'Coordinator deleted successfully']);
    }
}
