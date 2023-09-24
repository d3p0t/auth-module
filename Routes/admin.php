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

use Modules\Auth\Http\Controllers\Admin\RoleController;
use Modules\Auth\Http\Controllers\Admin\UserController;
use Modules\Auth\Http\Controllers\Admin\AuthController;
use Modules\Auth\Http\Controllers\Admin\ProfileController;

Route::prefix('auth')->group(function() {

    Route::group([
        'excluded_middleware' => ['auth', 'permission:admin'],
    ], function() {
        Route::get('/login', [AuthController::class, 'showLogin']);
        Route::post('/login', [AuthController::class, 'login'])->name('auth::admin.login');
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/forgot-password', [AuthController::class, 'showForgotPassword']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('admin.password-reset');
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    });

    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->middleware('can:view users')->name('adth::admin.users.index');
        Route::get('/create', [UserController::class, 'create'])->middleware('can:create users')->name('auth::admin.users.create');
        Route::post('/create', [UserController::class, 'store'])->middleware('can:create users')->name('auth::admin.users.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->middleware('can:update users')->name('auth::admin.users.edit');
        Route::post('/edit/{id}', [UserController::class, 'update'])->middleware('can:update users')->name('auth::admin.users.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->middleware('can:delete users')->name('auth::admin.users.delete');
    });

    Route::prefix('roles')->group(function() {
        Route::get('/', [RoleController::class, 'index'])->middleware('can:view roles')->name('auth::admin.roles.index');
        Route::get('/create', [RoleController::class, 'create'])->middleware('can:create roles')->name('auth::admin.roles.create');
        Route::post('/create', [RoleController::class, 'store'])->middleware('can:create roles')->name('auth::admin.roles.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->middleware('can:update roles')->name('auth::admin.roles.edit');
        Route::post('/edit/{id}', [RoleController::class, 'update'])->middleware('can:update roles')->name('auth::admin.roles.update');
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->middleware('can:delete roles')->name('auth::admin.roles.delete');
    });

    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'edit']);
    });

});