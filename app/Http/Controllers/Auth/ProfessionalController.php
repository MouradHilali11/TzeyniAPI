<?php

namespace App\Http\Controllers\Auth;

use App\Mail\SendCodeMail;
use App\Models\Professional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Professionals\LoginProfesLogin;
use App\Http\Requests\Professionals\RegisterProfesRequest;

class ProfessionalController extends Controller
{
    // Function for sign up
    public function register(RegisterProfesRequest $request)
    {
        try {
            // Create a new professional account
            $professional = new Professional();
            $professional->full_name = $request->full_name;
            $professional->gender = $request->gender;
            $professional->email = $request->email;
            $professional->phone = $request->phone;
            $professional->city = $request->city;
            $professional->address = $request->address;
            $professional->password = Hash::make($request->password);
            $professional->code = rand(100000, 999999); // Verification code
            $professional->save();

            // Create token
            $token = $professional->createToken('professional-token')->plainTextToken;

            // Log data before sending email
            \Log::info('Preparing to send email.', [
                'email' => $professional->email,
                'full_name' => $professional->full_name,
                'code' => $professional->code
            ]);

            // Try to send verification email
            Mail::to($professional->email)->send(new SendCodeMail($professional->full_name, $professional->code));

            // Return successful response
            return response()->json([
                'status' => true,
                'message' => 'Verify Your Email Address',
                'professional' => $professional,
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            // Log the exact error message
            \Log::error('Registration failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function for sign in
    public function login(LoginProfesLogin $request)
    {
        // Check if professional exists by email
        $professional = Professional::where('email', $request->email)->first();

        // Check if the email is verified
        if (!$professional->email_verified_at) {
            return response()->json(['message' => 'Please verify your email before logging in'], 403);
        }

        if (!$professional || !Hash::check($request->password, $professional->password)) {
            return response()->json(['message' => 'Incorrect Email or Password'], 401);
        }

        // Create token upon successful login
        $token = $professional->createToken('professional-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'professional' => $professional,
            'token' => $token
        ], 200);
    }


    // Function for log out
    public function logout(Request $request)
    {
        // Revoke token
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    // Function for verifying email
    public function verifyEmail(Request $request)
    {
        // Validate that the code is provided
        $request->validate([
            'email' => 'required|email|exists:professionals,email',
            'code' => 'required|numeric'
        ]);

        // Find the professional by email
        $professional = Professional::where('email', $request->email)->first();

        // Check if the code matches
        if ($professional->code == $request->code) {
            // Set email_verified_at
            $professional->email_verified_at = now();
            $professional->save();

            return response()->json([
                'status' => true,
                'message' => 'Email successfully verified!'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid verification code'
        ], 400);
    }
}
