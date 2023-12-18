<?php

namespace App\Http\Controllers;

use App\Models\CommentNotification;
use App\Models\Post;
use App\Models\Liked;
use App\Models\User;
use App\Models\GroupMember;

use \App\Events\CommentEvent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\PostPolicy;
use Illuminate\Http\JsonResponse;
use Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Collection;

class PostController extends Controller
{
    private ImageController $imageController;
    private static int $amountPerPage = 10;
    public function __construct()
    {
        $this->imageController = new ImageController('posts');
    }
    private function validateSizeImage(Request $request)
    {
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $image = $request->media;
            $checkSize = $this->imageController->checkMaxSize($image);
            return $checkSize;
        }
        return false;
    }
    /**
     * Store a newly created post in the database
     */
    public function storePost(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        $validatedSize = $this->validateSizeImage($request);
        if ($validatedSize !== false) {
            return $validatedSize;
        }
        $request->validate([
            'content' => 'required|max:255',
            'id_group' => 'nullable|int|exists:group,id',
            'is_private' => 'nullable|boolean',
            'media' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:10240',
            'x' => 'nullable|int',
            'y' => 'nullable|int',
            'width' => 'nullable|int',
            'height' => 'nullable|int'
        ]);
        $this->authorize('createPost', Post::class);  // user must be logged in

        $user = Auth::user();
        $group_id = $request->input('id_group');


        if ($group_id !== null && !GroupMember::isMember($user, intval($group_id))) {
            return response()->json(['error' => 'You are not a member of this group']);
        }
        $post = new Post();

        $post->content = $request->input('content');
        if ($request->has('is_private')) {
            $post->is_private = $request->input('is_private');
        }
        $post->id_created_by = Auth::user()->id;
        $post->id_group = $group_id;

        $post->save();  // get the post id to make file name unique
        $createdFile = $this->setFileName($request, $post, $request->input('x'), $request->input('y'), $request->input('width'), $request->input('height'));
        if (!$createdFile) {
            $post->created_at = $post->freshTimestamp();
        }

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
        $validatedSize = $this->validateSizeImage($request);
        if ($validatedSize !== false) {
            return $validatedSize;
        }
        $request->validate([
            'content' => 'required|max:255',
            'id_parent' => 'required|exists:post,id',
            'media' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg,mp4|max:10240',
            'x' => 'nullable|int',
            'y' => 'nullable|int',
            'width' => 'nullable|int',
            'height' => 'nullable|int'
        ]);

        $post = Post::findOrFail($request->input('id_parent'));
        $this->authorize('createComment', $post);

        $comment = new Post();

        $comment->content = $request->input('content');
        $comment->is_private = $post->is_private;
        $comment->id_created_by = Auth::user()->id;

        $comment->id_group = $post->id_group;
        $comment->id_parent = $post->id;

        $comment->save();

        $createdFile = $this->setFileName($request, $comment, $request->input('x'), $request->input('y'), $request->input('width'), $request->input('height'));
        if (!$createdFile) {
            $post->created_at = $post->freshTimestamp();
        }
        $commentNotification = CommentNotification::where('id_comment', $comment->id)->firstOrFail();
        event(new CommentEvent($commentNotification));

        $commentHTML = $this->translatePostToHTML($comment, true, true, false, false);
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

        $parent = Post::where('id', $post->id_parent)->first();

        return view('pages.post', [
            'post' => $post,
            'parent' => $parent
        ]);
    }
    /**
     * Returns a query builder with the posts from the given list that are the result of the search query (FTS).
     * Checks if the user can view them.
     */
    public function getSearchResults($posts, string $search, string $type)
    {
        $posts = $this->filterCanView($posts);
        return Post::search($posts, $search);
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
            'query' => 'required|string|max:255',
            'page' => 'required|int'
        ]);
        $page = $request->input('page');

        $posts = $this->filterByType($type);
        $posts = $this->getSearchResults($posts, $request->input('query'), $type);
        $posts = $posts->skip($page * self::$amountPerPage)->limit(self::$amountPerPage);
        $posts = $posts->get();

        if ($posts->isEmpty()) {
            $noResultsHTML = view('partials.search.no_results')->render();
            return response()->json([
                'noResultsHTML' => $noResultsHTML,
                'success' => 'No results found',
                'resultsHTML' => []
            ]);
        }
        $resultsHTML = $this->translatePostsArrayToHTML($posts);
        return response()->json(['resultsHTML' => $resultsHTML, 'success' => 'Search results retrieved']);
    }
    private function filterByType(string $type)
    {
        if ($type == 'comments') {
            return Post::whereNotNull('id_parent');
        } else {
            return Post::whereNull('id_parent');
        }
    }
    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        $validatedSize = $this->validateSizeImage($request);
        if ($validatedSize !== false) {
            Log::debug($validatedSize);
            return $validatedSize;
        }
        $post = Post::findOrFail($id);

        $request->validate([
            'content' => 'nullable|string|max:255',
            'is_private' => 'nullable|boolean',
            'media' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg',
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
     * Returns a query builder with the posts that can be seen by the current user.
     * Supports non authenticated users.
     */
    public function filterCanView($posts)
    {
        if (!Auth::check()) {
            return $posts->where('is_private', false);
        }
        return $posts->where(function ($query) {
            $query->where('is_private', false)->orWhere('id_created_by', Auth::user()->id)->orWhereIn('id_created_by', Auth::user()->following()->pluck('users.id'));
        });
    }

    public function FollowingPosts()
    {
        return Post::whereIn('id_created_by', Auth::user()->following()->pluck('users.id'))->whereNull('id_parent');
    }

    public function getPostsFollowing(Request $request): JsonResponse
    {
        $request->validate([
            'page' => 'required|int'
        ]);
        $page = $request->input('page');
        $posts = $this->FollowingPosts();
        $posts = $this->filterCanView($posts)->orderBy('created_at', 'desc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();

        if ($posts->isEmpty()) {
            $noPostsHTML = view('partials.search.no_results')->render();
            return response()->json([
                'noneHTML' => $noPostsHTML,
                'elementsHTML' => []
            ]);
        }

        $postsHTML = $this->translatePostsArrayToHTML($posts);
        return response()->json(['resultsHTML' => $postsHTML]);
    }

    /**
     * Get all posts created before a given date.
     * @param Request $request must contain a 'page' int parameter
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostsForYou(Request $request): JsonResponse
    {
        $request->validate([
            'page' => 'required|int'
        ]);
        $page = $request->input('page');
        $posts = $this->PersonalizedPosts();
        $posts = $this->filterCanView($posts)->orderBy('created_at', 'desc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();

        $postsHTML = $this->translatePostsArrayToHTML($posts);

        return response()->json(['resultsHTML' => $postsHTML]);
    }

    private function PersonalizedPosts()
    {
        $user = Auth::user();

        /* Unauthenticated user sees random public posts */
        if (!$user) {
            return Post::where('is_private', false);
        }

        /* Authenticated user sees posts from users he follows */
        $following = $user->following->pluck('id');
        $postsFromFollowing = Post::whereIn('id_created_by', $following)->whereNull('id_parent');

        /* And from users followed by users he follows */
        $id = $user->id;
        $followingDistanceTwo = DB::table('follows')
            ->select('id_followed')->whereIn('id_user', function ($query) use ($id) {
                $query->select('id_followed')->from('follows')->where('id_user', $id);
            })->whereNotIn('id_followed', function ($query) use ($id) {
                $query->select('id_followed')->from('follows')->where('id_user', $id);
            })
            ->distinct()->get()->pluck('id_followed');

        $postsFromFollowingDistanceTwo = Post::whereIn('id_created_by', $followingDistanceTwo)->whereNull('id_parent');
        $postsFromFollowingDistanceTwo = $this->filterCanView($postsFromFollowingDistanceTwo);

        /* And from groups he is a member of */
        $groups = $user->groups->pluck('id');
        $postsFromGroups = Post::whereIn('id_group', $groups)->whereNull('id_parent');

        /* Merge all posts */
        $posts = $postsFromFollowing->union($postsFromFollowingDistanceTwo)->union($postsFromGroups);
        $posts = $posts->whereNotNull('id_parent');

        return $posts;
    }

    private function translatePostToHTML(Post $post, bool $isComment, bool $showEdit = false, bool $showAddComment = false, bool $displayComments = false, bool $hasAdminLink = false, bool $hasAdminDelete = false)
    {
        if ($isComment) {
            return view('partials.comment', [
                'comment' => $post,
                'showEdit' => $showEdit,
                'hasAdminLink' => $hasAdminLink,
                'hasAdminDelete' => $hasAdminDelete
            ])->render();
        } else {
            return view('partials.post', [
                'post' => $post,
                'showEdit' => $showEdit,
                'showAddComment' => $showAddComment,
                'displayComments' => $displayComments,
                'hasAdminLink' => $hasAdminLink,
                'hasAdminDelete' => $hasAdminDelete
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
    private function translatePostsArrayToHTML(Collection $posts, bool $isComment = false, bool $showEdit = false, bool $showAddComment = false, bool $displayComments = false, bool $hasAdminLink = false, bool $hasAdminDelete = false)
    {
        $html = $posts->map(function ($post) use ($isComment, $showEdit, $showAddComment, $displayComments, $hasAdminLink, $hasAdminDelete) {
            return $this->translatePostToHTML($post, $isComment, $showEdit, $showAddComment, $displayComments, $hasAdminLink, $hasAdminDelete);
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
    public function toggleLike(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }

        $post = Post::findOrFail($id);
        $user = Auth::user();

        // Check if the user has already liked the post
        $existingLike = Liked::where('id_user', $user->id)->where('id_post', $post->id)->first();

        if ($existingLike) {
            // if post is liked, remove like
            $post->likes()->detach($user->id);
        } else {
            // if post is not liked, add like
            $liked = new Liked();
            $liked->id_user = $user->id;
            $liked->id_post = $post->id;
            $liked->save();
        }

        $post->loadCount('likes'); // Load the count of likes for the post
        $likeCount = $post->likes()->count();

        return response()->json(['count' => $likeCount]);
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

        $post->likes()->detach($user->id);

        $users = Liked::where('id_post', $post->id)->get();

        $post->loadCount('likes');
        $likeCount = $post->likes_count;

        return response()->json([
            'likesCount' => $likeCount,
            'alreadyLiked' => false,
        ]);
    }

    /**
     * Check if a user has liked a post
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function likeStatus(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }

        $user = Auth::user();
        $post = Post::findOrFail($id);

        $alreadyLiked = Liked::where('id_user', $user->id)->where('id_post', $post->id)->exists();

        return response()->json(['alreadyLiked' => $alreadyLiked]);
    }

    public function userPosts(int $id, Request $request)
    {
        Log::debug("userPosts");
        Log::debug($request->all());
        $request->validate([
            'page' => 'required|int'
        ]);
        Log::debug("validated");
        $page = $request->input('page');

        $toView = User::findOrFail($id);
        $this->authorize('viewPosts', $toView);
        $posts = Post::where('id_created_by', $id)
                 ->where(function ($query) {
                     $query->where('is_private', 0) // Filter for public posts
                     ->orWhere('id_created_by', Auth::user()->id); // ; // Include user's own private posts
                 });

        $posts = $this->filterCanView($posts)->orderBy('created_at', 'desc')
            ->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        Log::debug("hello");
        Log::debug($posts);
        $postsHTML = $this->translatePostsArrayToHTML($posts);
        return response()->json(['postsHTML' => $postsHTML]);
    }
    /**
     * Get posts for the For You page
     */
    /*public function forYouPosts()
    {
        $user = Auth::user();
        $usersFollowing = $user->following;
        $userFollowedByUsersFollowing = [];

        foreach($usersFollowing as $x) {
            if(!$x->is_private){
                $userFollowedByUsersFollowing[] = $x->following;
            }
        }

        // remove duplicates from userFollowedByUsersFollowing
        $userFollowedByUsersFollowing = array_unique($userFollowedByUsersFollowing);
 
        $postsForYou = [];

        foreach($userFollowedByUsersFollowing as $user) {
            $postsForYou[] = $x->posts;
        }

        $filteredPosts = $postsForYou->filter(function ($post) use ($user) {
            return policy(Post::class)->view($user, $post);
        })->values();
        Log::info('hey2');
        // Translate posts to the desired HTML format
        $postsHTML = $this->translatePostsArrayToHTML($filteredPosts);
        Log::info('postsHTML: ' . $postsHTML->toJson());
        return response()->json($postsHTML);

        // remove posts that are comments
        /*$postsForYou = array_filter($postsForYou, function($post) {
            return $post->id_parent !== null;
        });*/

    /* SORTING POSTS NOT WORKING
    // sort postsForYou by created_at
    usort($postsForYou, function($a, $b) {
        return $a->created_at <=> $b->created_at;
    });
    
}*/



    public function forYouPosts()
    {
        $user = Auth::user();
        $usersFollowing = $user->following->where('is_private', false)->pluck('id');
        Log::info('usersFollowing: ' . $usersFollowing->toJson());

        $usersFollowedByUserFollowing = User::whereIn('id', $usersFollowing)
            ->with('following')
            ->get()
            ->pluck('following')
            ->flatten()
            ->pluck('id');



        Log::info('usersFollowedByUserFollowing: ' . $usersFollowedByUserFollowing->toJson());

        $postsForYou = Post::whereIn('id_created_by', $usersFollowedByUserFollowing)
            ->with('createdBy:id,username')
            ->withCount('likes')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $postsForYou = Post::whereNotIn('id_created_by', $usersFollowing)
            ->whereIn('id_created_by', $usersFollowedByUserFollowing)
            ->with('createdBy:id,username')
            ->withCount('likes')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        Log::info('postsForYou: ' . $postsForYou->toJson());
        $filteredPosts = $postsForYou->filter(function ($post) use ($user) {
            return policy(Post::class)->view($user, $post);
        })->values();

        // Translate posts to the desired HTML format
        $postsHTML = $this->translatePostsArrayToHTML($filteredPosts);

        return response()->json($postsHTML);
    }

    /*public function followingPosts()
    {
        $user = Auth::user();
        $usersFollowing = $user->following->pluck('id');
        Log::info('usersFollowing: ' . $usersFollowing->toJson());
        

    
        $postsFollowing = Post::whereIn('id_created_by', $usersFollowing)
            ->with('createdBy:id,username')
            ->withCount('likes')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

       
    
        Log::info('postsFollowing: ' . $postsFollowing->toJson());
        
        // Translate posts to the desired HTML format
        $postsHTML = $this->translatePostsArrayToHTML($postsFollowing);
        Log::info('postsHTML: ' . $postsHTML->toJson());
        return response()->json(['postsHTML' => $postsHTML]);
    }*/

    // public function followingPosts()
    // {
    //     $user = Auth::user();
    //     $usersFollowing = $user->following->pluck('id');
    //     Log::info('usersFollowing: ' . $usersFollowing->toJson());

    //     //get posts from users that are followed by the user
    //     $postsFollowing = Post::whereIn('id_created_by', $usersFollowing)
    //         ->with('createdBy:id,username')
    //         ->withCount('likes')
    //         ->orderByDesc('created_at')
    //         ->limit(10)
    //         ->get();

    //     //Translate posts to the desired HTML format
    //     $postsHTML = $this->translatePostsArrayToHTML($postsFollowing);
    //     Log::info('postsHTML: ' . $postsHTML->toJson());
    //     return response()->json($postsHTML);
    // }


    public function groupPosts(int $id, Request $request)
    {
        $request->validate([
            'page' => 'required|int'
        ]);
        $page = $request->input('page');
        $isAdmin = Auth::guard('admin')->check();

        if (!Auth::check() && !$isAdmin) {
            return response()->json(['error' => 'You are not logged in'], 401);
        }
        if (!$isAdmin) {
            // Check if current user is a member of the group
            $user = Auth::user();
            $is_member = GroupMember::where('id_group', $id)->where('id_user', $user->id)->exists();
            if (!$is_member) {
                return response()->json(['error' => 'You are not a member of this group'], 401);
            }
        }
        $posts = Post::where('id_group', $id)->whereNull('id_parent')->orderBy('created_at', 'desc')->skip($page * self::$amountPerPage)->limit(self::$amountPerPage)->get();
        if ($posts->isEmpty()) {
            $noPostsHTML = view('partials.search.no_results')->render();
            return response()->json([
                'noneHTML' => $noPostsHTML,
                'elementsHTML' => []
            ]);
        }
        $postsHTML = $this->translatePostsArrayToHTML($posts, false, false, false, true, $isAdmin, $isAdmin);
        return response()->json(['elementsHTML' => $postsHTML]);
    }

    public function updatePrivacy(Request $request, $postId)
    {
        // Fetch the post
        $post = Post::findOrFail($postId);

        // Check if the authenticated user can edit the post (customize this logic as per your requirements)
        if ($request->user()->id !== $post->createdBy->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        //current privacy 
        Log::info('current privacy: ' . $post->is_private);
        // Toggle the post's privacy
        $post->is_private = !$post->is_private;
        $post->save();
        Log::info('new privacy: ' . $post->is_private);
        return response()->json(['message' => 'Privacy updated', 'is_private' => $post->is_private]);
    }
}
