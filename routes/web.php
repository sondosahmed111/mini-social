<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// ----------------------
// Authenticated Users Routes
// ----------------------
Route::middleware('auth')->group(function () {
    // ----------------------
    // Following List Route
    // ----------------------
    Route::get('/profile/following', [ProfileController::class, 'followingList'])->name('profile.following');

    // ----------------------
    // Profile Routes
    // ----------------------
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');  
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete-image', [ProfileController::class, 'destroyImage'])->name('profile.destroyImage');
    Route::get('/profile/{id}', [ProfileController::class, 'view'])->name('profile.view');

    // ----------------------
    // Follow Routes
    // ----------------------
    Route::post('/follow/{id}', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::delete('/unfollow/{id}', [ProfileController::class, 'unfollow'])->name('profile.unfollow');

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
    Route::post('/reactions', [ReactionController::class, 'store'])->name('reactions.store');
    Route::delete('/reactions', [ReactionController::class, 'destroy'])->name('reactions.destroy');

    // ----------------------
    // Notifications
    // ----------------------
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'clearAll'])->name('notifications.clearAll');

    // ----------------------
    // Other Pages
    // ----------------------
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/settings', fn() => view('settings'))->name('settings');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ----------------------
    // Comment Routes
    // ----------------------
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}/update', [CommentController::class,'update'])->name('comments.update');
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
