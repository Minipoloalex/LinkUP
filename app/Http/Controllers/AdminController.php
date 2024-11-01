<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MailController;

use App\Models\Admin;
use App\Models\User;
use App\Models\Group;
use App\Models\Post;

use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    private static int $amountPerPage = 10;
    public function index()
    {
        $this->authorize('admin', Admin::class);
        return view('admin.dashboard');
    }

    public function showCreateForm()
    {
        $this->authorize('admin', Admin::class);
        return view('admin.create');
    }

    public function createAdmin(Request $request)
    {
        $this->authorize('admin', Admin::class);
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.create')->with('feedback', 'Admin created successfully.');
    }

    public function listUsers()
    {
        $this->authorize('admin', Admin::class);
        return view('admin.users');
    }

    public function listPosts()
    {
        $this->authorize('admin', Admin::class);
        return view('admin.posts');
    }

    public function banUser($id)
    {
        $this->authorize('admin', Admin::class);
        $user = User::findOrFail($id);
        $user->is_banned = true;
        $user->save();

        if (MailController::sendBanEmail($user->name, $user->email)) {
            return redirect()->route('admin.users')->with('feedback', 'User banned successfully.');
        }

        return redirect()->route('admin.users')->with('feedback', 'User banned successfully, but email failed to send.');
    }

    public function unbanUser($id)
    {
        $this->authorize('admin', Admin::class);
        $user = User::findOrFail($id);
        $user->is_banned = false;
        $user->save();

        return redirect()->route('admin.users')->with('feedback', 'User unbanned successfully.');
    }

    public function deleteUser($id)
    {
        $this->authorize('admin', Admin::class);
        $user = User::findOrFail($id);

        $name = $user->name;
        $email = $user->email;

        // update user to deleted
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

        $userController = new UserController();
        $imageController = $userController->imageController;
        
        // delete profile picture
        $filename = $imageController->getFileNameWithExtension(str($id));
        if ($imageController->existsFile($filename)) {
            $imageController->delete($filename);
        }

        // remove followers and following
        $user->followers()->detach();
        $user->following()->detach();

        // remove from groups
        $user->groups()->delete();

        // send email to user, notifying them that their account was deleted
        if (MailController::sendAccountDeletedEmail($name, $email)) {
            return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
        }

        return redirect()->route('admin.users')->with('error', 'User deleted successfully, but email failed to send.');
    }

    public function listGroups()
    {
        $this->authorize('admin', Admin::class);
        return view('admin.groups');
    }

    public function deleteGroup($id)
    {
        $this->authorize('admin', Admin::class);
        $group = Group::findOrFail($id);

        // delete all group posts and remove all members
        $group->posts()->delete();
        $group->members()->detach();

        $group->delete();

        $owner = $group->owner;
        if ($owner->name !== 'deleted') {

            // send email to owner, notifying them that their group was deleted
            if (MailController::sendGroupDeletedEmail($owner->name, $owner->email, $group->name)) {
                return redirect()->route('admin.groups')->with('feedback', 'Group deleted successfully.');
            }
        }

        return redirect()->route('admin.groups')->with('feedback', 'Group deleted successfully, but email failed to send.');
    }

    public function deletePost($id)
    {
        $this->authorize('admin', Admin::class);
        $post = Post::findOrFail($id);
        $post->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => 'Post deleted successfully.',
            ]);
        }
        return redirect()->route('admin.posts')->with('feedback', 'Post deleted successfully.');
    }

    public function viewPost($id)
    {
        $this->authorize('admin', Admin::class);
        $post = Post::findOrFail($id);

        return view('admin.post', ['post' => $post]);
    }

    public function viewGroup($id)
    {
        $this->authorize('admin', Admin::class);
        $group = Group::findOrFail($id);

        return view('admin.group', ['group' => $group]);
    }

    public function viewUser($username)
    {
        $this->authorize('admin', Admin::class);
        $user = User::where('username', $username)->firstOrFail();

        return view('admin.user', ['user' => $user]);
    }

    public function viewNetwork($username)
    {
        $this->authorize('admin', Admin::class);
        $user = User::where('username', $username)->firstOrFail();
        
        return view('admin.network', ['user' => $user]);
    }

    public function searchPosts(Request $request)
    {
        $this->authorize('admin', Admin::class);
        $request->validate([
            'page' => 'required|integer|min:0',
            'query' => 'nullable|string|max:255',
        ]);
        
        $page = $request->get('page');
        $query = $request->get('query');
        $posts = null;
        
        if ($query == null || $query == '') {
            $posts = Post::orderBy('created_at', 'desc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        } else {
            $posts = Post::search(Post::getModel()->select('*'), $query)->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
        
        $htmlArray = $posts->map(function ($post) {
            return view('partials.admin.post', ['post' => $post])->render();
        });
        
        return response()->json(['resultsHTML' => $htmlArray, 'success' => true, 'message' => 'Search successful.']);
    }

    public function searchUsers(Request $request)
    {
        $this->authorize('admin', Admin::class);
        $request->validate([
            'page' => 'required|integer|min:0',
            'query' => 'nullable|string|max:255',
        ]);
        
        $page = $request->get('page');
        $query = $request->get('query');
        $users = null;
        
        if ($query == null || $query == '') {
            $users = User::orderBy('username', 'asc')->where('is_deleted', false)->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        } else {
            $users = User::search($query)->where('is_deleted', false)->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }

        $htmlArray = $users->map(function ($user) {
            return view('admin.return_json.user_tr', ['user' => $user])->render();
        });

        return response()->json(['resultsHTML' => $htmlArray, 'success' => true, 'message' => 'Search successful.']);
    }

    public function searchGroups(Request $request)
    {
        $this->authorize('admin', Admin::class);
        $request->validate([
            'page' => 'required|integer|min:0',
            'query' => 'nullable|string|max:255',
        ]);

        $page = $request->get('page');
        $query = $request->get('query');
        $groups = null;

        if ($query == null || $query == '') {
            $groups = Group::orderBy('name', 'asc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        } else {
            $groups = Group::search($query)->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }

        $htmlArray = $groups->map(function ($group) {
            return view('admin.return_json.group_tr', ['group' => $group])->render();
        });

        return response()->json(['resultsHTML' => $htmlArray, 'success' => true, 'message' => 'Search successful.']);
    }
}
