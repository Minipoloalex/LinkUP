<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostPolicy
{  
    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Post $post): bool
    {
        Log::debug('User:' . $user);
        if($user === null) {
            return $post->is_private === false;
        }
    
        /*if ($user->isAdmin()) {
            return true; // Admins can view any post
        }*/

        Log::debug("PostPolicy: view: user->id: $user->id, post->id_created_by: $post->id_created_by");
        
        // Check if the user is following the creator of the post
        return $user->isFollowing($post->createdBy) || $post->is_private === false || $user->id === $post->id_created_by;
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
        // return Auth::check() && ($post->is_private === false || $user->id === $post->id_created_by);

        // not yet implemented
        return true;
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
}
