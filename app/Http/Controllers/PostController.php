<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Creates a new post
     */
    public function create(Request $request)
    {
        $post = new Post();
        $this->authorize('create', $post);

        $post->content = $request->input('content');
        $post->is_private = $request->input('is_private');
        $post->id_created_by = Auth::user()->id;

        // id_parent and id_group not yet handled (will be NULL)

        $post->save();
        return response()->json($post);
        // return redirect()->route('home');    // maybe redirect to the post
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post();
        $this->authorize('create', $post);

        $post->content = $request->input('content');
        $post->is_private = $request->input('is_private');
        $post->id_created_by = Auth::user()->id;

        // id_parent and id_group not yet handled (will be NULL)

        $post->save();
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the post.
        $post = Post::findOrFail($id);

        // Check if the current user can see (show) the card.
        $this->authorize('show', $post);  

        // Use the pages.card template to display the card.
        return view('pages.post', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
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
    public function delete(Request $request, $id)
    {
        // Find the post.
        $post = Post::find($id);

        // Check if the current user is authorized to delete this post.
        $this->authorize('delete', $post);

        // Delete the post and return it as JSON.
        $post->delete();
        return response()->json($post);
    }
}
