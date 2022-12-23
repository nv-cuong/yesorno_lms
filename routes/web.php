<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\TestController;
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

Route::get('/dashboard', [IndexController::class, 'index'])
    ->name('dashboard')->middleware('myweb.auth:dashboard');

Route::prefix('admin')->group(function () {
    require 'question.php';
    require 'class.php';
    require 'student.php';
    require 'course.php';
    require 'test.php';
    require 'score.php';

    require 'users.php';
    require 'roles.php';
    require 'teacher.php';
});

Route::post('/getQuestion', [TestController::class, 'getQuestion'])->name('getquestion');
