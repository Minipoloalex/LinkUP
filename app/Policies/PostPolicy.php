<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Post $post): bool
    {
        // or is admin or is follower ($user->isFollowing($post->createdBy))
        // return $post->is_private === false || $user->id === $post->id_created_by;
        return true;
    }

    /**
     * Determine whether the user can create posts.
     */
    public function createPost(?User $user): bool
    {
        return Auth::check();
    }
    /**
     * Determine whether the user can create posts.
     */
    public function createComment(User $user, Post $post): bool
    {
        // if post is in a group, need to check group
        // if post is private, need to check follower
        return Auth::check() && ($post->is_private === false || $user->id === $post->id_created_by);
    }

    /**
     * Determine whether the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->id_created_by;
    }

    /**
     * Determine whether the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->id_created_by;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        //
    }
}
