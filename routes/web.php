<?php

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;

use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UnitController;
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
    Route::resource('class', ClassController::class);
    Route::delete('/class/delete', [ClassController::class, 'destroy'])
        ->name('class.delete');

    Route::prefix('/questions')->name('question.')->group(function () {
        Route::get('index', [QuestionController::class, 'index'])->name('index');
        Route::get('getData', [QuestionController::class, 'getData'])->name('getData');
        Route::get('create', [QuestionController::class, 'create'])->name('create');
        Route::post('store', [QuestionController::class, 'store'])->name('store');
    });
    Route::resource('course', CourseController::class);

    Route::prefix('/courses')->name('course.')->group(function () {
        Route::get('index', [CourseController::class, 'index'])->name('index');
        Route::get('/showCourse/{slug}', [CourseController::class, 'showCourse'])->name('detail');
        // Route::get('getData', [CourseController::class, 'getData'])->name('getData');
        Route::get('createCourse', [CourseController::class, 'createCourse'])->name('create');
        Route::post('storeCourse', [CourseController::class, 'storeCourse'])->name('store');
        Route::delete('/destroyCourse', [CourseController::class, 'destroyCourse'])->name('delete');
    });

    Route::prefix('/units')->name('unit.')->group(function () {
        Route::get('/showUnit/{slug}', [UnitController::class, 'showUnit'])->name('detail');
        // Route::get('getData', [CourseController::class, 'getData'])->name('getData');
        // Route::get('create', [QuestionController::class, 'create'])->name('create');
        // Route::post('store', [QuestionController::class, 'store'])->name('store');
    });

});
