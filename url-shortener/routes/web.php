<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\RedirectController;

Route::get('/', [UrlController::class, 'index'])->name('home');
Route::post('/shorten', [UrlController::class, 'store'])->name('urls.store');
Route::get('/urls/{url}/stats', [UrlController::class, 'stats'])->name('urls.stats');
Route::post('/urls/{url}/toggle', [UrlController::class, 'toggle'])->name('urls.toggle');
Route::get('/urls/{url}/qr', [UrlController::class, 'qr'])->name('urls.qr');

Route::get('/{code}', RedirectController::class)->name('redirect');
