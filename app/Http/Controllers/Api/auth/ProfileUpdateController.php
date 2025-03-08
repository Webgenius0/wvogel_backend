<?php

namespace App\Http\Controllers\Api\auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileUpdateController extends Controller
{
    public function index(){
  try {
    $user= Auth::guard('api')->user();
    if (!$user) {
      return ApiResponse::error(404, 'User not found');
    }
    return ApiResponse::success(true, 200, 'User fatched profile', $user);
} catch (\Exception $e) {
    return ApiResponse::error('Failed to fatch profile', $e->getMessage());
}
}


public function updateprofile(Request $request, $id)
{
    // Get the authenticated user
    $user = Auth::guard('api')->user();

    // Check if the user is authorized
    if (!$user || $user->id != $id) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'sometimes|string|max:150',
        'phone'=>'sometimes|string|unique:users,phone,'.$id,
        'email' => 'sometimes|email|unique:users,email,' . $id,
        'password' => 'sometimes|string|min:6',
        'address' => 'sometimes|string|nullable',
        'date_of_birth' => 'sometimes|string|nullable',
        'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
        'google_id' => 'sometimes|string|unique:users,google_id,' . $id . '|nullable',
        'apple_id' => 'sometimes|string|unique:users,apple_id,' . $id . '|nullable',
        'status' => 'sometimes|in:active,inactive',
    ]);

    // dd($request->all());

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json([
            'error' => 'Validation failed',
            'details' => $validator->errors()
        ], 422);
    }

    try {
        // Update fields only if provided
        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('phone')) $user->phone = $request->phone;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('password')) $user->password = Hash::make($request->password);
        if ($request->has('address')) $user->address = $request->address;
        if ($request->has('date_of_birth')) $user->date_of_birth = $request->date_of_birth;
        if ($request->has('google_id')) $user->google_id = $request->google_id;
        if ($request->has('apple_id')) $user->apple_id = $request->apple_id;
        if ($request->has('status')) $user->status = $request->status;

        // Handle Image Upload Properly (Avatar)
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = 'storage/' . $avatarPath;
        }

        //update the user profile
        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
    }
}

}

