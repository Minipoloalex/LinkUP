<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    
    public function listUsers()
    {
        $users = User::all();
        return view('admin.users', ['users' => $users]);
    }

    public function listPosts()
    {
        $posts = Post::all();
        return view('admin.posts', ['posts' => $posts]);
    }  
}