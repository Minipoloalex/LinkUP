<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\StaticPageController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\AdminController;


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

// Static pages
Route::controller(StaticPageController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/features', 'features')->name('features');
});

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


// Password recovery
Route::group(['middleware' => 'guest'], function () {
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'showLinkRequestForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('/reset-password', 'reset')->name('password.update');
    });
});


// Admin
Route::prefix('/admin')->name('admin.')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/users', [AdminController::class, 'listUsers'])->name('users');
        Route::get('/api/users', [AdminController::class, 'searchUsers'])->name('api.users');
        Route::get('/profile/{username}', [AdminController::class, 'viewUser'])->name('user');
        Route::get('/network/{username}', [AdminController::class, 'viewNetwork'])->name('user.network');
        Route::post('/users/{id}/ban', [AdminController::class, 'banUser'])->name('users.ban');
        Route::post('/users/{id}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');

        Route::get('/posts', [AdminController::class, 'listPosts'])->name('posts');
        Route::get('/post/{id}', [AdminController::class, 'viewPost'])->name('post');
        Route::get('/api/posts', [AdminController::class, 'searchPosts'])->name('api.posts');
        Route::delete('/post/{id}', [AdminController::class, 'deletePost'])->name('posts.delete');

        Route::get('/groups', [AdminController::class, 'listGroups'])->name('groups');
        Route::get('/group/{id}', [AdminController::class, 'viewGroup'])->name('group');
        Route::get('/api/groups', [AdminController::class, 'searchGroups'])->name('api.posts');
        Route::post('/group/{id}/delete', [AdminController::class, 'deleteGroup'])->name('groups.delete');

        Route::get('/create', [AdminController::class, 'showCreateForm'])->name('create');
        Route::post('/create', [AdminController::class, 'createAdmin']);
    });
});


// Post
Route::controller(PostController::class)->group(function () {
    Route::get('/post/{id}', 'show')->name('post')->where('id', '[0-9]+');
    Route::get('/post/{id}/image', 'viewImage')->name('post.image')->where('id', '[0-9]+');

    Route::post('/post/{postId}/privacy', 'updatePrivacy');
    Route::post('/post', 'storePost');
    Route::post('/comment', 'storeComment');

    Route::delete('/post/{id}', 'delete')->where('id', '[0-9]+');
    Route::delete('/post/{id}/image', 'deleteImage')->where('id', '[0-9]+');

    Route::put('/post/{id}', 'update')->where('id', '[0-9]+');

    // Like routes
    Route::post('/post/{id}/like', 'toggleLike'); // add like
    Route::get('/post/{id}/like', 'likeStatus');  // get like status

    Route::get('/foryou', 'forYouPosts'); // get for you posts
    Route::get('/followingGet', 'followingPosts'); // get following posts


});

// Groups
Route::controller(GroupController::class)->group(function () {
    Route::get('/group/create', 'showCreateForm')->name('group.create');
    Route::post('/group/create', 'createGroup');

    Route::get('/group/{id}', 'show')->name('group.show');
    Route::get('/group/{id}/settings', 'settings')->name('group.settings');

    Route::post('/group/{id}/join', 'joinRequest')->name('group.join');
    Route::post('/group/{id}/request/{member_id}', 'resolveRequest')->name('group.resolveRequest');
    Route::post('/group/verify-password', 'verifyPassword')->name('group.verifyPassword');
    Route::put('/group/{id}/update', 'update')->name('group.update');
    Route::post('/group/{id}/change-owner', 'changeOwner')->name('group.changeOwner');

    Route::delete('/group/{id}/join', 'cancelJoinRequest')->name('group.cancelJoin');

    Route::delete('/group/{id}', 'delete')->name('group.delete');
    Route::delete('/group/{id}/member/{member_id}', 'deleteMember');
})->middleware('auth');

// profile page
Route::get('profile/edit', [UserController::class, 'showEditProfile'])->name('profile.edit');
Route::post('profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

Route::get('/profile/{username}', [UserController::class, 'showProfile'])->name('profile.show');
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
Route::post('/settings/delete', [UserController::class, 'deleteAccount'])->name('settings.delete');
Route::post('/settings/confirm-password', [UserController::class, 'confirmPassword'])->name('settings.confirmPassword');

Route::get('/search', function () {
    return view('pages.search');
})->name('search');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications')->middleware('auth');
/* route for for-you.blade.php */
Route::get('/for-you', function () {
    return view('pages.foryou');
})->name('for-you');

/* route for following.blade.php */
Route::get('/following', function () {
    return view('pages.following');
})->name('following');