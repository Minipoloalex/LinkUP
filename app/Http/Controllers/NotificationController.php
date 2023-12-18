<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentNotification;
use App\Models\LikeNotification;
use App\Models\GroupNotification;
use App\Models\FollowRequest;

class NotificationController extends Controller
{
    public static int $pagination = 10;

    public function getNotifications()
    {
        $user = auth()->user()->id;
        $comments = CommentNotification::getNotifications($user);
        $likes = LikeNotification::getNotifications($user);
        $groups = GroupNotification::getNotifications($user);
        $follow = FollowRequest::getNotifications($user);

        return $comments->merge($likes)->merge($groups)->merge($follow)->sortByDesc('timestamp');
    }

    public function index(request $request)
    {
        return view('pages.notifications');
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

        $notifications = $this->getNotifications();
        $notifications = $notifications->forPage($page + 1, 10)->values();
        $notifications = $this->translateNotificationsArrayToHtml($notifications);

        return response()->json(['notifications' => $notifications]);
    }
}
