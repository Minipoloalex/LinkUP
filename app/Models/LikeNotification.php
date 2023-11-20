<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeNotification extends Model
{
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
    // public function post()
    // {
    //     return $this->belongsTo(Post::class, 'id_post');
    // }
    public function userNotified()
    {
        return $this->post()->createdBy();
    }
    public function likedByUser()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
