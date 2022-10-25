<?php

use App\Http\Controllers\Admin\ScoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('/score')->name('score.')->group(function () {
    Route::get('index', [ScoreController::class, 'index'])
        ->name('index')->middleware('myweb.auth:score.show');
    Route::get('create', [ScoreController::class, 'create'])
        ->name('create')->middleware('myweb.auth:score.create');
    Route::post('store', [ScoreController::class, 'store'])
        ->name('store')->middleware('myweb.auth:score.create');
    Route::get('/dots/{id}', [ScoreController::class, 'dots'])
        ->name('dots')->middleware('myweb.auth:score.point');
    Route::post('/point', [ScoreController::class, 'point'])
        ->name('point')->middleware('myweb.auth:scores.point');
    Route::get('/getStudent/{id}', [ScoreController::class, 'getStudent'])
        ->name('getStudent');
    Route::get('/dots/{id}', [ScoreController::class, 'dots'])
        ->name('dots');
});
