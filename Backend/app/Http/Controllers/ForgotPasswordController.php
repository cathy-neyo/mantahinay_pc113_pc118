<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail; // For sending the reset link via email (optional)

class ForgotPasswordController extends Controller
{
    /**
     * Handle the request for sending the password reset link.
     */
  public function sendResetLink(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email address or not found.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $token = Str::random(60);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token, // DO NOT hash for now (simple token)
                    'created_at' => now(),
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Reset link sent.',
                'reset_link' => url('/auth/reset-password.php?token=' . $token . '&email=' . $request->email)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Handle the password reset process.
     */
    public function resetPassword(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        // Check if the reset token exists for the email
        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // If no record or token mismatch, return error
        if (!$record || !Hash::check($request->token, $record->token)) {
            return response()->json(['status' => false, 'message' => 'Invalid token or token expired.']);
        }

        // Find the user associated with the email
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token after the password has been successfully updated
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['status' => true, 'message' => 'Password has been reset.']);
    }
}
