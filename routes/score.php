<?php

use App\Http\Controllers\Admin\ScoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('/score')->name('score.')->group(function () {
    Route::get('index', [ScoreController::class, 'index'])
        ->name('index')->middleware('myweb.auth:score.view');
    Route::get('create', [ScoreController::class, 'create'])
        ->name('create')->middleware('myweb.auth:score.create');
    Route::post('store', [ScoreController::class, 'store'])
        ->name('store')->middleware('myweb.auth:score.create');
    Route::get('/dots/{id}', [ScoreController::class, 'dots'])
        ->name('dots')->middleware('myweb.auth:score.update');
    Route::post('/point', [ScoreController::class, 'point'])
        ->name('point')->middleware('myweb.auth:score.update'); 
    Route::get('/student/{id}', [ScoreController::class, 'getStudent'])
        ->name('getStudent')->middleware('myweb.auth:score.create');
    Route::get('/data', [ScoreController::class, 'getScoreData'])
        ->name('data')->middleware('myweb.auth:scores.view');
    Route::get('/mark/data/{id}', [ScoreController::class, 'getMarkData'])
        ->name('dataMark')->middleware('myweb.auth:scores.view');
});
