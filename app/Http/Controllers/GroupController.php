<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\User;
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

        return view('pages.groups.group', [
            'group' => $group,
            'posts' => $posts,
            'members' => $members,
            'user' => $user->id,
            'user_is_member' => $is_member,
            'user_is_owner' => $is_owner,
            'user_is_pending' => $is_pending,
        ]);
    }

    public function settings(string $id)
    {
        $group = Group::findOrFail($id);

        $this->authorize('settings', $group);

        return view('pages.groups.settings', ['group' => $group]);
    }

    public function deleteMember(string $id, string $id_member)
    {
        if ($id_member == 'self') {
            $id_member = Auth::user()->id;
        }

        $group = Group::findOrFail($id);
        $this->authorize('deleteMember', [$group, $id_member]);

        if ($group->id_owner == $id_member) {
            return response('Cannot delete owner', 403);
        }

        $member = GroupMember::where('id_group', $id)->where('id_user', $id_member)->firstOrFail();
        $member->delete();

        return response('Member deleted', 200);
    }

    public function joinRequest(string $id)
    {
        $group = Group::findOrFail($id);
        $user = Auth::user();

        if ($group->members()->where('id_user', $user->id)->exists()) {
            return response('Already member', 403);
        }

        if ($group->pendingMembers()->where('id_user', $user->id)->exists()) {
            return response('Already pending', 403);
        }

        $group->pendingMembers()->attach($user->id, ['type' => 'Request']);
        return response('Request sent', 200);
    }

    public function cancelJoinRequest(string $id)
    {
        $group = Group::findOrFail($id);
        $user = Auth::user();

        if (!$group->pendingMembers()->where('id_user', $user->id)->exists()) {
            return response('Not pending', 403);
        }

        $group->pendingMembers()->detach($user->id);

        return response('Request canceled', 200);
    }

    public function resolveRequest(request $request, string $id, string $id_member)
    {
        $group = Group::findOrFail($id);

        $this->authorize('resolveRequest', [$group, $id_member]);

        $group->pendingMembers()->detach($id_member);

        \Log::info($request->input('accept'));
        if ($request->input('accept') == 'reject') {
            return response('Request rejected', 200);
        }

        $group->members()->attach($id_member);
        return response('Request accepted', 200);
    }

    public function update(Request $request, string $id)
    {
        $group = Group::findOrFail($id);

        $this->authorize('settings', $group);

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:150',
        ]);

        $group->name = $request->input('name');
        $group->description = $request->input('description');

        $group->save();

        return redirect()->route('group', ['id' => $id]);
    }

    /**
     * Verify authentication of a user.
     */
    public function verifyPassword(Request $request)
    {
        $user = Auth::user();
        $password = $request->input('password');

        if (password_verify($password, $user->password)) {
            return response('Password verified', 200);
        }

        return response('The provided password does not match our records.', 403);
    }

    public function delete(string $id)
    {
        $group = Group::findOrFail($id);

        $this->authorize('settings', $group);
        $group->delete();

        return response('Group deleted', 200);
    }
}
