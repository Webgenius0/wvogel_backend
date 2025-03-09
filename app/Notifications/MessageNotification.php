<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;
    public $senderName;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, string $senderName)
    {
        $this->message = $message;
        $this->senderName = $senderName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->senderName, // Include sender's name
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return BroadcastMessage
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->senderName, // Use dynamic sender name
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
        ]);
    }
}
