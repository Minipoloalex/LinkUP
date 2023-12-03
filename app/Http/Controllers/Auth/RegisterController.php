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
            return redirect('home')->withSuccess('You are already logged in!');;
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
            return redirect('home')->withSuccess('You are already logged in!');
        }
        $request->validate([
            'username' => 'required|string|max:15|unique:users',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->username,   // Default name is username.
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->withSuccess('You have successfully registered!');
    }
}
