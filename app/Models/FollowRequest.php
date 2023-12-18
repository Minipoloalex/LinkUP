<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowRequest extends Model
{
    use HasFactory;
    protected $table = 'follow_request';
    public $timestamps = false;
    protected $fillable = [
        'id_user_from',
        'id_user_to',
        'timestamp',
    ];
    protected $dates = [
        'timestamp',
    ];
    public function userNotified()
    {
        return $this->belongsTo(User::class, 'id_user_to');
    }
    public function userRequesting()
    {
        return $this->belongsTo(User::class, 'id_user_from');
    }

    public function getType()
    {
        return 'follow-request';
    }

    public static function getNotifications(int $user_id)
    {
        $follow_requests = FollowRequest::select('*')
            ->where('id_user_to', $user_id)
            ->orderBy('timestamp', 'desc')->get();

        return $follow_requests;
    }

    public function toHtml($home = true)
    {
        return view('partials.notifications.follow-request', [
            'notification' => $this,
            'home' => $home,
        ])->render();
    }
}
