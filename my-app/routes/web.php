<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'posts');

// using the resource method for auto completion
Route::resource('posts', PostController::class);

Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// grouping the routes under a particular middleware
Route::middleware('guest')->group(function () {
    // register
    Route::view('/register', 'auth.register')->name('register'); //chaining a name to this route helps with navigation and all correct patten vibe

    // creating routes that would be used for post requests this is a functionality route it doesn't return a view
    Route::post('/register', [AuthController::class, 'register']);

    // Login routes
    Route::view('/login', 'auth.login')->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});
