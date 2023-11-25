<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $imageController;

    public function __construct()
    {
        $this->imageController = new ImageController('users');
    }
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('pages.profile', ['user' => $user]);
    } 

    public function update(Request $request)
    {
        $this->authorize('update', User::class);
        $user = Auth::user();
        Log::info($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:150',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4'
        ]);
        Log::info('Hello');
        if ($request->has('media') && $request->media != null && $request->file('media')->isValid()) {
            Log::info('Request has media');
            if ($user->photo != 'def.jpg' && $user->photo != null) {
                $this->imageController->delete($user->photo);
            }
            $user->photo = 'profile_' . $user->id . '.' . $request->media->extension();
            $this->imageController->store($request->media, $user->photo);
        }
        
        $user->update([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $user->photo ?? 'def.jpg'
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');    
    }
}
