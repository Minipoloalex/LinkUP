<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\MailController;

use App\Models\Admin;
use App\Models\User;
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
    public function searchPosts(Request $request)
    {
        $request->validate([
            'page' => 'required|integer|min:0',
            'search' => 'required|string|max:255',
        ]);
        $page = $request->get('page');
        $search = $request->get('search');
        $posts = null;
        if ($search == '') {
            $posts = Post::all()->orderBy('created_at', 'desc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
        else {
            $posts = Post::search(Post::all(), $search)->orderBy('created_at', 'desc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        }
        
        // TODO: complete
        // $htmlArray = $posts->map(function ($post) {    
        //     return view('admin.post', ['post' => $post])->render();
        // });
        // foreach ($posts as $post) {
        //     $htmlArray[] = view('admin.partials.post', ['post' => $post])->render();
        // }
        // return response()->json(['postsHTML' => $htmlArray, 'success' => true, 'message' => 'Search successful.']);
        return response()->json();
    }
    public function searchUsers(Request $request)
    {
        Log::debug($request->all());
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
        Log::debug($users->toJson());
        $htmlArray = $users->map(function ($user) {    
            return view('admin.return_json.user_tr', ['user' => $user])->render();
        });
        Log::debug($htmlArray);
        return response()->json(['usersHTML' => $htmlArray, 'success' => true, 'message' => 'Search successful.']);
    }
}
