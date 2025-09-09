<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// ----------------------
// Home Page (Public)
// ----------------------
Route::get('/', function () {
    return view('home');
})->name('home');


// ----------------------
// Authenticated Users Route
// ----------------------
Route::middleware('auth')->group(function () {

    // Posts page
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    route::get('/posts/create',[PostController::class,'create'])->name('posts.create');
    route::post('/posts',[PostController::class,'store'])->name('posts.store');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/show', [PostController::class,'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class,'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class,'update'])->name('posts.update');
    route::delete('/posts/{post}', [PostController::class,'destroy'])->name('posts.destroy');

    // Redirect /profile to the authenticated user's profile
    Route::get('/profile', function () {
        return redirect()->route('profile.show', auth()->id());
    })->name('profile');

    // Search page
    Route::get('/search', function () {
        return view('search');
    })->name('search');

    // Notifications page
    Route::get('/notifications', function () {
        return view('notifications');
    })->name('notifications');

    // Settings page
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ----------------------
    // Profile Routes (Protected)
    // ----------------------
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/{id}/delete-image', [ProfileController::class, 'destroyImage'])->name('profile.destroyImage');
});

// ----------------------
// Guest Users Routes
// ----------------------
Route::middleware('guest')->group(function () {

    // Login pages
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Register pages
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.view');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
