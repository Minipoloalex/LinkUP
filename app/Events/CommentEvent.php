<?php

namespace App\Events;

use App\Models\CommentNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CommentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public CommentNotification $commentNot;
    /**
     * Create a new event instance.
     */
    public function __construct(CommentNotification $commentNotification)

    {
        Log::debug("EXECUTION INSIDE CONSTRUCTOR OF COMMENT EVENT");
        $this->commentNot = $commentNotification;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('private-user.' . $this->commentNot->userNotified->id),
        ];
    }
    public function broadcastAs(): string
    {
        return 'notification-comment';
    }
}
