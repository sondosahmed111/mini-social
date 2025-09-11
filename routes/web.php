<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use Illuminate\Support\Facades\Route;

// ----------------------
// Authenticated Users Routes
// ----------------------
Route::middleware('auth')->group(function () {

    // ----------------------
    // Profile Routes
    // ----------------------
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');  
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete-image', [ProfileController::class, 'destroyImage'])->name('profile.destroyImage');

    Route::get('/profile/{id}', [ProfileController::class, 'view'])->name('profile.view');

    // ----------------------
    // Posts Routes
    // ----------------------
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // ----------------------
    // Reactions
    // ----------------------

Route::post('/posts/{post}/react', [PostController::class, 'react'])->middleware('auth');
Route::get('/posts/{post}/reactions-count', [PostController::class, 'reactionsCount']);


// edit

Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');


    // ----------------------
    // Other Pages
    // ----------------------
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/notifications', fn() => view('notifications'))->name('notifications');
    Route::get('/settings', fn() => view('settings'))->name('settings');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ----------------------
    // Comment Routes
    // ----------------------
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

});

// ----------------------
// Home (default)
// ----------------------
Route::get('/', [PostController::class, 'index'])->name('home');

// ----------------------
// Guest Users Routes
// ----------------------
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.view');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
