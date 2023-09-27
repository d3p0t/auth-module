<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Auth\Http\Controllers\Public\AuthController;

Route::prefix('auth')->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth::public.login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('auth::public.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth::public.logout');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth::public.forgot-password.show');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth::public.forgot-password');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('auth::public.reset-password.show');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth::public.reset-password');

    Route::middleware('auth')->group(function() {
        Route::get('/profile', [AuthController::class, 'showProfile'])->name('auth::public.profile.show');
        Route::post('/profile', [AuthController::class, 'updateProfile'])->name('auth::public.profile');

        Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('auth::public.change-password.show');
        Route::post('/change-password',[AuthController::class, 'changePassword'])->name('auth::public.change-password');
    });

});
