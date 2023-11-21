<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;

use App\Models\User;
use App\Models\Post;

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
        $users = User::all();
        return view('admin.users', ['users' => $users]);
    }

    public function listPosts()
    {
        $posts = Post::all();
        return view('admin.posts', ['posts' => $posts]);
    }  
}