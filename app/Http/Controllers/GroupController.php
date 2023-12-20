<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\User;
use Auth;
use \App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class GroupController extends Controller
{
    private static int $amountPerPage = 10;
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

        return view('pages.groups.group', [
            'group' => $group,
            'user_is_member' => $is_member,
            'user_is_owner' => $is_owner,
            'user_is_pending' => $is_pending,
        ]);
    }

    public function showCreateForm()
    {
        if (!Auth::check())
            return redirect('/login');

        return view('pages.groups.create');
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:150',
        ]);

        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->id_owner = Auth::user()->id;

        $group->save();

        $group->members()->attach(Auth::user()->id);

        return redirect()->route('group.show', ['id' => $group->id])->with('success', 'Group created');
    }

    public function settings(string $id)
    {
        $group = Group::findOrFail($id);

        $this->authorize('settings', $group);

        // Fetch users who are not members of the group
        $users = User::whereNotIn('users.id', $group->members()->pluck('users.id'))->get();
        

        return view('pages.groups.settings', [
            'group' => $group,
            'users' => $users, // Pass the $users variable to the view
        ]);
    }

    public function changeOwner(Request $request, string $id)
    {
        $group = Group::findOrFail($id);
        Log::info($id);

        $this->authorize('settings', $group);

        $request->validate([
            'new_owner' => 'required|int'
        ]);

        $new_owner = User::findOrFail($request->input('new_owner'));

        if (!$group->members()->where('id_user', $new_owner->id)->exists()) {
            return response('User is not a member', 403);
        }

        $group->id_owner = $new_owner->id;
        $group->save();

        return redirect()->route('group.show', ['id' => $id])->with('feedback', 'Owner changed');
    }

    public function inviteUser(Request $request, string $id)
{
    $group = Group::findOrFail($id);
    Log::info('group found');
    $user = Auth::user();
    Log::info('user found');
    Log::info($id);
    Log::info($group->id_owner);

    //log new_member
    Log::info($request->input('new_member'));

    $request->validate([
        'new_member' => 'required|int'
    ]);

    Log::info('request validated');

    // get invited user
    $userToInvite = User::findOrFail($request->input('new_member'));
    Log::info('user to invite found');
    Log::info($userToInvite);

    // Check if the user is already a member or has a pending request
    if ($group->members()->where('id_user', $userToInvite->id)->exists() || 
        $group->pendingMembers()->where('id_user', $userToInvite->id)->exists()) {
        Log::info('user is already a member or has a pending request');
        return response('User is already a member or has a pending request', 403);
    }

    Log::info('user is not a member or has a pending request');

    // Create a pending invitation for the user
    $group->pendingMembers()->attach($userToInvite->id, ['type' => 'Invitation']);
    Log::info('everything is fine');
    return response('Invitation sent', 200);
}


    
    public function deleteMember(string $id, string $id_member)
    {
        if ($id_member == 'self') {
            $id_member = Auth::user()->id;
        }
        if (!is_numeric($id_member)) {
            return response('Invalid member id', 400);
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

        $imageController = new ImageController('groups');
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->image;
            $checkSize = $imageController->checkMaxSize($image);
            if ($checkSize !== false) {
                return $checkSize;
            }
        }

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:150',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'x' => 'nullable|int',
            'y' => 'nullable|int',
            'width' => 'nullable|int',
            'height' => 'nullable|int'
        ]);

        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        if ($request->has('image') && $request->image != null && $request->file('image')->isValid()) {
            $fileName = $imageController->getFileNameWithExtension(str($group->id));
            if ($imageController->existsFile($fileName)) {
                $imageController->delete($fileName);
            }
            $imageController->store($request->image, $fileName, $request->x, $request->y, $request->width, $request->height);
        }

        return redirect()->route('group.show', ['id' => $id])->with('feedback', 'Group updated');
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
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
            'page' => 'required|int'
        ]);
        $page = $request->input('page');
        $groups = Group::search($request->input('query'))->skip($page * self::$amountPerPage)->take(self::$amountPerPage)->get();
        if ($groups->isEmpty()) {
            $noResultsHTML = view('partials.search.no_results')->render();
            return response()->json([
                'noResultsHTML' => $noResultsHTML,
                'success' => 'No results found',
                'resultsHTML' => []
            ]);
        }
        $resultsHTML = $this->translateGroupsArrayToHTML($groups, Auth::user());
        return response()->json(['resultsHTML' => $resultsHTML, 'success' => 'Search results retrieved']);
    }
    public function translateGroupsArrayToHTML(Collection $groups, ?User $user)
    {
        $html = $groups->map(function ($group) use ($user) {
            return $this->translateGroupToHTML($group, $group->isOwner($user));
        });
        return $html;
    }
    public function translateGroupToHTML(Group $group, bool $isOwner = false)
    {
        return view('partials.search.group', ['group' => $group, 'isOwner' => $isOwner])->render();
    }

    public function leaveGroup()
    {
        return redirect()->route('home')->with('feedback', 'You left the group.');
    }
}
