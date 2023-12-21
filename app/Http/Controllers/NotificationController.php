<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentNotification;
use App\Models\LikeNotification;
use App\Models\GroupNotification;
use App\Models\FollowRequest;

use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public static int $pagination = 10;

    public function getNotifications()
    {
        $user = auth()->user()->id;
        $follow = FollowRequest::getNotifications($user);
        $groups = GroupNotification::getNotifications($user);
        $comments = CommentNotification::getNotifications($user);
        $likes = LikeNotification::getNotifications($user);

        return $comments->merge($likes)->merge($groups)->merge($follow)->sortByDesc('timestamp');
    }

    public function index(request $request)
    {
        return view('pages.notifications', ['notifications' => $this->getNotifications()]);
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

        $notificationsHTML = $this->translateNotificationsArrayToHtml($notifications);

        // mark notifications as seen as they are sent to the user
        foreach ($notifications as $notification) {
            if ($notification->getType() === 'follow-request') {
                continue;
            }

            $notification->update(['seen' => true]);

            /**
             * For some reason, comment notifications specifically were not being marked as seen
             * So we make a DB Query to mark them as seen
             */
            if (class_basename($notification) === 'CommentNotification') {
                \DB::table('comment_notification')->where('id_comment', $notification->id_comment)->update(['seen' => true]);
            }
        }

        return response()->json(['notifications' => $notificationsHTML]);
    }
}
