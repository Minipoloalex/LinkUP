<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'post';
    protected $fillable = [
        'content',
        'is_private',
        'id_parent',
        'id_created_by',
        'media',
        'id_group'
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'id_created_by');
    }
    public function comments()
    {
        return $this->hasMany(Post::class, 'id_parent')->orderBy('created_at', 'asc');
    }
    public function parent()
    {
        return $this->belongsTo(Post::class, 'id_parent');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'liked', 'id_post', 'id_user');
    }
    public function media()
    {
        if ($this->media == null)
            return null;
        return "/post/$this->id/image";
    }
    public function isCreatedByCurrentUser()
    {
        // Check if the current authenticated user is the creator of the post
        return Auth::check() && $this->id_created_by === Auth::user()->id;
    }
    public static function search(string $search)
    {
        $posts = Post::whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$search])
        ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$search])
        ->get();

        return $posts;
    }
    // public function group()
    // {
    //     return $this->belongsTo(Group::class, 'id_group');
    // }
}
