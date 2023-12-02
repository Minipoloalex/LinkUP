<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class PostLike
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Post $post;
    public int $userId;
    public string $message;
    /**
     * Create a new event instance.
     */
    public function __construct(Post $post, int $userId, string $message)
    {
        $this->post = $post;
        $this->userId = $userId;
        $this->message = "User $userId liked your post $post->id";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->post->id_created_by),
        ];
    }
    public function broadcastAs(): string
    {
        return 'notification-postlike';
    }
}
