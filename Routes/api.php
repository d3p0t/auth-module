<?php

use Illuminate\Http\Request;
use Modules\Auth\Http\Controllers\Api\PermissionController;
use Modules\Auth\Http\Controllers\Api\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('auth')->group(function() {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class)
        ->except(['create', 'store', 'update', 'destroy']);
});


