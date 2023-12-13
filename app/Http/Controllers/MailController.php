<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\MailModel;

class MailController extends Controller
{
    public static function sendEmail(string $name, string $email, string $subject, string $view)
    {
        $mailData = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'view' => $view,
        ];
        
        Mail::to($email)->send(new MailModel($mailData));

        return response()->json(['message' => 'Email has been sent.']);
    }
}