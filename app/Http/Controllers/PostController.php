<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\PostPolicy;
use Illuminate\Http\JsonResponse;
use Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ImageController;

class PostController extends Controller
{
    private $imageController;
    public function __construct()
    {
        $this->imageController = new ImageController('posts');
    }
    public function storePost(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        $request->validate([
            'content' => 'required|max:255',
            // 'id_group' => 'nullable|exists:groups,id',
            'is_private' => 'nullable|boolean',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4'
        ]);
        $this->authorize('createPost', Post::class);  // user must be logged in
        DB::beginTransaction();
        $post = new Post();

        $post->content = $request->input('content');
        if ($request->has('is_private'))
            $post->is_private = $request->input('is_private');
        $post->id_created_by = Auth::user()->id;

        $post->save();  // get the post id to make file name unique

        $this->setFileName($request, $post);
        DB::commit();

        $post->load('createdBy', 'comments', 'likes');
        
        $post->success = 'Post created successfully!';
        return response()->json($post);
    }

    /**
     * Store a newly created comment in the DB.
     */
    public function storeComment(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        $request->validate([
            'content' => 'required|max:255',
            'id_parent' => 'required|exists:post,id',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4'
            // 'id_group' => 'nullable|exists:groups,id'
        ]);

        $post = Post::find($request->input('id_parent'));
        $this->authorize('createComment', $post);

        $comment = new Post();

        $comment->content = $request->input('content');
        $comment->is_private = $post->is_private;
        $comment->id_created_by = Auth::user()->id;

        $comment->id_parent = $request->input('id_parent');

        $comment->save();

        $this->setFileName($request, $comment);
        Log::info("created comment $comment->toJson()");

        $comment->load('createdBy', 'comments', 'likes');
        $comment->success = 'Comment created successfully!';
        return response()->json($comment);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the post.
        $post = Post::findOrFail($id);

        // Check if the current user can see (show) the post.
        $this->authorize('view', $post);

        // Use the pages.post template to display the post.
        return view('pages.post', [
            'post' => $post
        ]);
    }
    public function getSearchResults(string $search)
    {
        $posts = Post::search($search);
        $filteredPosts = $posts->filter(function ($post) {
            return policy(Post::class)->view(Auth::user(), $post);
        });
        $filteredPosts->each(function ($post) {
            $post->load('createdBy', 'comments', 'likes');
        });
        return $filteredPosts;
    }
    public function search(string $search)
    {
        $posts = $this->getSearchResults($search);
        $posts->success = 'Search results retrieved';
        return response()->json($posts);
    }
    public function searchResults(Request $request)
    {
        $request->validate([
            'query' => 'required|max:255'
        ]);
        $posts = $this->getSearchResults($request->input('query'));
        Log::info($posts->toJson());
        return view('pages.search', ['posts' => $posts, 'success' => 'Search results retrieved']);
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        $post = Post::findOrFail($id);
        $request->validate([
            'content' => 'nullable|max:255',
            'is_private' => 'nullable|boolean',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4'
        ]);
        // media -> can change, add or maintain (null) (cannot delete)
        $this->authorize('update', $post);

        $post->content = $request->input('content') ?? $post->content;
        $post->is_private = $request->input('is_private') ?? $post->is_private;

        $post->save();

        $hasNewMedia = false;
        if ($request->has('media') && $request->file('media')->isValid()) {
            $this->deleteFile($post->media);
            $this->setFileName($request, $post);
            $hasNewMedia = true;
        }
        $post->hasNewMedia = $hasNewMedia;
        $post->success = 'Post updated successfully!';
        return response()->json($post);
    }
    /**
     * Delete a post.
     */
    public function delete(Request $request, string $id)
    {
        // Find the post.
        $post = Post::find($id);

        // Check if the current user is authorized to delete this post.
        $this->authorize('delete', $post);

        $this->deleteFile($post->media);

        // Delete the post and return it as JSON.
        $post->delete();
        $post->success = 'Post deleted successfully!';
        return response()->json($post);
    }
    public function viewImage(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('view', $post);

        $fileName = $post->media;
        if (!$this->imageController->existsFile($fileName)) {
            abort(404);
        }
        return $this->imageController->getFileResponse($fileName);
    }
    public function deleteImage(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);

        $this->deleteFile($post->media);
        $post->media = null;
        $post->save();
        $post->success = 'Post image deleted successfully!';
        return response()->json($post);
    }
    private function setFileName(Request $request, Post $post)
    {
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $fileName = "media_post_" . $post->id . '.' . $request->media->extension();
            $this->imageController->store($request->media, $fileName);
            $post->media = $fileName;
            $post->save();
        }
    }
    private function deleteFile(?string $fileName)
    {
        if ($fileName != null) {
            $this->imageController->delete($fileName);
        }
    }
    /**
     * Get all posts created before a given date.
     * @param string $date
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getPostsBeforeDate(string $date): JsonResponse
    {
        $date = "2024-01-01"; // TODO: remove this line

        $posts = Post::whereDate('created_at', '<', $date)->where('id_parent', null)->orderBy('created_at', 'desc')->limit(10)->get();


        $filteredPosts = $posts->filter(function ($post) {
            return policy(Post::class)->view(Auth::user(), $post);
        });

        $filteredPosts->each(function ($post) {
            $post->load('createdBy', 'comments', 'likes');
        });

        return response()->json($filteredPosts);
    }
}
