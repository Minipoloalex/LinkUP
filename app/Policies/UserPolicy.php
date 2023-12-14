<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user): Response
    {
        if (!Auth::check()) {
            return Response::deny('You are not logged in', 401);
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        if (!Auth::check()) {
            return Response::deny('You are not logged in', 401);
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewPosts(?User $user, User $toView): bool
    {
        return $toView->is_private === false || ($user !== null && ($toView->id === $user->id || $user->isFollowing($toView)));
    }
}
