<?php

namespace App\Http\Controllers;

use App\Events\FollowRequestEvent;
use App\Models\FollowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\GroupMember;

use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    private ImageController $imageController;
    private static int $amountPerPage = 10;

    public function __construct()
    {
        $this->imageController = new ImageController('users');
    }

    /**
     * Show the user's profile.
     * 
     * @param string $username 
     */
    public function showProfile(string $username)
    {
        $user = User::firstOrFail()->where('username', $username)->firstOrFail();

        return view('pages.profile', ['user' => $user]);
    }

    /**
     * Show the user's settings.
     * 
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
            'bio' => ['nullable', 'string', 'max:255'],
            'faculty' => ['required', 'string', 'max:255'],
            'course' => ['nullable', 'string', 'max:255'],
            'media' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
            'x' => ['nullable', 'int'],
            'y' => ['nullable', 'int'],
            'width' => ['nullable', 'int'],
            'height' => ['nullable', 'int']
        ]);

        if ($request->has('media') && $request->media != null && $request->file('media')->isValid()) {
            $fileName = $this->imageController->getFileNameWithExtension(str($user->id));
            if ($this->imageController->existsFile($fileName)) {
                $this->imageController->delete($fileName);
            }
            $this->imageController->store($request->media, $fileName, $request->input('x'), $request->input('y'), $request->input('width'), $request->input('height'));
        }

        $user->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'faculty' => $request->faculty,
            'course' => $request->course,
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
        $fileName = $this->imageController->getFileNameWithExtension(str($user->id));
        return $this->imageController->getFileResponse($fileName);
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
        if ($user->id == $request->input('id')) {
            return response()->json([
                'error' => 'You cannot follow yourself!'
            ]);
        }
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
                'timestamp' => time(),
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
            return response()->json(['error' => "You do not have a pending follow request from $sentFrom->username!"]);
        }
        if ($sentFrom->isFollowing($user)) {
            return response()->json(['error' => "$sentFrom->username is already following you!"]);
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
            'query' => 'required|string|max:255',
            'page' => 'required|int'
        ]);
        $page = $request->input('page');
        $users = User::search($request->input('query'))->skip($page * self::$amountPerPage)->take(self::$amountPerPage)->get();
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

    public function groupMembers(int $id, Request $request)
    {
        $request->validate([
            'page' => 'required|int'
        ]);
        $page = $request->input('page');

        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        Log::debug("page $page");
        $user = Auth::user();

        $is_member = GroupMember::where('id_group', $id)->where('id_user', $user->id)->exists();
        if (!$is_member) {
            return response()->json(['error' => 'You are not a member of this group'], 401);
        }

        $members = GroupMember::where('id_group', $id)->orderBy('id_user')->skip($page * self::$amountPerPage)->take(self::$amountPerPage)->get();
        Log::debug($members);
        $users = $members->map(function ($group_member) {
            return $group_member->user;
        });
        Log::debug($users);

        $membersHTML = $this->translateUsersArrayToHTML($users);
        if ($users->isEmpty()) {
            $noMembersHTML = view('partials.search.no_results')->render();
            return response()->json([
                'noneHTML' => $noMembersHTML,
                'elementsHTML' => []
            ]);
        }
        return response()->json(['elementsHTML' => $membersHTML]);
    }
}
