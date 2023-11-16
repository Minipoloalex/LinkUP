<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\PostPolicy;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Displays the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }
    
    public function storePost(Request $request) {
        $request->validate([
            'content' => 'required|max:255',
            // 'id_group' => 'nullable|exists:groups,id'
            'is_private' => 'nullable|boolean'
        ]);
        $post = new Post();
        $this->authorize('createPost', $post);
        
        $post->content = $request->input('content');
        $post->is_private = $request->input('is_private');
        $post->id_created_by = Auth::user()->id;
        $post->save();
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
        error_log($posts->toJson());
        $filteredPosts = $posts->filter(function ($post) {
            return policy(Post::class)->view(Auth::user(), $post);
        });
        error_log($filteredPosts->toJson());
        $filteredPosts->each(function ($post) {
            $post->load('createdBy', 'comments', 'likes');            
        });
        error_log($filteredPosts->toJson());
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
        $post = Post::find($id);
        $request->validate([
            'content' => 'nullable|max:255',
            'is_private' => 'nullable|boolean'
        ]);
        $this->authorize('update', $post);
        
        $post->content = $request->input('content') ?? $post->content;
        $post->is_private = $request->input('is_private') ?? $post->is_private;
        
        $post->save();
        return response()->json($post);
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
        
        // Delete the post and return it as JSON.
        $post->delete();
        return response()->json($post);
        // need to redirect in case of post page
    }
}
