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
    public function delete(User $user, User $model): bool
    {
        //
    }
}
