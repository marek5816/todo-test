<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return auth()->check() ? redirect()->route('todo.task.list') : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'view'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'view'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

    Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'view'])
        ->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'reset'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'view'])
        ->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'reset'])
        ->name('password.store');
});


Route::middleware('auth')->group(function () {
    include 'todo/task.php';
    include 'todo/category.php';

    Route::any('/notifications', [App\Http\Controllers\Notification\ListController::class, 'list'])->name('notification.list')->middleware(\App\Http\Middleware\Notification\MarkNotificationsAsRead::class);

    Route::any('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
});
