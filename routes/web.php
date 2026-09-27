<?php

use App\Http\Controllers\NotificationPostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/notifications', [NotificationPostController::class, 'index'])->name('notifications.index');
Route::post('/notifications', [NotificationPostController::class, 'store'])->name('notifications.store');
