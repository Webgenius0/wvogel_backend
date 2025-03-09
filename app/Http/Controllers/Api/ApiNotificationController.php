<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ApiNotificationController extends Controller
{
   public function index(){
    dd('here');
//here will be show the notification for the user
try {
    // Get the authenticated user
    $user = Auth::user();
    dd($user);

    // Fetch unread notifications
    $notifications = $user->notifications;

    return response()->json([
        'status' => 'success',
        'message' => 'Notifications fetched successfully!',
        'data' => $notifications
    ], 200);
} catch (\Exception $e) {
    return response()->json([
        'status' => 'error',
        'message' => 'Failed to fetch notifications',
        'error' => $e->getMessage()
    ], 500);
}
   }
}
