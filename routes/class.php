<?php

use App\Http\Controllers\Admin\ClassController;
use Illuminate\Support\Facades\Route;

Route::get('/class/add/{slug}', [ClassController::class, 'add'])
    ->name('class.add');
Route::post('/class/add/{id}', [ClassController::class, 'join'])
    ->name('class.join');
Route::prefix('class')->group(function () {
    Route::get('/', [ClassController::class, 'index'])
        ->name('class.index')->middleware('myweb.auth:class.show');

    Route::get('/data', [ClassController::class, 'getClassData'])
        ->name('class.data')->middleware('myweb.auth:class.show');

    Route::get('/create', [ClassController::class, 'create'])
        ->name('class.create')->middleware('myweb.auth:class.create');

    Route::post('/store', [ClassController::class, 'store'])
        ->name('class.store')->middleware('myweb.auth:class.store');

    Route::get('/edit/{id}', [ClassController::class, 'edit'])
        ->name('class.edit')->middleware('myweb.auth:class.edit');

    Route::put('/update/{id}', [ClassController::class, 'update'])
        ->name('class.update')->middleware('myweb.auth:class.update');

    Route::delete('/delete', [ClassController::class, 'destroy'])
        ->name('class.delete')->middleware('myweb.auth:class.destroy');

    Route::get('/show/{id}', [ClassController::class, 'show'])
        ->name('class.show')->middleware('myweb.auth:class.show');
});
