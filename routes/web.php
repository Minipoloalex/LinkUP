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
        Route::get('/posts', [AdminController::class, 'listPosts'])->name('posts');
        Route::get('/create', [AdminController::class, 'showCreateForm'])->name('create');
        Route::post('/create', [AdminController::class, 'createAdmin']);
    });
});

Route::controller(PostController::class)->group(function () {
    Route::get('/post/{id}', 'show')->name('post');
    Route::get('/post/{id}/image', 'viewImage')->name('post.image');

    Route::post('/post', 'storePost');
    Route::post('/comment', 'storeComment');

    // Route::delete('/comment/{id}', 'delete');
    Route::delete('/post/{id}', 'delete');
    Route::delete('/post/{id}/image', 'deleteImage');

    Route::put('/post/{id}', 'update');

    Route::get('/search', 'searchResults');
});

// Groups
Route::controller(GroupController::class)->group(function () {
    Route::get('/group/{id}', 'show')->name('group');

    Route::post('/group', 'createGroup')->name('group.create');
    Route::put('/group/{id}', 'update')->name('group.update');

    Route::delete('/group/{id}', 'delete');
});

// profile page

/*
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile/{id}', 'show')->name('user');
    Route::get('/profile/{id}/username', 'viewUsername')->name('post.username');
    Route::get('/profile/{id}/description', 'viewDescription')->name('post.description');
    Route::get('/profile/{id}/image', 'viewPhoto')->name('post.photo');

    Route::post('/profile', 'storePost');
    Route::post('/comment', 'storeComment');

    // Route::delete('/comment/{id}', 'delete');
    Route::delete('/profile/{id}', 'delete');

    Route::put('/profile/{id}', 'update');

    Route::get('/api/post/search/{search}', 'search');
});*/

Route::get('/profile/{username}', [UserController::class, 'show'])->name('profile.show');
Route::post('/profile', [UserController::class, 'update'])->name('profile.update');

/* route for about us page */
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

/* route for contact us page */
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');