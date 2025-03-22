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
    public function index(){
        // Get the authenticated user
        $userId = Auth::id();
        // Get the messages for the user
        $messages = Message::where('sender_id', $userId)
        ->orWhere('receiver_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $messages
        ], 200);
    }
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

    public function getChatUsers()
{
    // Get the authenticated user ID
    $authUserId = Auth::id();

// Fetch distinct user IDs that the authenticated user has chatted with
$userIds = Message::where('sender_id', $authUserId)
    ->orWhere('receiver_id', $authUserId)
    ->selectRaw('sender_id, receiver_id')
    ->get()
    ->flatMap(function ($message) use ($authUserId) {
        return [$message->sender_id, $message->receiver_id];
    })
    ->unique()
    ->reject(fn ($id) => $id == $authUserId) // Remove the authenticated user from the list
    ->values();

// Fetch users with the latest message for each user
$users = User::whereIn('id', $userIds)
    ->with(['latestMessage' => function ($query) use ($authUserId) {
        $query->where(function ($q) use ($authUserId) {
            $q->where('sender_id', $authUserId)
              ->orWhere('receiver_id', $authUserId);
        })
        ->orderBy('created_at', 'desc') // Sort messages by creation date
        ->take(1); // Only get the latest message
    }])
    ->get();

// Debugging - You can see all messages related to the authenticated user
$messages = Message::where('sender_id', $authUserId)
    ->orWhere('receiver_id', $authUserId)
    ->get();

 // You can comment this line out once you're confident about the messages.

// Format response with last message included
$formattedUsers = $users->map(function ($user) use ($authUserId) {
    // Get the messages for the current user with the authenticated user
    $userMessages = Message::where(function ($query) use ($authUserId, $user) {
        $query->where('sender_id', $authUserId)
              ->where('receiver_id', $user->id);
    })->orWhere(function ($query) use ($authUserId, $user) {
        $query->where('sender_id', $user->id)
              ->where('receiver_id', $authUserId);
    })->latest('created_at')->take(1) // Get the latest message
      ->get();

    // Get the latest message, or null if no message exists
    $lastMessage = $userMessages->first(); // Since we took only one message

    return [
        'id' => $user->id,
        'name' => $user->name,
        'last_message' => $lastMessage ? $lastMessage->message : null,
        // 'last_message_time' => $lastMessage ? $lastMessage->created_at->toDateTimeString() : null,
    ];
});

// Send the formatted users as a response (you can return this if you're using API responses)
return response()->json($formattedUsers);

}};
