<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;




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
Route::redirect('/', '/login');

Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
}); // middleware('auth') ???

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

Route::controller(PostController::class)->group(function () {
    Route::get('/post/{id}', 'show')->name('post');
    Route::get('/post/{id}/image', 'viewImage')->name('post.image');

    Route::post('/post', 'storePost');
    Route::post('/comment', 'storeComment');

    // Route::delete('/comment/{id}', 'delete');
    Route::delete('/post/{id}', 'delete');
    Route::delete('/post/{id}/image', 'deleteImage');

    Route::put('/post/{id}', 'update');

    Route::get('/api/post/search/{search}', 'search');
});

Route::get('/search', function () {
    return view('pages.search');
})->name('search');

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
Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
