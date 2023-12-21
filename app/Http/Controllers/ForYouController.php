<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ForYouController extends Controller
{
    public function getPostsFromFollowedUsers(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Get IDs of users that the authenticated user is following
        $followingIds = $user->followings()->pluck('id');

        // Get posts from users followed by the authenticated user's followings
        $posts = Post::whereIn('user_id', $followingIds)
                    ->orderBy('created_at', 'desc') // Order by creation date, modify this according to your needs
                    ->paginate(10); // You can adjust the pagination limit

        return response()->json(['posts' => $posts]);
    }
}
