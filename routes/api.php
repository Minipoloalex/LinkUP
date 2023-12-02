<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

// define a route for /posts which accepts a GET request with a DATE parameter
Route::get(
    '/posts/{date}',
    [PostController::class, 'getPostsBeforeDate']
)->name('posts.beforeDate');

Route::get(
    '/posts/search',
    [PostController::class, 'search']
)->name('post.search');
Route::get(
    '/users/search',
    [UserController::class, 'search']
)->name('users.search');
