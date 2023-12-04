<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Root
Route::redirect('/', '/home');

Route::get('/home', function () {
    return view('pages.home');
})->name('home');


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});


// Admin
Route::prefix('/admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/login');

    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'authenticate']);
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'listUsers'])->name('users');
        Route::post('/users/{id}/ban', [AdminController::class, 'banUser'])->name('users.ban');
        Route::post('/users/{id}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');
        Route::get('/posts', [AdminController::class, 'listPosts'])->name('posts');
        Route::get('/create', [AdminController::class, 'showCreateForm'])->name('create');
        Route::post('/create', [AdminController::class, 'createAdmin']);

    });
});


// Post
Route::controller(PostController::class)->group(function () {
    Route::get('/post/{id}', 'show')->name('post');
    Route::get('/post/{id}/image', 'viewImage')->name('post.image');

    Route::post('/post', 'storePost');
    Route::post('/comment', 'storeComment');

    Route::delete('/post/{id}', 'delete');
    Route::delete('/post/{id}/image', 'deleteImage');

    Route::put('/post/{id}', 'update');

    Route::get('/search', 'searchResults');

    // Like routes
    Route::post('/post/{id}/like', 'addLike'); // add like
    Route::delete('/post/{id}/like', 'removeLike'); // remove like
    Route::get('/post/{id}/like', 'likeStatus');  // get like status

});

// Groups
Route::controller(GroupController::class)->group(function () {
    Route::get('/group/{id}', 'show')->name('group');
    Route::get('/group/{id}/settings', 'settings')->name('group.settings');

    Route::post('/group', 'createGroup')->name('group.create');
    Route::post('/group/{id}/join', 'joinRequest')->name('group.join');
    Route::post('/group/{id}/request/{member_id}', 'resolveRequest')->name('group.resolveRequest');
    Route::post('/group/verify-password', 'verifyPassword')->name('group.verifyPassword');
    Route::put('/group/{id}/update', 'update')->name('group.update');


    Route::delete('/group/{id}/join', 'cancelJoinRequest')->name('group.cancelJoin');
    Route::put('/group/{id}', 'update')->name('group.update');

    Route::delete('/group/{id}', 'delete')->name('group.delete');
    Route::delete('/group/{id}/member/{member_id}', 'deleteMember');
})->middleware('auth');

// profile page
Route::get('/profile/{username}', [UserController::class, 'showProfile'])->name('profile.show');
Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
Route::get('profile/photo/{id}', [UserController::class, 'viewProfilePicture'])->name('profile.photo');

Route::get('network/{username}', [UserController::class, 'showNetwork'])->name('profile.network');

Route::delete('follow/follower/{id}', [UserController::class, 'removeFollower'])->where('id', '[0-9]+');
Route::delete('follow/following/{id}', [UserController::class, 'removeFollowing'])->where('id', '[0-9]+');
Route::delete('follow/request/cancel/{id}', [UserController::class, 'cancelRequestToFollow'])->where('id', '[0-9]+');
Route::delete('follow/request/deny/{id}', [UserController::class, 'denyFollowRequest'])->where('id', '[0-9]+');
Route::patch('follow/request/accept/{id}', [UserController::class, 'acceptFollowRequest'])->where('id', '[0-9]+');
Route::post('follow', [UserController::class, 'requestFollow']);

Route::get('/settings', [UserController::class, 'showSettings'])->name('settings.show');
Route::post('/settings/update', [UserController::class, 'updateSettings'])->name('settings.update');



/* route for about us page */
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

/* route for contact us page */
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');