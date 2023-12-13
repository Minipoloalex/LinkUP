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
        $users = User::paginate(10);

        return view('admin.users', ['users' => $users]);
    }

    public function listPosts()
    {
        $posts = Post::paginate(10);

        return view('admin.posts', ['posts' => $posts]);
    }

    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = true;
        $user->save();

        $subject = 'Account Banned';
        $view = 'emails.ban';

        if (MailController::sendEmail($user->name, $user->email, $subject, $view)) {
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

        // Delete all group posts and remove all members
        $group->posts()->delete();
        $group->members()->detach();

        $group->delete();

        return redirect()->route('admin.groups')->with('success', 'Group deleted successfully.');
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
    
    public function deletePostJS($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully.');
    }
    
    public function viewPost($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.post', ['post' => $post]);
    }
}
