<?php

namespace App\Events;

use App\Models\LikeNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class LikeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public LikeNotification $likeNotification;
    /**
     * Create a new event instance.
     */
    public function __construct(LikeNotification $likeNotification)
    {
        $this->likeNotification = $likeNotification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->likeNotification->userNotified()->id),
        ];
    }
    public function broadcastAs(): string
    {
        return 'notification-like';
    }
}
