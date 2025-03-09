<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification
{
    use Queueable;

    public $message;
    public $senderName;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $senderName)
    {
        $this->message = $message;
        $this->senderName = $senderName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Store notification data in database
     */
    public function toDatabase($notifiable)
    {
        return [
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->senderName,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
        ];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->senderName,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
        ];
    }

    /**
     * Broadcast the notification.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->senderName,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
        ]);
    }
}
