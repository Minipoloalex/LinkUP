<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use Auth;
use \App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function show(string $id)
    {
        if (!Auth::check())
            return redirect('/login');

        $group = Group::findOrFail($id);
        $members = $group->members()->get();

        $user = Auth::user();
        $is_member = $members->contains($user);
        $is_owner = $group->id_owner == $user->id;
        $is_pending = $is_member ? false : $group->pendingMembers()->where('id_user', $user->id)->where('type', 'Request')->exists();

        $this->authorize('view', $group);

        $posts = $group->posts()->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.group', [
            'group' => $group,
            'posts' => $posts,
            'members' => $members,
            'user' => $user->id,
            'user_is_member' => $is_member,
            'user_is_owner' => $is_owner,
            'user_is_pending' => $is_pending,
        ]);
    }

    public function deleteMember(string $id, string $id_member)
    {
        $group = Group::findOrFail($id);
        $this->authorize('deleteMember', $group);

        if ($group->id_owner == $id_member) {
            return response('Cannot delete owner', 403);
        }

        $member = GroupMember::where('id_group', $id)->where('id_user', $id_member)->firstOrFail();
        $member->delete();

        return response();
    }
}
