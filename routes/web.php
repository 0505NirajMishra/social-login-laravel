<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
