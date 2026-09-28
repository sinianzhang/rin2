<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\NotificationPostController;
use App\Http\Controllers\NotificationReadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('/notifications', [NotificationPostController::class, 'index'])->name('notifications.index');
Route::post('/notifications', [NotificationPostController::class, 'store'])->name('notifications.store');

Route::post('/impersonate/{user}', [ImpersonationController::class, 'store'])->name('impersonate.store');
Route::delete('/impersonate', [ImpersonationController::class, 'destroy'])->name('impersonate.destroy');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::post('/home/notifications/{notificationPost}/read', [NotificationReadController::class, 'store'])
    ->middleware('auth')
    ->name('home.notifications.read');
