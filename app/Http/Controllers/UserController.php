<?php

namespace App\Http\Controllers;

// UserController.php
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class UserController extends Controller
{
    // UserController.php

    public function show($email)
    {
        // Fetch user data based on the email
        $user = User::where('email', $email)->first();

        if (!$user) {
            abort(404); // User not found, return a 404 response
        }

        // Return the user profile view
        return view('pages.profile', [
            'user' => $user]);
    }

}