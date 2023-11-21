<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;



class UserController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('pages.profile', compact('user'));

    }   

    public function update(Request $request, $id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Update user data with the new values from the form
        $user->name = $request->input('name');
        $user->username = $request->input('username');

        // Save the updated user
        $user->save();

        // Redirect to a success page or back to the profile page
        return redirect()->route('profile.show', ['username' => $user->username]);
    }
}
