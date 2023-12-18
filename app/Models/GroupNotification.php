<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\Readline\Hoa\ProtocolException;

enum GroupNotificationType: string
{
    case REQUEST = 'Request';
    case INVITATION = 'Invitation';
}

class GroupNotification extends Model
{
    use HasFactory;
    protected $table = 'group_notification';
    public $timestamps = false;
    protected $fillable = [
        'id_group',
        'id_notification',
        'seen',
    ];
    protected $dates = [
        'timestamp',
    ];
    protected $casts = [
        'type' => GroupNotificationType::class,
    ];
    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group');
    }
    public function userNotified()
    {
        if ($this->type == GroupNotificationType::REQUEST) {
            return $this->group()->owner();
        } else if ($this->type == GroupNotificationType::INVITATION) {
            return $this->belongsTo(User::class, 'id_user');
        }
    }
    public function otherUser()
    {
        if ($this->type == GroupNotificationType::REQUEST) {
            return $this->belongsTo(User::class, 'id_user');
        } else if ($this->type == GroupNotificationType::INVITATION) {
            return $this->group()->owner();
        }
    }

    public function getType()
    {
        return 'group';
    }

    public static function getNotifications(int $user_id)
    {
        $group_requests = GroupNotification::select('*')
            ->join('groups', 'group_notification.id_group', '=', 'groups.id')
            ->where('groups.id_owner', $user_id)
            ->where('group_notification.type', GroupNotificationType::REQUEST)
            ->orderBy('timestamp', 'desc')->get();

        $group_invitations = GroupNotification::select('*')
            ->join('groups', 'group_notification.id_group', '=', 'groups.id')
            ->where('group_notification.id_user', $user_id)
            ->where('group_notification.type', GroupNotificationType::INVITATION)
            ->orderBy('timestamp', 'desc')->get();

        $group_notifications = $group_requests->merge($group_invitations);
        return $group_notifications;
    }

    public function toHtml($home = true)
    {
        return view('partials.notifications.group', [
            'notification' => $this,
            'home' => $home,
        ])->render();
    }
}
