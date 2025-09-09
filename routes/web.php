<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('home');
});
// Post Routes
Route::resource('posts', PostController::class);

// Routes للمصادقة
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Routes للصفحات الجديدة
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::get('/notifications', function () {
    return view('notifications');
})->name('notifications');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/logout', function () {
    // Logic for logout
    return redirect('/');
})->name('logout');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
route::get('/posts/create',[PostController::class,'create'])->name('posts.create');
route::post('/posts',[PostController::class,'store'])->name('posts.store');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/show', [PostController::class,'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class,'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostController::class,'update'])->name('posts.update');
route::delete('/posts/{post}', [PostController::class,'destroy'])->name('posts.destroy');