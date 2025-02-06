<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('login-page');
    });
    Route::get('/registration/form', [AuthController::class, 'loadRegisterForm']);
    Route::post('/register/user', [AuthController::class, 'registerUser'])->name('registerUser');
    Route::get('/login/form', [AuthController::class, 'loadLoginPage']);
    Route::post('/login/user', [AuthController::class, 'LoginUser'])->name('LoginUser');
});

// Authentication routes
Route::get('/logout', [AuthController::class, 'LogoutUser']);

// User routes
Route::middleware('user')->group(function () {
    Route::get('user/home', [UserController::class, 'loadHomePage']);
    Route::get('my/posts', [UserController::class, 'loadMyPosts']);
    Route::get('create/post', [UserController::class, 'loadCreatePost']);
    Route::get('/edit/post/{post_id}', [UserController::class, 'loadEditPost']);
    Route::get('/view/post/{id}', [UserController::class, 'loadPostPage']);
    Route::get('/profile', [UserController::class, 'loadProfile']);
    Route::get('/view/profile/{user_id}', [UserController::class, 'loadGuestProfile']);
});

// Admin routes
Route::middleware('admin')->group(function () {
    Route::get('admin/home', [AdminController::class, 'loadHomePage']);
});

// Post resource routes
Route::resource('posts', PostController::class);

// Error pages
Route::get('/404', [AuthController::class, 'load404']);

// Disable unused auth routes
Auth::routes([
    'reset' => false,
    'verify' => false,
    'register' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
