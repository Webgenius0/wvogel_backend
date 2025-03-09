<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ApiNotificationController extends Controller
{
   public function index(){

//here will be show the notification for the user
try {
    // Get the authenticated user
    $user = Auth::user();

    // Fetch unread notifications
    $notifications = $user->notifications;

    // Map the notifications to the desired format
    $formattedNotifications = $notifications->map(function ($notification) {
        return [
            'message' => $notification->data['message'],
            'sender_name' => $notification->data['sender_name'],
            'id' => $notification->id,
        ];
    });

    return response()->json([
        'status' => 'success',
        'message' => 'Notifications fetched successfully!',
        'data' => $formattedNotifications
    ], 200);
} catch (\Exception $e) {
    return response()->json([
        'status' => 'error',
        'message' => 'Failed to fetch notifications',
        'error' => $e->getMessage()
    ], 500);
}

   }
   public function read($id)
{
    try {
        // Get the authenticated user
        $user = Auth::user();

        // Find the notification and mark it as read
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Format the notification response
        $formattedNotification = [
            'message' => $notification->data['message'],
            'sender_name' => $notification->data['sender_name'],
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read successfully!',
            'data' => $formattedNotification
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to mark notification as read',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
