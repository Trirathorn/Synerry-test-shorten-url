<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\AuthController;

Route::middleware('auth')->group(function () {
    Route::get('/', [UrlController::class, 'index'])->name('home');
    Route::post('/shorten', [UrlController::class, 'store'])->name('urls.store');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/urls/{url}/stats', [UrlController::class, 'stats'])->name('urls.stats');
    Route::post('/urls/{url}/toggle', [UrlController::class, 'toggle'])->name('urls.toggle');
    Route::get('/urls/{url}/qr', [UrlController::class, 'qr'])->name('urls.qr');
    Route::delete('/urls/{url}', [UrlController::class, 'destroy'])->name('urls.destroy');
    Route::get('/api/click-counts', [UrlController::class, 'getClickCounts'])->name('api.click-counts');
});

Route::get('/{code}', RedirectController::class)->name('redirect');
