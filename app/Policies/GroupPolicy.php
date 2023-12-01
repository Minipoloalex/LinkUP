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

    public function deleteMember(User $user, Group $group, string $id_member): bool
    {
        /* Leave group <=> remove himself from group */
        if ($user->id == $id_member) {
            return true;
        }

        /* Otherwise only owner can delete members */
        if ($group->id_owner != $user->id) {
            return false;
        }

        /* Owner cannot delete himself */
        if ($group->id_owner == $id_member) {
            return false;
        }

        /* Member must exist */
        $group->load('members');
        return $group->members->contains($user) && $user !== null;
    }
}
