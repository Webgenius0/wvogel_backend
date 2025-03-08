<?php

namespace App\Http\Controllers\Api\auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validate the login credentials
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Retrieve credentials
            $credentials = $request->only('email', 'password');
            Log::info('Login attempt with credentials:', $credentials);

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            // Check if user exists and password is correct
            if (!$user || !Hash::check($request->password, $user->password)) {
                Log::error('Invalid credentials for email: ' . $request->email);
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
// dd($user);
            // Generate JWT token
            $token = JWTAuth::fromUser($user);

            Log::info('User logged in successfully. Generated token:', ['token' => $token]);
            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'code' => 200,
                'token_type' => 'bearer',
                // 'data' => $user,
                'token' => $token,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $firstError = collect($e->errors())->flatten()->first();
            Log::error('Validation error during login: ' . $firstError);
            return response()->json([
                'status' => 422,
                // 'message' => 'Validation Failed',
                'message' => $firstError
            ], 422);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Handle JWT exceptions
            Log::error('JWT error during login: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Could not generate token',
                'error' => $e->getMessage()
            ], 500);

        } catch (\Exception $e) {
            // Handle other unexpected errors
            Log::error('Unexpected error during login: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while attempting to log in',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully',
                'code' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while attempting to log out',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
