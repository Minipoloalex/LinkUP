<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class CommentNotification extends Model
{
    use HasFactory;
    protected $table = 'comment_notification';
    public $timestamps = false;
    protected $fillable = [
        'id_comment',
        'timestamp',
    ];
    protected $dates = [
        'timestamp',
    ];
    public function comment()
    {
        return $this->belongsTo(Post::class, 'id_comment');
    }
    public function userNotified()
    {
        return $this->comment->parent->createdBy;
    }

    public function belongingToUser(int $user_id)
    {
        return $this->userNotified()->id == $user_id;
    }

    public function whoCommented()
    {
        return $this->comment->createdBy;
    }

    public function getType()
    {
        return 'comment';
    }

    public static function getNotifications(int $user_id)
    {
        // Get comments to user's posts
        $user_comments = Post::select('id')
            ->whereIn('id_parent', function ($query) use ($user_id) {
                $query->select('id')
                    ->from('post')
                    ->where('id_created_by', $user_id)
                    ->whereNull('id_parent');
            });

        // Get comment notifications from user's comments
        $comment_nots = CommentNotification::select('*')
            ->joinSub($user_comments, 'p', function ($join) {
                $join->on('comment_notification.id_comment', '=', 'p.id');
            })->join('post', 'comment_notification.id_comment', '=', 'post.id')
            ->orderBy('timestamp', 'desc')->get();

        return $comment_nots;
    }

    public function toHtml($home = true)
    {
        return view('partials.notifications.comment', [
            'notification' => $this,
            'home' => $home,
        ])->render();
    }
}
