<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home');
});
Route::get('/posts', function(){
    return view('posts');
});

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