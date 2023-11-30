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
        $this->authorize('view', $group);

        return view('pages.group', [
            'group' => $group,
        ]);
    }
}
