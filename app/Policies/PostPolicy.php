<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Models\GroupMember;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public static function view(?User $user, Post $post): bool
    {
        if ($user === null) {
            return $post->is_private === false;
        }

        /*if ($user->isAdmin()) {
            return true; // Admins can view any post
        }*/

        // Check if the user is following the creator of the post
        return $post->is_private === false || $user->id === $post->id_created_by || $user->isFollowing($post->createdBy);
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
        if ($post->id_group !== null) {
            return GroupMember::isMember($user, $post->id_group);
        }
        return $post->is_private == false || $user->id === $post->id_created_by || $user->isFollowing($post->createdBy);
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
