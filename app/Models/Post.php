<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'post';
    protected $fillable = [
        'content',
        'is_private'
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'id_created_by');
    }
    public function comments()
    {
        return $this->hasMany(Post::class, 'id_parent')->orderBy('created_at', 'desc');
    }
    public function parent()
    {
        return $this->belongsTo(Post::class, 'id_parent');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'liked', 'id_post', 'id_user');
    }
    // public function group()
    // {
    //     return $this->belongsTo(Group::class, 'id_group');
    // }
}
