<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaticPageController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;

use App\Http\Controllers\NotificationController;

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

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Static pages
Route::controller(StaticPageController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/features', 'features')->name('features');
});

// Search
Route::get('/search', function () {
    return view('pages.search');
})->name('search');

// Authentication
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::group(['middleware' => 'guest'], function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'authenticate');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'showRegistrationForm')->name('register');
        Route::post('/register', 'register');
    });

    // Password recovery
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'showLinkRequestForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('/reset-password', 'reset')->name('password.update');
    });
});

// User
Route::controller(UserController::class)->group(function () {

    // profile page
    Route::get('/profile/edit', 'showEditProfile')->name('profile.edit');
    Route::post('/profile/update', 'updateProfile')->name('profile.update');
    Route::get('/profile/{username}', 'showProfile')->name('profile.show');
    Route::get('/profile/photo/{id}', 'viewProfilePicture')->where('id', '[0-9]+')->name('profile.photo');

    // network
    Route::get('/network/{username}', 'showNetwork')->name('profile.network');
    Route::delete('/follow/follower/{id}', 'removeFollower')->where('id', '[0-9]+');
    Route::delete('/follow/following/{id}', 'removeFollowing')->where('id', '[0-9]+');
    Route::delete('/follow/request/cancel/{id}', 'cancelRequestToFollow')->where('id', '[0-9]+');
    Route::delete('/follow/request/deny/{id}', 'denyFollowRequest')->where('id', '[0-9]+');
    Route::patch('/follow/request/accept/{id}', 'acceptFollowRequest')->where('id', '[0-9]+');
    
    Route::post('/follow', 'requestFollow');

    // settings
    Route::get('/settings', 'showSettings')->name('settings.show');
    Route::post('/settings/update', 'updateSettings')->name('settings.update');
    Route::post('/settings/delete', 'deleteAccount')->name('settings.delete');
    Route::post('/settings/confirm-password', 'confirmPassword')->name('settings.confirmPassword');

});

// Post
Route::controller(PostController::class)->group(function () {
    Route::get('/post/{id}', 'show')->name('post')->where('id', '[0-9]+');
    Route::get('/post/{id}/image', 'viewImage')->name('post.image')->where('id', '[0-9]+');
    Route::patch('/post/{postId}/privacy', 'updatePrivacy')->where('postId', '[0-9]+');;
    Route::post('/post', 'storePost');
    Route::post('/comment', 'storeComment');
    Route::delete('/post/{id}', 'delete')->where('id', '[0-9]+');
    Route::delete('/post/{id}/image', 'deleteImage')->where('id', '[0-9]+');
    Route::put('/post/{id}', 'update')->where('id', '[0-9]+');
    Route::post('/post/{id}/like', 'toggleLike')->where('id', '[0-9]+'); // like or unlike
});

// Group
Route::controller(GroupController::class)->group(function () {
    Route::get('/group/create', 'showCreateForm')->name('group.create');
    Route::post('/group/create', 'createGroup');
    Route::get('/group/{id}', 'show')->where('id', '[0-9]+')->name('group.show');
    Route::get('/group/{id}/settings', 'settings')->where('id', '[0-9]+')->name('group.settings');
    Route::post('/group/{id}/join', 'joinRequest')->where('id', '[0-9]+')->name('group.join');
    Route::post('/group/{id}/request/{member_id}', 'resolveRequest')->where('id', '[0-9]+')->name('group.resolveRequest');
    Route::post('/group/verify-password', 'verifyPassword')->name('group.verifyPassword');
    Route::put('/group/{id}/update', 'update')->where('id', '[0-9]+')->name('group.update');
    Route::post('/group/{id}/change-owner', 'changeOwner')->where('id', '[0-9]+')->name('group.changeOwner');
    Route::delete('/group/{id}/join', 'cancelJoinRequest')->where('id', '[0-9]+')->name('group.cancelJoin');
    Route::delete('/group/{id}', 'delete')->where('id', '[0-9]+')->name('group.delete');
    Route::delete('/group/{id}/member/{member_id}', 'deleteMember')->where('id', '[0-9]+');

    Route::post('/group/{id}/invite/{new_member}', 'inviteUser')->where('id', '[0-9]+')->name('group.inviteUser');

    Route::patch('/group/acceptInvitation/{groupId}', 'acceptInvitation')->where('groupId', '[0-9]+');
    Route::delete('/group/denyInvitation/{groupId}','denyInvitation')->where('groupId', '[0-9]+');

});

// Notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications')->middleware('auth');

// Admin
Route::controller(AdminController::class)->group(function () {
    // dashboard
    Route::redirect('/admin', '/admin/dashboard');
    Route::get('/admin/dashboard', 'index')->name('admin.dashboard');

    // users
    Route::get('/admin/users', 'listUsers')->name('admin.users');
    Route::get('/admin/api/users', 'searchUsers')->name('admin.api.users');
    Route::get('/admin/profile/{username}', 'viewUser')->name('admin.user');
    Route::get('/admin/network/{username}', 'viewNetwork')->name('admin.user.network');
    Route::post('/admin/users/{id}/ban', 'banUser')->where('id', '[0-9]+')->name('admin.users.ban');
    Route::post('/admin/users/{id}/unban', 'unbanUser')->where('id', '[0-9]+')->name('admin.users.unban');
    Route::post('/admin/users/{id}/delete', 'deleteUser')->where('id', '[0-9]+')->name('admin.users.delete');

    // posts
    Route::get('/admin/posts', 'listPosts')->name('admin.posts');
    Route::get('/admin/post/{id}', 'viewPost')->where('id', '[0-9]+')->name('admin.post');
    Route::get('/admin/api/posts', 'searchPosts')->name('admin.api.posts');
    Route::delete('/admin/post/{id}', 'deletePost')->where('id', '[0-9]+')->name('admin.posts.delete');

    // groups
    Route::get('/admin/groups', 'listGroups')->name('admin.groups');
    Route::get('/admin/group/{id}', 'viewGroup')->where('id', '[0-9]+')->name('admin.group');
    Route::get('/admin/api/groups', 'searchGroups')->name('admin.api.groups');
    Route::post('/admin/group/{id}/delete', 'deleteGroup')->where('id', '[0-9]+')->name('admin.groups.delete');

    // create admin
    Route::get('/admin/create', 'showCreateForm')->name('admin.create');
    Route::post('/admin/create', 'createAdmin');


})->middleware('auth:admin');

// Ban appeal
Route::get('/ban-appeal', function () {
    return view('pages.ban-appeal');
})->name('ban-appeal');