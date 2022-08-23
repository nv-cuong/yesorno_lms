<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\QuestionController;

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
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [IndexController::class, 'index'])
    ->name('dashboard');
    
    Route::prefix('/questions')->name('question.')->group(function () {
        Route::get('index', [QuestionController::class, 'index'])->name('index');
        Route::get('getData', [QuestionController::class, 'getData'])->name('getData');
        Route::get('create', [QuestionController::class, 'create'])->name('create');
        Route::post('store', [QuestionController::class, 'store'])->name('store');
    });

});
