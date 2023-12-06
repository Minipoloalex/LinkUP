<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{   
    /**
     * Show the form to reset the password.
     *
     * @return \Illuminate\View\View
     */
    public function showResetForm(string $token)
    {   
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => $password])->save();
            }
        );

        // if the token is invalid, the user is prompted to request a new one
        if ($status === Password::INVALID_TOKEN) {
            return redirect()->route('password.request')->withErrors(['email' => __($status)]);
        }

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}