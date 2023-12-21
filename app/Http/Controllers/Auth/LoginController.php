<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('home')->with('feedback', 'You are already logged in!');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $attemptCredentials = [
            filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username' => $request->login,
            'password' => $request->password,
        ];

        // attempt to log in as a normal user
        if (Auth::attempt($attemptCredentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        // if login of type email failed, attempt to log in as an admin
        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            if (Auth::guard('admin')->attempt($attemptCredentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }
        }

        return back()->with('feedback', 'The provided credentials do not match our records.')->onlyInput('login');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->with('feedback', 'You have logged out successfully!');
    }
}
