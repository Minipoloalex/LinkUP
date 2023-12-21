<?php

namespace App\Http\Controllers;

use App\Events\FollowRequestEvent;
use App\Models\FollowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;

use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public ImageController $imageController;
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

        $followRequest = Auth::check() ?
            Auth::user()->followRequestsReceived()->where('id_user_from', $user->id)->first()
            : null;

        if ($followRequest) {
            $followRequest = User::findOrFail($followRequest->id_user_from);
        }

        return view('pages.profile', ['user' => $user, 'followRequest' => $followRequest]);
    }

    /**
     * Show the user's edit profile page.
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditProfile(Request $request)
    {
        $user = Auth::user();

        return view('pages.edit_profile', ['user' => $user]);
    }

    /**
     * Show the user's settings.
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSettings(Request $request)
    {
        $user = Auth::user();

        return view('pages.settings', ['user' => $user]);
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
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $image = $request->media;
            $checkSize = $this->imageController->checkMaxSize($image);
            if ($checkSize !== false) {
                return $checkSize;
            }
        }
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

        return redirect()->route('profile.show', ['username' => $user->username])->with('feedback', 'Profile updated successfully!');
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
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'privacy' => ['required', 'string', 'in:public,private'],
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'is_private' => $request->privacy === 'private',
        ]);

        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('settings.show')->with('success', 'Settings updated successfully!');
    }

    /**
     * Delete the user's account.
     * 
     * @param Request $request 
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function deleteAccount(Request $request)
    {
        $this->authorize('delete', User::class);

        $user = Auth::user();

        $user->update([
            'username' => 'deleted' . $user->id,
            'email' => 'deleted' . $user->id . '@deleted.com',
            'password' => bcrypt('deleted' . $user->id),
            'name' => 'deleted',
            'bio' => null,
            'faculty' => $user->faculty,
            'course' => null,
            'is_private' => true,
            'is_banned' => true,
            'is_deleted' => true,
        ]);

        // delete profile picture
        $fileName = $this->imageController->getFileNameWithExtension(str($user->id));
        if ($this->imageController->existsFile($fileName)) {
            $this->imageController->delete($fileName);
        }

        // remove followers and following
        $user->followers()->detach();
        $user->following()->detach();

        // remove from groups
        $user->groups()->delete();

        Auth::logout();

        return redirect()->route('login')->with('success', 'Account deleted successfully!');
    }

    /**
     * Confirm the user's password.
     * 
     * @param Request $request 
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function confirmPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = Auth::user();

        if (!password_verify($request->password, $user->password)) {
            return response()->json(['error' => 'The provided password does not match our records.'], 403);
        }

        return response()->json(['success' => 'Password verified'], 200);
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

        return response()->json([]);
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

        return response()->json([]);
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

        // time must pe in psql timestamp format
        $time = date('Y-m-d H:i:s', time());

        if ($requestTo->is_private) {   // request to follow
            $request = FollowRequest::create([
                'id_user_from' => $user->id,
                'id_user_to' => $requestTo->id,
                'timestamp' => $time,
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

        return response()->json(['userHTML' => $userHTML, 'userId' => $sentFrom->id]);
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
        Log::debug($request->all());
        $request->validate([
            'query' => 'nullable|string|max:255',
            'page' => 'required|int',
            'exact-match' => 'nullable|string|in:false,true',
            'user-filter-followers' => 'nullable|string|in:false,true',
            'user-filter-following' => 'nullable|string|in:false,true'
        ]);
        $page = $request->input('page');
        $query = $request->input('query') ?? '';
        $exactMatch = $request->input('exact-match') === 'true';
        $followers = $request->input('user-filter-followers') === 'true';
        $following = $request->input('user-filter-following') === 'true';

        $users = null;
        $orderByUsername = $query === '' || $exactMatch;
        if ($query === '') {
            $users = User::query();
        }
        else {
            if ($exactMatch) {
                Log::debug("exact match");
                $users = User::where(function($q) use($query) {
                    $q->whereRaw('LOWER(username) = ?', [strtolower($query)])
                        ->orWhereRaw('LOWER(name) = ?', [strtolower($query)]);
                });
            }
            else {
                $users = User::search($query);
            }
        }
        if ($followers && Auth::check()) {
            Log::debug("filtering to only followers");
            $users = $users->whereIn('id', function ($q) {
                $q->select('id_user')
                    ->from('follows')
                    ->where('id_followed', Auth::user()->id);   // users that follow current user
            });
        }
        if ($following && Auth::check()) {
            Log::debug("filtering to only following");
            $users = $users->whereIn('id', function ($q) {
                $q->select('id_followed')
                    ->from('follows')
                    ->where('id_user', Auth::user()->id);   // users that are followed by current user
            });
        }
        Log::debug("before ordering by usernamae");
        if ($orderByUsername) {
            $users = $users->orderBy('username', 'asc');
        }

        Log::debug($users->toSql());
        $users = $users->skip($page * self::$amountPerPage)->take(self::$amountPerPage)->get();
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


    public function translateMembersArrayToHTML($members, $currUserId, bool $isOwner)
    {
        $membersHTML = $members->map(function ($member) use ($isOwner, $currUserId) {
            $userHTML = view('partials.group.member', [
                'member' => $member,
                'owner' => $isOwner,
                'user' => $currUserId
            ])->render();
            return $userHTML;
        });
        return $membersHTML;
    }
    public function groupMembers(int $id, Request $request)
    {
        $request->validate([
            'page' => 'required|int'
        ]);
        $page = $request->input('page');
        $isAdmin = Auth::guard('admin')->check();

        if (!$isAdmin && !Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }

        $user = Auth::user();   // null if admin
        $userId = $isAdmin ? null : $user->id;
        if (!$isAdmin) {
            $is_member = GroupMember::where('id_group', $id)->where('id_user', $userId)->exists();
            if (!$is_member) {
                return response()->json(['error' => 'You are not a member of this group'], 401);
            }
        }

        $members = GroupMember::join('users', 'id_user', '=', 'users.id')
            ->where('id_group', $id)
            ->orderBy('username')
            ->skip($page * self::$amountPerPage)
            ->take(self::$amountPerPage)
            ->get();

        $users = $members->map(function ($group_member) {
            return $group_member->user;
        });

        $group = Group::findOrFail($id);
        $isOwner = $group->id_owner === $userId;

        $membersHTML = $this->translateMembersArrayToHTML($users, $userId, $isOwner);

        if ($users->isEmpty()) {
            $noMembersHTML = view('partials.search.no_results')->render();
            return response()->json([
                'elementsHTML' => []
            ]);
        }
        return response()->json(['elementsHTML' => $membersHTML]);
    }

    public function getProfilePicture(string $id)
    {
        $path = User::findOrFail($id)->getProfilePicture();
        return response()->json(['path' => $path]);
    }

    public function getUserObject(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }



}
