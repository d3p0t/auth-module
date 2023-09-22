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

use Modules\Auth\Http\Controllers\AuthController;

use Modules\Auth\Http\Controllers\Admin\RoleController;
use Modules\Auth\Http\Controllers\Admin\UserController;

Route::prefix('auth')->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('/profile', [AuthController::class, 'showProfile'])->middleware('auth');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->middleware('auth');

});

Route::prefix('admin/auth')->middleware('permission:admin')->group(function() {

    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/create', [UserController::class, 'store']);
        Route::get('/edit/{id}', [UserController::class, 'edit']);
        Route::post('/edit/{id}', [UserController::class, 'update']);
    });

    Route::prefix('roles')->group(function() {
        Route::get('/', [RoleController::class, 'index'])->middleware('can:view roles');
        Route::get('/create', [RoleController::class, 'create'])->middleware('can:create roles');
        Route::post('/create', [RoleController::class, 'store'])->middleware('can:create roles');
        Route::get('/edit/{id}', [RoleController::class, 'edit']);
        Route::post('/edit/{id}', [RoleController::class, 'update']);
    });

});