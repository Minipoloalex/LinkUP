<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use App\Models\GroupMember;

class GroupPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(?User $user, Group $group): bool
    {
        return true;
        // $group->load('members');

        // if ($group->members->contains($user) && $user !== null) {
        //     return true;
        // }

        // return false;
    }
}
