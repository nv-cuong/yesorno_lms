<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;

/**
 * Users Route
 */

Route::prefix('users')->group(function () {
    //Resource Route
    Route::get('', [UserController::class, 'index'])
        ->name('users.index')->middleware('myweb.auth:user.view');

    Route::get('/data', [UserController::class, 'getUsersData'])
        ->name('data')->middleware('myweb.auth:user.view');

    Route::get('/create', [UserController::class, 'create'])
        ->name('users.create')->middleware('myweb.auth:user.create');

    Route::post('', [UserController::class, 'store'])
        ->name('users.store')->middleware('myweb.auth:user.create');

    Route::get('/{user}', [UserController::class, 'show'])
        ->name('users.show')->middleware('myweb.auth:user.view');

    Route::get('/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit')->middleware('myweb.auth:user.update');

    Route::put('/{user}', [UserController::class, 'update'])
        ->name('users.update')->middleware('myweb.auth:user.update');

    Route::delete('/delete', [UserController::class, 'destroy'])
        ->name('users.destroy')->middleware('myweb.auth:user.delete');

    // For Change User Status
    Route::put('users/status/{id}', [UserController::class, 'status'])
        ->name('users.status')
        ->where('id', '[0-9]+')->middleware('myweb.auth:user.status');
});
