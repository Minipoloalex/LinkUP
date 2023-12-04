<?php

namespace App\Http\Controllers;

use App\Models\CommentNotification;
use App\Models\Post;
use App\Models\Liked;
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
        Log::debug("storePost");
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        Log::debug("Authenticated, going to validate");
        $request->validate([
            'content' => 'required|max:255',
            // 'id_group' => 'nullable|exists:groups,id',
            'is_private' => 'nullable|boolean',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg',
            'x' => 'nullable|int',
            'y' => 'nullable|int',
            'width' => 'nullable|int',
            'height' => 'nullable|int'
        ]);
        Log::debug("Validated, going to create post");
        $this->authorize('createPost', Post::class);  // user must be logged in
        DB::beginTransaction();
        $post = new Post();

        $post->content = $request->input('content');
        if ($request->has('is_private')) {
            $post->is_private = $request->input('is_private');
        }
        $post->id_created_by = Auth::user()->id;

        $post->save();  // get the post id to make file name unique
        Log::debug("Created new post");
        $createdFile = $this->setFileName($request, $post, $request->input('x'), $request->input('y'), $request->input('width'), $request->input('height'));
        if (!$createdFile) {
            $post->created_at = $post->freshTimestamp();
        }
        DB::commit();
        Log::debug('post: ' . $post->toJson());

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
    public function searchPosts(Request $request)
    {
        return $this->search($request, 'posts');
    }
    public function searchComments(Request $request)
    {
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
    private function filterByType($allPosts, string $type)
    {
        if ($type == 'comments') {
            $comments = $allPosts->filter(function ($post) {
                // has parent post and not created by authenticated user
                return $post->id_parent !== null && (!Auth::check() || $post->id_created_by != Auth::user()->id);
            })->values();
            return $comments;
        } else {
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
            'content' => 'nullable|string|max:255',
            'is_private' => 'nullable|boolean',
            'media' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg',
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
            $this->deleteFile($post->id);
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

        $this->deleteFile($post->id);

        // Delete the post and return it as JSON.
        $post->delete();
        $post->success = 'Post deleted successfully!';
        return response()->json($post);
    }
    public function viewImage(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('view', $post);

        $fileName = $this->imageController->getFileNameWithExtension(str($post->id));
        if (!$this->imageController->existsFile($fileName)) {
            return response()->json(['error' => 'A post image was not found'], 404);
        }
        return $this->imageController->getFileResponse($fileName);
    }
    public function deleteImage(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);

        $this->deleteFile($post->id);
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
            $fileName = $this->imageController->getFileNameWithExtension(str($post->id));
            $this->imageController->store($request->media, $fileName, $x, $y, $width, $height);
            $post->save();
            return true;
        }
        return false;
    }
    private function deleteFile(int $postId)
    {
        $fileName = $this->imageController->getFileNameWithExtension(str($postId));
        $this->imageController->delete($fileName);
    }
    /**
     * Get all posts created before a given date.
     * @param string $date
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getPostsBeforeDate(string $date): JsonResponse
    {
        Log::debug('user: ' . Auth::user());
        Log::debug('date: ' . $date);
        $posts = Post::where('created_at', '<', $date)->where('id_parent', null)->orderBy('created_at', 'desc')->limit(10)->get();
        Log::debug('posts: ' . $posts);

        $filteredPosts = $posts->filter(function ($post) {
            return policy(Post::class)->view(Auth::user(), $post);
        })->values();

        Log::info('filtered posts: ' . $filteredPosts->toJson());

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

    /**
     * Update likes on a post
     * Add like on a post
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function addLike(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }

        Log::info("trying to like post");

        $post = Post::findOrFail($id);
        $request->validate([
            'like' => 'required|boolean'
        ]);

        $like = $request->input('like');
        $user = Auth::user();

        // Check if the user has already liked the post
        $existingLike = Liked::where('id_user', $user->id)->where('id_post', $post->id)->first();
        Log::info("existing like: $existingLike");

        if ($existingLike == null) { // if its null, we can create a new like
            Log::info("existing like is null");
            $liked = new Liked();
            $liked->id_user = $user->id;
            $liked->id_post = $post->id;
            $liked->save();
            Log::info("User $user->id liked post $post->id");
        } else { // if its not null
            Log::info("existing like is not null");
            Log::info("User $user->id already liked post $post->id");
        }

        //log all users who liked a post
        $users = Liked::where('id_post', $post->id)->get();
        Log::info("users who liked post $post->id: $users");

        $post->loadCount('likes'); // Load the count of likes for the post
        $likeCount = $post->likes()->count();

        return response()->json([
            'likesCount' => $likeCount,
            'alreadyLiked' => true, // 
        ]);

    }

    /**
     * Remove like on a post
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function removeLike(Request $request, string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }

        $post = Post::findOrFail($id);

        // Detach the relationship between the user and the post
        $post->likes()->detach($user->id);
        Log::info("User $user->id unliked post $post->id");
        //users who liked a post
        $users = Liked::where('id_post', $post->id)->get();

        $post->loadCount('likes');
        $likeCount = $post->likes_count;

        return response()->json([
            'likesCount' => $likeCount,
            'alreadyLiked' => false,
        ]);
    }

    public function likeStatus(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }

        $user = Auth::user();
        $post = Post::findOrFail($id);

        $alreadyLiked = Liked::where('id_user', $user->id)->where('id_post', $post->id)->exists();

        Log::info("User $user->id already liked post $post->id: $alreadyLiked");

        return response()->json(['alreadyLiked' => $alreadyLiked]);
    }
}
