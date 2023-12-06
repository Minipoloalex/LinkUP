<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeNotification extends Model {
    use HasFactory;
    protected $table = 'like_notification';
    public $timestamps = false;
    protected $dates = [
        'timestamp',
    ];
    protected $fillable = [
        'id_post',
        'id_user',
        'timestamp',
    ];
    public function post() {
        return $this->belongsTo(Post::class, 'id_post');
    }
    public function userNotified() {
        return $this->post()->createdBy();
    }
    public function likedByUser() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function getType() {
        return 'like';
    }

    public static function getSomeNotifications(int $user_id, int $limit = 10) {
        // Get posts to user's posts
        $user_posts = Post::select('id')
            ->where('id_created_by', $user_id)
            ->whereNull('id_parent');

        // Get like notifications from user's posts
        $like_nots = LikeNotification::select('*')
            ->joinSub($user_posts, 'p', function ($join) {
                $join->on('like_notification.id_post', '=', 'p.id');
            })->join('post', 'like_notification.id_post', '=', 'post.id')
            ->orderBy('timestamp', 'desc')->limit($limit)->get();

        return $like_nots;
    }
}
