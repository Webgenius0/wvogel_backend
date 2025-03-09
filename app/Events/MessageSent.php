<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use App\Notifications\MessageNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;
    public string $senderName;

    public function __construct(Message $message)
    {
        $this->message = $message;

        // Fetch the sender's name
        $sender = User::find($message->sender_id);
        $this->senderName = $sender ? $sender->name : 'Unknown';

        // Send notification to the receiver
        $receiver = User::find($message->receiver_id);
        if ($receiver) {
            $receiver->notify(new MessageNotification($message, $this->senderName));
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("chat.{$this->message->receiver_id}"),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->senderName, // Include sender's name
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
        ];
    }
}
