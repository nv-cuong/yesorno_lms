<?php

use App\Http\Controllers\Admin\ClassController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\TestController;


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
    Route::resource('class', ClassController::class);
});
Route::prefix('test')->group(function () {
    Route::get('/index', [TestController::class,'index'])->name('index');
    Route::get('/create', [TestController::class,'create'])->name('test.create');
    Route::post('/store', [TestController::class,'store'])->name('test.store');
    Route::DELETE('/delete', [TestController::class,'delete'])->name('test.delete');
    Route::get('/edit/{id}', [TestController::class,'edit'])->name('test.edit');
    Route::post('/update/{id}', [TestController::class,'update'])->name('test.update');
    Route::get('/view/{id}', [TestController::class,'view'])->name('test.view');
    Route::post('/create/{id}/{id1}/{arr_quest}', [TestController::class,'createquestion'])->name('test.create_question');
    Route::post('/store/question/{id_test}', [TestController::class,'store_question'])->name('test.store_question');
    Route::DELETE('/delete_question/{id_test}', [TestController::class,'delete_question'])->name('question.delete');
    Route::post('/edit_question/{id_question}/{id_test}/{id_course}', [TestController::class,'question_edit'])->name('question.edit');
    Route::post('/update_question/{id_test}/{id_question_old}', [TestController::class,'question_update'])->name('question.update');
});
Route::post('/getQuestion', [TestController::class,'getQuestion'])->name('getquestion');