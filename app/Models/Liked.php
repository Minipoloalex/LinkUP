<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\Console\PruneFailedJobsCommand;

class Liked extends Model
{
    use HasFactory;
    protected $table = 'liked';
    public $timestamps = false;
    protected $primaryKey = ['id_user', 'id_post'];

    public $incrementing = false; // Since it's a composite primary key

    protected $fillable = [
        'id_user',
        'id_post',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
