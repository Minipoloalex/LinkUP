<?php

namespace App\Models;

use GroupNotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\Readline\Hoa\ProtocolException;

class GroupNotification extends Model
{
    use HasFactory;
    protected $table = 'group_notification';
    public $timestamps = false;
    protected $fillable = [
        'id_group',
        'id_notification',
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
        }
        else if ($this->type == GroupNotificationType::INVITATION) {
            return $this->belongsTo(User::class, 'id_user');
        }
    }
    public function otherUser()
    {
        if ($this->type == GroupNotificationType::REQUEST) {
            return $this->belongsTo(User::class, 'id_user');
        }
        else if ($this->type == GroupNotificationType::INVITATION) {
            return $this->group()->owner();
        }
    }
}
