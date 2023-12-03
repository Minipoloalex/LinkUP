<?php

namespace App\Http\Controllers;

use App\Models\FollowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $imageController;

    public function __construct()
    {
        $this->imageController = new ImageController('users');
    }

    /**
     * Show the user's profile.
     * 
     * @param string $username 
     * @return \Illuminate\Http\Response
     */
    public function showProfile(string $username)
    {
        $user = User::firstOrFail()->where('username', $username)->firstOrFail();

        return view('pages.profile', ['user' => $user]);
    }

    /**
     * Show the user's settings.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showSettings(Request $request)
    {
        $user = Auth::user();

        $activeSection = $request->from ?? 'account'; // default to account section

        return view('pages.settings', ['user' => $user, 'activeSection' => $activeSection]);
    }

    /**
     * Update the user's profile.
     * 
     * @param Request $request 
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function updateProfile(Request $request)
    {
        $this->authorize('update', User::class);
        
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'faculty' => ['required', 'string', 'max:255'],
            'course' => ['nullable', 'string', 'max:255'],
            'media' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
        ]);

        if ($request->has('media') && $request->media != null && $request->file('media')->isValid()) {
            if ($user->photo != 'def.jpg' && $user->photo != null) {
                $this->imageController->delete($user->photo);
            }
            $user->photo = 'profile_' . $user->id . '.' . $request->media->extension();
            $this->imageController->store($request->media, $user->photo);
        }

        $user->update([
            'name' => $request->name,
            'description' => $request->description,
            'faculty' => $request->faculty,
            'course' => $request->course,
            'photo' => $user->photo ?? 'def.jpg'
        ]);

        return redirect()->route('profile.show', ['username' => $user->username])->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's settings.
     * 
     * @param Request $request 
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function updateSettings(Request $request)
    {
        $this->authorize('update', User::class);

        $user = Auth::user();

        $request->validate([
            'username' => ['required', 'string', 'max:15', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'privacy' => ['required', 'string', 'in:public,private'],
            'current_password' => ['required', 'string'],
        ]);

        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The given password is incorrect.']);
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'is_private' => $request->privacy === 'private',
        ]);

        if ($request->new_password) {
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);
        }

        return redirect()->route('settings.show', ['from' => 'account'])->with('success', 'Settings updated successfully!');
    }

    public function viewProfilePicture(string $id)
    {
        $user = User::findOrFail($id);
        return $this->imageController->getFileResponse($user->photo);
    }

    public function showNetwork(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('pages.network', ['user' => $user]);
    }

    public function removeFollower(string $id)
    {
        $this->authorize('update', User::class);
        $user = Auth::user();

        $follower = User::findOrFail($id);
        $user->followers()->detach($follower->id);

        $follower->success = "$follower->username removed from follower list successfully!";
        return response()->json($follower);
    }

    public function removeFollowing(string $id)
    {
        $this->authorize('update', User::class);
        $user = Auth::user();

        $following = User::findOrFail($id);

        if (!$user->isFollowing($following)) {      // check if user is not following
            return response()->json([
                'error' => 'You are not following this user!'
            ]);
        }
        $user->following()->detach($following->id);

        $following->success = "$following->username removed from following list successfully!";
        return response()->json($following);
    }

    public function requestFollow(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);
        $this->authorize('update', User::class);
        $user = Auth::user();

        // check if user is already following
        $requestTo = User::findOrFail($request->id);
        if ($user->isFollowing($requestTo)) {
            return response()->json([
                'error' => 'You are already following this user!'
            ]);
        }
        if ($user->requestedToFollow($requestTo)) {
            return response()->json([
                'error' => 'You already have a pending follow request to this user!'
            ]);
        }
        $feedback = '';
        $accepted = true;
        if ($requestTo->is_private) {   // request to follow
            FollowRequest::create([
                'id_user_from' => $user->id,
                'id_user_to' => $requestTo->id,
                'timestamp' => now()
            ]);
            $accepted = false;
            $feedback = "Follow request sent to $requestTo->username successfully!";
        } else {                          // add to following list
            $user->following()->attach($requestTo->id);
            $feedback = "$requestTo->username added to following list successfully!";
        }

        $requestTo->success = $feedback;
        $requestTo->accepted = $accepted;
        return response()->json($requestTo);
    }

    public function cancelRequestToFollow(string $id)
    {
        $this->authorize('update', User::class);
        $user = Auth::user();

        $sentTo = User::findOrFail($id);

        if ($user->isFollowing($sentTo)) {      // check if user is already following
            return response()->json([
                'error' => 'You are already following this user!',
                'accepted' => true
            ]);
        }
        if (!$user->requestedToFollow($sentTo)) {      // check if user is not following
            return response()->json([
                'error' => 'You do not have a pending follow request to this user!'
            ]);
        }
        $followRequest = $user->followRequestsSent()->where('id_user_to', $sentTo->id)
            ->firstOrFail();
        $followRequest->delete();

        $sentTo->success = "Follow request to $sentTo->username cancelled successfully!";
        return response()->json($sentTo);
    }

    public function denyFollowRequest(string $id) {
        $this->authorize('update', User::class);
        $user = Auth::user();
        $sentFrom = User::findOrFail($id);
        if (!$sentFrom->requestedToFollow($user)) {
            return response()->json(['error' => "You do not have a pending follow request from $sentFrom->username!"]);
        }

        $followRequest = $user->followRequestsReceived()->where('id_user_from', $sentFrom->id)
            ->firstOrFail();
        $followRequest->delete();

        $sentFrom->success = "You denied the follow request from $sentFrom->username";
        return response()->json($sentFrom);
    }
    
    public function acceptFollowRequest(string $id) {
        $this->authorize('update', User::class);
        $user = Auth::user();
        $sentFrom = User::findOrFail($id);
    
        if (!$sentFrom->requestedToFollow($user)) {
            return response()->json(["error' => 'You do not have a pending follow request from $sentFrom->username!"]);
        }

        DB::beginTransaction();

        $followRequest = $user->followRequestsReceived()->where('id_user_from', $sentFrom->id)
            ->firstOrFail();
        $followRequest->delete();
        $user->followers()->attach($sentFrom->id);
        DB::commit();
        $userHTML = view('partials.network.follower_card', [
            'user' => $user,
            'isMyProfile' => true
        ])->render();

        return response()->json(['userHTML' => $userHTML, 'success' => "You accepted the follow request from $sentFrom->username", 'userId' => $sentFrom->id]);
    }
}
