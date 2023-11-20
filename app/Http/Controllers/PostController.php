<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Log;

class PostController extends Controller
{
    /**
     * Get all posts created before a given date.
     * @param string $date
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getPostsBeforeDate(string $date): JsonResponse
    {
        $date = "2024-01-01"; // TODO: remove this line

        $posts = Post::whereDate('created_at', '<', $date)->orderBy('created_at', 'desc')->limit(10)->get();

        $filteredPosts = $posts->filter(function ($post) {
            return policy(Post::class)->view(Auth::user(), $post);
        });

        $filteredPosts->each(function ($post) {
            $post->load('createdBy', 'comments', 'likes');
        });

        return response()->json($filteredPosts);
    }
}
