<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Messages;

class NewMessageNotification extends Notification
{
    use Queueable;

    public $message;

    public function __construct(Messages $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message_id' => $this->message->id,
            'text' => "Pesan baru dari " . $this->message->sender->nama,
            'conversation_id' => $this->message->conversation_id,
        ];
    }
}
