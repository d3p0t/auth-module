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
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('public.login');
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('public.password-reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('/profile', [AuthController::class, 'showProfile'])->middleware('auth');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->middleware('auth');

});
