<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\MailModel;

class MailController extends Controller
{
    public static function sendBanEmail(string $name, string $email)
    {
        $mailData = [
            'name' => $name,
            'email' => $email,
            'subject' => 'Account Banned',
            'view' => 'emails.ban',
        ];
        
        Mail::to($email)->send(new MailModel($mailData));

        return response()->json(['message' => 'Email has been sent.']);
    }

    public static function sendAccountDeletedEmail(string $name, string $email)
    {
        $mailData = [
            'name' => $name,
            'email' => $email,
            'subject' => 'Account Deleted',
            'view' => 'emails.account-deleted',
        ];
        
        Mail::to($email)->send(new MailModel($mailData));

        return response()->json(['message' => 'Email has been sent.']);
    }

    public static function sendGroupDeletedEmail(string $name, string $email, string $group_name)
    {
        $mailData = [
            'name' => $name,
            'email' => $email,
            'group_name' => $group_name,
            'subject' => 'Group Deleted',
            'view' => 'emails.group-deleted',
        ];
        
        Mail::to($email)->send(new MailModel($mailData));

        return response()->json(['message' => 'Email has been sent.']);
    }


}