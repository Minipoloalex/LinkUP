<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;

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

// Home
Route::redirect('/', '/login');

Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
});


// API


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
Route::redirect('/admin', '/admin/login');

Route::prefix('admin')->group(function () {
    Route::controller(AdminLoginController::class)->group(function () {
        Route::get('/login', 'show')->name('admin.login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('admin.logout');
    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->middleware('auth:admin')->name('admin.dashboard');
    });
});
