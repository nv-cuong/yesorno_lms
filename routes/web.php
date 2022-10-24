<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Client\HomeController;
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


Route::get('/', [HomeController::class, 'index'])
    ->name('home');
Route::get('/notifications', [HomeController::class, 'notifications'])
    ->name('notifications');


Route::get('/login', [LoginController::class, 'login'])
    ->name('login.form');
Route::post('/login', [LoginController::class, 'postLogin'])
    ->name('login.post');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');


Route::get('/course', function () {
    return view('course');
});
