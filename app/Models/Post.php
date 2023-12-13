<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ImageController;

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
    /*
     * Returns true if the post is liked by the current authenticated user, false if not.
     * Handles the case where the user is not authenticated.
     */
    public function likedByUser(): bool
    {
        if (!Auth::check())
            return false;
        return $this->likes->where('id_user', Auth::user()->id)->isNotEmpty();
    }
    public function media(): ?string
    {
        $imageController = new ImageController('posts');
        $fileName = $imageController->getFileNameWithExtension(str($this->id));
        if ($imageController->existsFile($fileName)) {
            return "/post/$this->id/image";
        }
        return null;
    }
    public function isCreatedByCurrentUser()
    {
        // Check if the current authenticated user is the creator of the post
        return Auth::check() && $this->id_created_by === Auth::user()->id;
    }
    /**
     * Returns a query builder with the posts that were searched by the given string (Full-text search).
     */
    public static function search($postsToSearch, string $search)
    {
        return $postsToSearch->whereRaw("tsvectors @@ plainto_tsquery('portuguese', ?)", [$search])
            ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('portuguese', ?)) DESC", [$search]);
    }
    // public function group()
    // {
    //     return $this->belongsTo(Group::class, 'id_group');
    // }
}
