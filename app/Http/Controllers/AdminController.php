<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('admin.dashboard');
    }

    public function showCreateForm()
    {
        return view('admin.create');
    }

    public function createAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully.');
    }
    
    public function listUsers()
    {
        return view('admin.users');
    }

    public function listPosts()
    {
        return view('admin.posts');
    }

    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = true;
        $user->save();

        $subject = 'Account Banned';
        $view = 'emails.ban';

        if (MailController::sendBanEmail($user->name, $user->email, $subject, $view)) {
            return redirect()->route('admin.users')->with('success', 'User banned successfully.');
        }

        return redirect()->route('admin.users')->with('error', 'User banned successfully, but email failed to send.');
    }

    public function unbanUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = false;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User unbanned successfully.');
    }

    public function listGroups()
    {
        $groups = Group::paginate(10);

        return view('admin.groups', ['groups' => $groups]);
    }

    public function deleteGroup($id)
    {
        $group = Group::findOrFail($id);

        // delete all group posts and remove all members
        $group->posts()->delete();
        $group->members()->detach();

        $group->delete();

        $owner = $group->owner;
        if ($owner->name !== 'deleted') {
            
            $subject = 'Group Deleted';
            $view = 'emails.group-deleted';
            
            // send email to owner, notifying them that their group was deleted
            if (MailController::sendGroupDeletedEmail($owner->name, $owner->email, $group->name, $subject, $view)) {
                return redirect()->route('admin.groups')->with('success', 'Group deleted successfully.');
            }
        }

        return redirect()->route('admin.groups')->with('error', 'Group deleted successfully, but email failed to send.');
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully.',
            ]);
        }
        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully.');
    }
    public function viewPost($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.post', ['post' => $post]);
    }
    public function viewGroup($id)
    {
        $group = Group::findOrFail($id);

        return view('admin.group', ['group' => $group]);
    }
    public function viewUser($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        return view('admin.user', ['user' => $user]);
    }
    public function searchPosts(Request $request)
    {
        $request->validate([
            'page' => 'required|integer|min:0',
            'query' => 'nullable|string|max:255',
        ]);
        $page = $request->get('page');
        $query = $request->get('query');
        $posts = null;
        if ($query == null || $query == '') {
            $posts = Post::orderBy('created_at', 'desc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
        else {
            $posts = Post::search(Post::getModel()->select('*'), $query)->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
    
        $htmlArray = $posts->map(function ($post) {    
            return view('partials.admin.post', ['post'=> $post])->render();
        });
        return response()->json(['resultsHTML' => $htmlArray, 'success' => true, 'message' => 'Search successful.']);
    }
    public function searchUsers(Request $request)
    {
        $request->validate([
            'page' => 'required|integer|min:0',
            'query' => 'nullable|string|max:255',
        ]);
        $page = $request->get('page');
        $query = $request->get('query');
        $users = null;
        if ($query == null || $query == '') {  
            $users = User::orderBy('username', 'asc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
        else {
            $users = User::search($query)->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
        $htmlArray = $users->map(function ($user) {    
            return view('admin.return_json.user_tr', ['user' => $user])->render();
        });
        return response()->json(['resultsHTML' => $htmlArray, 'success' => true, 'message' => 'Search successful.']);
    }
    public function searchGroups(Request $request)
    {
        $request->validate([
            'page' => 'required|integer|min:0',
            'query' => 'nullable|string|max:255',
        ]);
        $page = $request->get('page');
        $query = $request->get('query');
        $groups = null;
        if ($query == null || $query == '') {  
            $groups = Group::orderBy('name', 'asc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
        else {
            $groups = Group::search($query)->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
        $htmlArray = $groups->map(function ($group) {    
            return view('admin.return_json.group_tr', ['group' => $group])->render();
        });
        return response()->json(['resultsHTML' => $htmlArray, 'success' => true, 'message' => 'Search successful.']);
    }
}
