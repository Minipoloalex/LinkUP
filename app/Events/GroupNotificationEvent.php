<?php

namespace App\Events;

use App\Models\GroupNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use Illuminate\Support\Facades\Log;

class GroupNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public GroupNotification $groupNotification;
    public User $userThatSent;
    public string $groupName;
    /**
     * Create a new event instance.
     */
    public function __construct(GroupNotification $groupNotification)
    {
        $this->groupNotification = $groupNotification;
        $this->groupName = $this->groupNotification->group->name;
        $this->userThatSent = Auth::user();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->groupNotification->userNotified->id),
        ];
    }
    public function broadcastAs(): string
    {
        return 'notification-group';
    }
}
