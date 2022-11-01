<?php

use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportQuestionController;

Route::prefix('/questions')->name('question.')->group(function () {

    Route::get('index', [QuestionController::class, 'index'])
        ->name('index')->middleware('myweb.auth:question.show');

    Route::get('/data', [QuestionController::class, 'getQuestionData'])
        ->name('data')->middleware('myweb.auth:question.show');

    Route::get('create', [QuestionController::class, 'create'])
        ->name('create')->middleware('myweb.auth:question.create');

    Route::post('store', [QuestionController::class, 'store'])
        ->name('store')->middleware('myweb.auth:question.create');

    Route::get('/edit/{id}', [QuestionController::class, 'edit'])
        ->name('edit')->middleware('myweb.auth:question.edit');

    Route::post('/edit/{id}', [QuestionController::class, 'update'])
        ->name('update')->middleware('myweb.auth:question.edit');

    Route::delete('/delete', [QuestionController::class, 'destroy'])
        ->name('delete')->middleware('myweb.auth:question.destroy');

    Route::get('/answer/{id}', [QuestionController::class, 'show_answser'])
        ->name('answer')->middleware('myweb.auth:question.show');

            Route::get('export', [ImportQuestionController::class, 'export' ])->name('export');
            Route::get('indexx', [ImportQuestionController::class, 'index']);
            Route::post('import', [ImportQuestionController::class, 'import'])->name('import');

});
