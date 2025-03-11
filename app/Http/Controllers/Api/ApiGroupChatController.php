<?php

namespace App\Http\Controllers\Api;

use App\Events\GroupMessageSent;
use App\Http\Controllers\Controller;
use App\Models\GroupMessage;
use Illuminate\Http\Request;

class ApiGroupChatController extends Controller
{
    public function sendMessage(Request $request, $groupId)
    {
        $message = GroupMessage::create([
            'group_id' => $groupId,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);


        broadcast(new GroupMessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

    public function fetchMessages($groupId)
    {
        $messages = GroupMessage::where('group_id', $groupId)
            ->with('user')
            ->latest()
            ->take(50)
            ->get();

        return response()->json($messages);
    }
}
