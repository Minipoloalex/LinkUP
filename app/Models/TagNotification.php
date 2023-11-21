<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagNotification extends Model
{
    use HasFactory;
    protected $table = 'tag_notification';
    public $timestamps = false;
    protected $dates = [
        'timestamp',
    ];
    public function userNotified()  // user that was tagged in the post
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    // public function post()
    // {
    //     return $this->belongsTo(Post::class, 'id_post');
    // }
}
