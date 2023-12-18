<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentNotification;
use App\Models\LikeNotification;
use App\Models\GroupNotification;
use App\Models\FollowRequest;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user()->id;
        $comments = CommentNotification::getSomeNotifications($user, 1000);
        $likes = LikeNotification::getSomeNotifications($user, 1000);
        $groups = GroupNotification::getSomeNotifications($user, 1000);
        $follow = FollowRequest::getSomeNotifications($user, 1000);

        $notifications = $comments->merge($likes)->merge($groups)->merge($follow)
            ->sortByDesc('timestamp');

        return view('pages.notifications', ['notifications' => $notifications]);
    }

    private function translateNotificationsArrayToHtml($notifications)
    {
        return $notifications->map(function ($notification) {
            return $notification->toHtml();
        });
    }

    public function getUserNotifications(Request $request)
    {
        $request->validate(['page' => 'required|int']);
        $page = $request->input('page');

        $user = auth()->user()->id;
        $comments = CommentNotification::getSomeNotifications($user, 1000);
        $likes = LikeNotification::getSomeNotifications($user, 1000);
        $groups = GroupNotification::getSomeNotifications($user, 1000);
        $follow = FollowRequest::getSomeNotifications($user, 1000);

        $notifications = $comments->merge($likes)->merge($groups)->merge($follow)
            ->sortByDesc('timestamp');

        $notifications = $notifications->forPage($page + 1, 10)->values();

        $notifications = $this->translateNotificationsArrayToHtml($notifications);

        return response()->json(['notifications' => $notifications]);
    }
}
