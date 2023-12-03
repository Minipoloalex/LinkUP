<?php

namespace App\Http\Controllers;

use App\Events\FollowRequestEvent;
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
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('pages.profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', User::class);
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:150',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4',
            'x' => 'nullable|int',
            'y' => 'nullable|int',
            'width' => 'nullable|int',
            'height' => 'nullable|int'
        ]);
        if ($request->has('media') && $request->media != null && $request->file('media')->isValid()) {
            if ($user->photo != 'def.jpg' && $user->photo != null) {
                $this->imageController->delete($user->photo);
            }
            $user->photo = 'profile_' . $user->id . '.' . $request->media->extension();
            $this->imageController->store($request->media, $user->photo, $request->input('x'), $request->input('y'), $request->input('width'), $request->input('height'));
        }

        $user->update([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $user->photo ?? 'def.jpg'
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    public function viewProfilePicture(string $id)
    {
        $user = User::findOrFail($id);
        return $this->imageController->getFileResponse($user->photo);
    }
    public function viewNetworkPage(string $username)
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

        return response()->json(['success' => "$follower->username removed from follower list successfully!"]);
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

        return response()->json(['success' => "$following->username removed from following list successfully!"]);
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
            $request = FollowRequest::create([
                'id_user_from' => $user->id,
                'id_user_to' => $requestTo->id,
                'timestamp' => now()
            ]);
            $accepted = false;
            $feedback = "Follow request sent to $requestTo->username successfully!";
            event(new FollowRequestEvent(FollowRequest::findOrFail($request->id)));
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
    public function denyFollowRequest(string $id)
    {
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
    public function acceptFollowRequest(string $id)
    {
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
    public function translateUserToHTML(User $user)
    {
        $userHTML = view('partials.network.follower_card', [
            'user' => $user,
            'isMyProfile' => false
        ])->render();
        return $userHTML;
    }
    public function translateUsersArrayToHTML($users)
    {
        $usersHTML = $users->map(function ($user) {
            return $this->translateUserToHTML($user);
        });
        return $usersHTML;
    }
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255'
        ]);
        $users = User::search($request->input('query'));
        if (Auth::check()) {
            $users = $users->filter(function (User $user) {    // remove self from results
                return $user->id != Auth::user()->id;
            })->values();
        }
        if ($users->isEmpty()) {
            $noResultsHTML = view('partials.search.no_results')->render();
            return response()->json([
                'success' => 'No results found',
                'noResultsHTML' => $noResultsHTML,
                'resultsHTML' => []
            ]);
        }
        $usersHTML = $this->translateUsersArrayToHTML($users);
        return response()->json(['resultsHTML' => $usersHTML, 'success' => 'Search results retrieved']);
    }
}
