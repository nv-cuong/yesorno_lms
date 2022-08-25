<?php

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;



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
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::prefix('admin')
->middleware('myweb.auth')
->group(function ()
{
    Route::get('/dashboard', [IndexController::class, 'index'])
    ->name('dashboard');

    Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])
    ->name('students');
    Route::get('/edit/{id}', [StudentController::class, 'edit'])
        ->name('student.edit');
    Route::post('/edit/{id}', [StudentController::class, 'update'])
        ->name('student.update');
    Route::delete('/delete', [StudentController::class, 'destroy'])
        ->name('student.delete');
    Route::get('/class/{id}', [StudentController::class, 'showClass'])
        ->name('student.class');
    Route::get('/course/{id}', [StudentController::class, 'showCourse'])
        ->name('student.course');
    Route::get('/statistic/{id}', [StudentController::class, 'showStatistic'])
        ->name('student.statistic');
    });
    Route::prefix('/questions')->name('question.')->group(function () {
        Route::get('index', [QuestionController::class, 'index'])->name('index');
        Route::get('getData', [QuestionController::class, 'getData'])->name('getData');
        Route::get('create', [QuestionController::class, 'create'])->name('create');
        Route::post('store', [QuestionController::class, 'store'])->name('store');
    });
    Route::resource('class', ClassController::class);

    Route::resource('class', ClassController::class)
    ->middleware('myweb.auth:admin');

    Route::resource('course', CourseController::class);
});
