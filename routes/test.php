<?php

use App\Http\Controllers\Admin\TestController;
use Illuminate\Support\Facades\Route;

Route::prefix('/test')->name('test.')->group(function () {
    Route::get('/index', [TestController::class, 'index'])
        ->name('index')->middleware('myweb.auth:test.show');
    Route::get('/create', [TestController::class, 'create'])
        ->name('create')->middleware('myweb.auth:test.create');
    Route::post('/store', [TestController::class, 'store'])
        ->name('store')->middleware('myweb.auth:test.create');
    Route::DELETE('/delete', [TestController::class, 'delete'])
        ->name('delete')->middleware('myweb.auth:test.destroy');
    Route::get('/edit/{id}', [TestController::class, 'edit'])
        ->name('edit')->middleware('myweb.auth:test.edit');
    Route::post('/update/{id}', [TestController::class, 'update'])
        ->name('update')->middleware('myweb.auth:test.edit');
    Route::get('/view/{id}', [TestController::class, 'view'])
        ->name('view');
    Route::get('/create/{id_course}/{id_test}/{arr_quest}', [TestController::class, 'createquestion'])
        ->name('create_question');
    Route::post('/store/question/{id_test}', [TestController::class, 'store_question'])
        ->name('store_question');
    Route::DELETE('/delete_question/{id_test}', [TestController::class, 'delete_question'])
        ->name('question.delete');
    Route::get('/edit_question/{id_question}/{id_test}/{id_course}', [TestController::class, 'question_edit'])
        ->name('question.edit');
    Route::post('/update_question/{id_test}/{id_question_old}', [TestController::class, 'question_update'])
        ->name('question.update');
    Route::post('/search', [TestController::class, 'search'])
        ->name('search');
    Route::get('/update_category_test', [TestController::class, 'update_category_test'])
        ->name('update_category_test');
});