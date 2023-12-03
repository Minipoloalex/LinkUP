<?php

namespace App\Http\Controllers;

use App\Models\CommentNotification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\PostPolicy;
use Illuminate\Http\JsonResponse;
use Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Collection;
use \App\Events\CommentEvent;

class PostController extends Controller
{
    private $imageController;
    public function __construct()
    {
        $this->imageController = new ImageController('posts');
    }
    /**
     * Store a newly created post in the database
     */
    public function storePost(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        $request->validate([
            'content' => 'required|max:255',
            // 'id_group' => 'nullable|exists:groups,id',
            'is_private' => 'nullable|boolean',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4',
            'x' => 'nullable|int',
            'y' => 'nullable|int',
            'width' => 'nullable|int',
            'height' => 'nullable|int'
        ]);
        $this->authorize('createPost', Post::class);  // user must be logged in
        DB::beginTransaction();
        $post = new Post();

        $post->content = $request->input('content');
        if ($request->has('is_private')) {
            $post->is_private = $request->input('is_private');
        }
        $post->id_created_by = Auth::user()->id;

        $post->save();  // get the post id to make file name unique

        $createdFile = $this->setFileName($request, $post,  $request->input('x'), $request->input('y'), $request->input('width'), $request->input('height')); // TODO
        if (!$createdFile) {
            $post->media = null;
            $post->created_at = $post->freshTimestamp();
        }
        DB::commit();

        $postHTML = $this->translatePostToHTML($post, false, false, false);
        return response()->json(['postHTML' => $postHTML, 'success' => 'Post created successfully!']);
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
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4',
            'x' => 'nullable|int',
            'y' => 'nullable|int',
            'width' => 'nullable|int',
            'height' => 'nullable|int'
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

        $createdFile = $this->setFileName($request, $comment, $request->input('x'), $request->input('y'), $request->input('width'), $request->input('height'));
        if (!$createdFile) {
            $comment->media = null;
            $post->created_at = $post->freshTimestamp();
        }
        $commentNotification = CommentNotification::where('id_comment', $comment->id)->firstOrFail();
        event(new CommentEvent($commentNotification));

        $commentHTML = $this->translatePostToHTML($comment, true, true, false);
        return response()->json(['commentHTML' => $commentHTML, 'success' => 'Comment created successfully!']);
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
    public function searchPosts(Request $request) {
        return $this->search($request, 'posts');
    }
    public function searchComments(Request $request) {
        return $this->search($request, 'comments');
    }
    /**
     * Returns the search results for a given query for AJAX requests.
     */
    public function search(Request $request, string $type)
    {
        $request->validate([
            'query' => 'required|string|max:255'
        ]);
        $posts = $this->getSearchResults($request->input('query'));
        $filtered = $this->filterByType($posts, $type);
        if ($filtered->isEmpty()) {
            $noResultsHTML = view('partials.search.no_results')->render();
            return response()->json([
                'noResultsHTML' => $noResultsHTML,
                'success' => 'No results found',
                'resultsHTML' => []
            ]);
        }
        $resultsHTML = $this->translatePostsArrayToHTML($filtered);
        return response()->json(['resultsHTML' => $resultsHTML, 'success' => 'Search results retrieved']);
    }
    private function filterByType($allPosts, string $type) {
        if ($type == 'comments') {
            $comments = $allPosts->filter(function ($post) {
                // has parent post and not created by authenticated user
                return $post->id_parent !== null && (!Auth::check() || $post->id_created_by != Auth::user()->id);
            })->values();
            return $comments;
        }
        else {
            $posts = $allPosts->filter(function ($post) {
                // no parent post and not created by authenticated user
                return $post->id_parent === null && (!Auth::check() || $post->id_created_by != Auth::user()->id);
            })->values();
            return $posts;
        }
    }
    /**
     * Display the search results page for a given query.
     */
    public function searchResults(Request $request)
    {
        $request->validate([
            'query' => 'required|max:255'
        ]);
        $posts = $this->getSearchResults($request->input('query'));

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
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,mp4',
            'x' => 'nullable|int',
            'y' => 'nullable|int',
            'width' => 'nullable|int',
            'height' => 'nullable|int'
        ]);
        // media -> can change, add or maintain (null) (cannot delete -> check deleteImage for that)
        $this->authorize('update', $post);

        $post->content = $request->input('content') ?? $post->content;
        $post->is_private = $request->input('is_private') ?? $post->is_private;

        $post->save();

        $hasNewMedia = false;
        if ($request->has('media') && $request->file('media')->isValid()) {
            $this->deleteFile($post->media);
            $this->setFileName($request, $post, $request->input('x'), $request->input('y'), $request->input('width'), $request->input('height'));
            $hasNewMedia = true;
        }

        if ($hasNewMedia) {
            $postImageHTML = $this->getPostImageHTML($post);

            return response()->json([
                'postImageHTML' => $postImageHTML,
                'success' => 'Post updated successfully!',
                'hasNewMedia' => true
            ]);
        }

        return response()->json(['success' => 'Post updated successfully!']);
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
    /**
     * Set the media file name for a post.
     * @param Request $request
     * @param Post $post
     * @return bool true if the file name was set, false otherwise (if there was no file)
     */
    private function setFileName(Request $request, Post $post, ?int $x, ?int $y, ?int $width, ?int $height): bool
    {
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $fileName = "media_post_" . $post->id . '.' . $request->media->extension();
            $this->imageController->store($request->media, $fileName, $x, $y, $width, $height);
            $post->media = $fileName;
            $post->save();
            return true;
        }
        return false;
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
        $posts = Post::whereDate('created_at', '<', $date)->where('id_parent', null)->orderBy('created_at', 'desc')->limit(10)->get();

        $filteredPosts = $posts->filter(function ($post) {
            return policy(Post::class)->view(Auth::user(), $post);
        });
        $postsHTML = $this->translatePostsArrayToHTML($filteredPosts);
        
        return response()->json($postsHTML);
    }
    private function translatePostToHTML(Post $post, bool $isComment, bool $showEdit = false, bool $displayComments = false)
    {
        if ($isComment) {
            return view('partials.comment', ['comment' => $post, 'showEdit' => $showEdit])->render();
        } else {
            return view('partials.post', [
                'post' => $post,
                'showEdit' => $showEdit,
                'displayComments' => $displayComments
            ])->render();
        }
    }
    /**
     * Given an array of (Post::class) posts, returns the HTML code to display them.
     * Does not translate comments to HTML.
     * Used to display a list of posts, without displaying their comments and without the option to edit them.
     * @param Collection $posts
     * @return Collection HTML code to display the posts
     */
    private function translatePostsArrayToHTML(Collection $posts)
    {
        $html = $posts->map(function ($post) {
            return $this->translatePostToHTML($post, false, false, false);
        });
        return $html;
    }
    /**
     * Returns the HTML code to display the image of a post. The post must have an image.
     * Used in the edit post, so this image is always editable (can be deleted).
     * @param Post $post
     */
    private function getPostImageHTML(Post $post)
    {
        return view('partials.post_image', ['post' => $post, 'editable' => true])->render();
    }
}
