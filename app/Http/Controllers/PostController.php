<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\PostPolicy;
use Illuminate\Http\JsonResponse;
use Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // public function getPosts() {
    //     $posts = Post::all();
    //     $filteredPosts = $posts->filter(function ($post) {
    //         return policy(Post::class)->view(Auth::user(), $post);
    //     });
    //     $filteredPosts->each(function ($post) {
    //         $post->load('createdBy', 'comments', 'likes');            
    //     });
    //     return response()->json($filteredPosts);
    // }

    /**
     * Displays the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }
    public function storePost(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',
            // 'id_group' => 'nullable|exists:groups,id',
            'is_private' => 'nullable|boolean',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4'
        ]);
        $this->authorize('createPost', Post::class);  // user must be logged in
        $post = new Post();

        $post->content = $request->input('content');
        if ($request->has('is_private'))
            $post->is_private = $request->input('is_private');
        $post->id_created_by = Auth::user()->id;

        $post->save();  // get the post id to make file name unique

        $this->setFileName($request, $post);

        Log::info("created post $post->toJson()");    // check if post is updated from setFileName
        $post->load('createdBy', 'comments', 'likes');
        return response()->json($post);
    }

    /**
     * Store a newly created comment in the DB.
     */
    public function storeComment(Request $request)
    {
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
    public function search(string $search)
    {
        $posts = Post::search($search);
        $filteredPosts = $posts->filter(function ($post) {
            return policy(Post::class)->view(Auth::user(), $post);
        });
        $filteredPosts->each(function ($post) {
            $post->load('createdBy', 'comments', 'likes');
        });
        return response()->json($filteredPosts);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, string $id)
    {
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
        Log::info($request->all());
        if ($request->has('media') && $request->file('media')->isValid()) {
            $this->deleteFile($post->media);
            $this->setFileName($request, $post);
            $hasNewMedia = true;
        }

        Log::info("updated post " . $post->toJson());

        return response()->json(compact('post', 'hasNewMedia'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
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
        return response()->json($post);
    }
    public function viewImage(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('view', $post);

        $fileName = $post->media;
        if (!ImageController::existsFile($fileName)) {
            abort(404);
        }
        return ImageController::getFile($fileName);
    }
    public function deleteImage(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);

        $this->deleteFile($post->media);
        $post->media = null;
        $post->save();
    }
    private function setFileName(Request $request, Post $post)
    {
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $fileName = "media_post_" . $post->id . '.' . $request->media->extension();
            ImageController::store($request->media, $fileName);
            $post->media = $fileName;
            $post->save();
        }
    }
    private function deleteFile(?string $fileName)
    {
        if ($fileName != null) {
            ImageController::delete($fileName);
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
