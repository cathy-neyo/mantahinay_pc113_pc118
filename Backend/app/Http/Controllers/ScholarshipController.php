<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Storage;

class ScholarshipController extends Controller
{
    // Display all scholarships
   public function index()
{
    $scholarships = Scholarship::all();
    foreach ($scholarships as $scholarship) {
        // Correcting image URL generation
        $scholarship->image = $scholarship->image
            ? asset('storage/' . $scholarship->image)  // Removed extra 'scholarships/'
            : null;
    }
    return response()->json($scholarships);
}


    // Store a new scholarship
  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'amount' => 'required|numeric',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'requirements' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('scholarships', 'public');
    }

    $scholarship = Scholarship::create([
        'title' => $request->title,
        'description' => $request->description,
        'amount' => $request->amount,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'requirements' => $request->requirements,
        'image' => $imagePath,
    ]);

    return response()->json($scholarship);
}


    // Update an existing scholarship
    public function update(Request $request, $id)
{
    $scholarship = Scholarship::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'amount' => 'required|numeric',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'requirements' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        if ($scholarship->image && Storage::disk('public')->exists($scholarship->image)) {
            Storage::disk('public')->delete($scholarship->image);
        }

        $imagePath = $request->file('image')->store('scholarships', 'public');
        $scholarship->image = $imagePath;
    }

    $scholarship->title = $request->title;
    $scholarship->description = $request->description;
    $scholarship->amount = $request->amount;
    $scholarship->start_date = $request->start_date;
    $scholarship->end_date = $request->end_date;
    $scholarship->requirements = $request->requirements;
    $scholarship->save();

    return response()->json($scholarship);
}

    // Show details of a single scholarship
    public function show($id)
{
    $scholarship = Scholarship::findOrFail($id);

    // Correctly generating the URL for the image
    $scholarship->image = $scholarship->image
        ? asset('storage/' . $scholarship->image)  // Removed extra 'scholarships/'
        : null;

    return response()->json($scholarship);
}


    // Delete a scholarship
    public function destroy($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        if ($scholarship->image) {
            // Delete image from storage
            Storage::disk('public')->delete('scholarships/' . $scholarship->image);
        }
        $scholarship->delete();

        return response()->json(['message' => 'Scholarship deleted successfully.']);
    }

    // Get the total number of scholarships
    public function totalScholarships()
    {
        $count = Scholarship::count();

        return response()->json([
            'status' => true,
            'total_scholarships' => $count,
        ]);
    }
}
