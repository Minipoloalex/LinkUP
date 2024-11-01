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
    }

    public function settings(User $user, Group $group): bool
    {
        return $group->id_owner == $user->id;
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

    public function resolveRequest(User $user, Group $group, string $id_member): bool
    {
        /* Only owner can resolve requests */
        if ($group->id_owner != $user->id) {
            return false;
        }

        /* User must be pending */
        return $group->pendingMembers()->where('id_user', $id_member)->exists();
    }
}
