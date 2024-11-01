<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        if (Auth::check()) {
            return redirect('home')->with('feedback', 'You are already logged in!');
            ;
        } else {
            return view('auth.register');
        }
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect('home')->with('feedback', 'You are already logged in!');
        }
        $request->validate([
            'username' => ['required', 'string', 'max:15', 'unique:users'],
            'faculty' => ['required', 'string', 'max:6'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:admin'], // 'unique:admins' is added to prevent users from registering with an admin's email.
            'password' => ['required', 'confirmed', 'min:8', 'max:255'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->username,   // Default name is username.
            'faculty' => $request->faculty,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('feedback', 'You have successfully registered!');
    }
}