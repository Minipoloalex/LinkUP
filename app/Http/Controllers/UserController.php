<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('pages.profile', ['user' => $user]);
    } 

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        return redirect()->route('profile.show', ['username' => $user->username]);
    }
}
