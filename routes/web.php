<?php

use App\Http\Controllers\Admin\ClassController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Auth\LoginController;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [LoginController::class, 'login'])
->name('login');
Route::post('/login', [LoginController::class, 'postLogin'])
->name('login.post');
// Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [IndexController::class, 'index'])
    ->name('dashboard');

    Route::prefix('users')->group(function () {
    Route::get('/', [StudentController::class, 'index'])
    ->name('users');
    Route::get('/edit/{id}', [StudentController::class, 'edit'])
        ->name('user.edit');
    Route::post('/edit/{id}', [StudentController::class, 'update'])
        ->name('user.update');
    });
    Route::resource('class', ClassController::class);
});

