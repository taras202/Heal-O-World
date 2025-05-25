<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatId;
    public $message;
    public $senderId;

    public function __construct($chatId, $message, $senderId)
    {
        $this->chatId = $chatId;
        $this->message = $message;
        $this->senderId = $senderId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->chatId);
    }
}
