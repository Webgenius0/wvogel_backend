<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Models\User;
use App\Notifications\MessageNotification;
use Illuminate\Support\Facades\Notification;

class ApiMessageController extends Controller
{
    // Send Message
    public function sendMessage(Request $request)
{
    // Validate the request
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'required|string|max:1000',
    ]);

    // Create the message
    $message = Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
    ]);

    // Load sender's info for the response
    $message->load('sender:id,name');

    // Fetch the sender's name
    $sender = Auth::user(); // Get the currently authenticated user
    $senderName = $sender ? $sender->name : 'Unknown';

    // Send notification immediately (REAL-TIME)
    $receiver = User::find($request->receiver_id);
    if ($receiver) {
        Notification::send($receiver, new MessageNotification($message, $senderName));
    }

    // Broadcast the event
    broadcast(new MessageSent($message))->toOthers();

    return response()->json([
        'status' => 'success',
        'message' => 'Message sent successfully!',
        'data' => $message
    ], 201);
}


    // Fetch chat messages between two users
    public function getMessages($userId)
    {
        //  Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        // Fetch messages between current user & given user
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', Auth::id());
        })->latest()->get(); // Use latest() instead of orderBy()


        return response()->json([
            'status' => 'success',
            'messages' => $messages
        ]);
    }
}
