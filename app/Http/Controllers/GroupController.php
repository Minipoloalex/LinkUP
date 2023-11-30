<?php

namespace App\Http\Controllers;

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

        $this->authorize('view', $group);

        $posts = $group->posts()->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.group', [
            'group' => $group,
            'posts' => $posts,
            'members' => $members,
            'user_is_member' => $is_member,
        ]);
    }
}
