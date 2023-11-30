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

    public function deleteMember(User $user, Group $group): bool
    {
        if ($group->id_owner != $user->id) {
            return false;
        }

        $group->load('members');
        return $group->members->contains($user) && $user !== null;
    }
}
