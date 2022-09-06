<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotController;

/**
 * Users Register Route
 */
Route::prefix('/register')->group(function () {
    Route::get('', [RegisterController::class, 'register'])
    ->name('register.form');

    // For Action
    Route::post('', [RegisterController::class, 'processRegistration'])
    ->name('register.action');

    Route::get('activate/{userId}/{code}', [RegisterController::class, 'activate'])
    ->name('register.activate');
});


/**
 * Reset Password Email Route
 */
Route::prefix('/forgot-password')->group(function () {
    Route::get('', [ForgotController::class, 'forgotPassword'])
    ->name('forgotPassword.form');

    // For Action
    Route::post('', [ForgotController::class, 'processForgotPassword'])
    ->name('forgotPassword.action');
});


/**
 * Reset Password Route
 */
Route::prefix('/reset-password')->group(function () {
    Route::get('{userId}/{code}', [ForgotController::class, 'resetPassword'])
    ->name('resetPassword.form');

    // For Action
    Route::post('{userId}/{code}', [ForgotController::class, 'processResetPassword'])
    ->name('resetPassword.action');
});

/**
 * Change Password Route
 */
Route::prefix('/change-password')->group(function () {
    Route::get('', [ForgotController::class, 'changePassword'])
    ->name('changePassword.form');

    // For Action
    Route::post('', [ForgotController::class, 'processChangePassword'])
    ->name('changePassword.action');
});

Route::get('access-denied', [ForgotController::class, 'accessDenied'])
->name('accessDenied');


