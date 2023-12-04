<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get(
        '/posts/followed-users', // Define the endpoint for fetching posts from followed users
        [ForYouController::class, 'getPostsFromFollowedUsers']
    )->name('posts.followedUsers');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/foryou/posts', [ForYouController::class, 'getPostsFromFollowedUsers']);
    // You can add more routes related to the "For You" functionality here
});

Route::middleware('web')->group(function () {
    Route::get(
        '/posts/search',        // query parameter
        [PostController::class, 'searchPosts']
    )->name('post.search');
    Route::get(
        '/comments/search',     // query parameter
        [PostController::class, 'searchComments']
    )->name('comment.search');
    Route::get(
        '/users/search',
        [UserController::class, 'search']
    )->name('users.search');
    Route::get(
        '/groups/search',
        [GroupController::class, 'search']
    )->name('groups.search');

    Route::get(     // define a route for /posts which accepts a GET request with a DATE parameter
        '/posts/{date}',
        [PostController::class, 'getPostsBeforeDate']
    )->name('posts.beforeDate');
});


