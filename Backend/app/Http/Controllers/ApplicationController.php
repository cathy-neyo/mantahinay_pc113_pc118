<?php
namespace App\Http\Controllers;

use App\Imports\ApplicationsImport;
use App\Exports\ApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationStatusMail;


class ApplicationController extends Controller
{
    // Fetch all pending applications
    public function getPendingApplications()
    {
        $applications = Application::where('status', 'pending')->get();

        $data = $applications->map(function ($app) {
            return [
                'id' => $app->id,
                'name' => $app->name,
                'scholarship_title' => $app->scholarship_title,
                'date_applied' => $app->created_at->format('Y-m-d'),
                'status' => $app->status,
                'email' => $app->email,
                'phone_number' => $app->phone_number,
            ];
        });

        return response()->json($data);
    }

    // Approve application and send email
  // Approve application and send email
public function approveApplication($id)
{
    $application = Application::findOrFail($id);
    $application->status = 'approved';
    $application->save();

    Mail::to($application->email)->send(
        new ApplicationStatusMail($application->email, $application->name, $application->status)
    );

    return response()->json(['message' => 'Application approved']);
}

// Reject application and send email
public function rejectApplication($id)
{
    $application = Application::findOrFail($id);
    $application->status = 'rejected';
    $application->save();

    Mail::to($application->email)->send(
        new ApplicationStatusMail($application->email, $application->name, $application->status)
    );

    return response()->json(['message' => 'Application rejected']);
}

}
