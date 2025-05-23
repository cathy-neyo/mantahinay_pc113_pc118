<?php

namespace App\Http\Controllers;

use App\Imports\ApplicationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Export function
    public function exportApplications()
    {
        return Excel::download(new ApplicationExport, 'applications.xlsx');
    }

    // Import function
    public function importApplications(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        try {
            Excel::import(new ApplicationImport, $request->file('file'));
            return back()->with('success', 'Applications Imported Successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import applications. Please try again.');
        }
    }
}
