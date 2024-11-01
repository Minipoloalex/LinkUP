<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SuggestionController;

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
        '/users/search',        // query parameter
        [UserController::class, 'search']
    )->name('users.search');
    Route::get(
        '/groups/search',       // query parameter
        [GroupController::class, 'search']
    )->name('groups.search');

    Route::get(
        '/profile/{id}/posts',  // page query parameter
        [PostController::class, 'userPosts']
    )->where('id', '[0-9]+')->name('profile.posts');
    Route::get(
        '/group/{id}/posts', // page query parameter
        [PostController::class, 'groupPosts']
    )->where('id', '[0-9]+')->name('group.posts');
    Route::get(
        '/group/{id}/members', // page query parameter
        [UserController::class, 'groupMembers']
    )->where('id', '[0-9]+')->name('group.members');

    Route::get(
        '/posts/for-you',
        [PostController::class, 'getPostsForYou']
    )->name('posts.for-you');

    Route::get(
        '/posts/following',
        [PostController::class, 'getPostsFollowing']
    )->name('posts.following');

    Route::get(
        '/notifications',
        [NotificationController::class, 'getUserNotifications']
    )->name('api.notifications');

    Route::get(
        '/suggestions',
        [SuggestionController::class, 'getUserSuggestions']
    )->name('suggestions');

    Route::get(
        '/users/picture/{id}',
        [UserController::class, 'getProfilePicture']
    )->name('users.picture');

    Route::get(
        '/users/{id}',
        [UserController::class, 'getUserObject']
    )->name('users.object');
});
