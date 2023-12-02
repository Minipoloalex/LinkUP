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
        return $this->comment()->parent()->createdBy();
    }
}
