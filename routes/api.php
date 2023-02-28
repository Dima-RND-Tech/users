<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Users
Route::prefix('users')->group(function () {

    Route::get('', [\App\Http\Controllers\Api\User\ListController::class, 'index']);
    Route::post('', [\App\Http\Controllers\Api\User\CreateController::class, 'index']);
    Route::get('/{userId}', [\App\Http\Controllers\Api\User\GetController::class, 'index']);
    Route::delete('/{userId}', [\App\Http\Controllers\Api\User\DeleteController::class, 'index']);
    Route::get('/{userId}/groups', [\App\Http\Controllers\Api\User\Group\ListController::class, 'index']);
    Route::put('/{userId}/groups/{groupId}/assign', [\App\Http\Controllers\Api\User\Group\AssignController::class, 'index']);
    Route::delete('/{userId}/groups/{groupId}/revoke', [\App\Http\Controllers\Api\User\Group\RevokeController::class, 'index']);

});

// Roles
Route::prefix('roles')->group(function () {

    Route::get('', [\App\Http\Controllers\Api\Role\ListController::class, 'index']);

});

// Groups
Route::prefix('groups')->group(function () {

    Route::get('', [\App\Http\Controllers\Api\Group\ListController::class, 'index']);
    Route::post('', [\App\Http\Controllers\Api\Group\CreateController::class, 'index']);
    Route::delete('/{groupId}', [\App\Http\Controllers\Api\Group\DeleteController::class, 'index']);

});
