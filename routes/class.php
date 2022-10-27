<?php

use App\Http\Controllers\Admin\ClassController;
use Illuminate\Support\Facades\Route;

Route::resource('class', ClassController::class)->middleware('myweb.auth:class.show');
Route::get('/data', [ClassController::class, 'getClassData'])
        ->name('class.data');
Route::delete('/class/delete', [ClassController::class, 'destroy'])
    ->name('class.delete')->middleware('myweb.auth:class.delete');
Route::get('/class/add/{slug}', [ClassController::class, 'add'])
    ->name('class.add');
Route::post('/class/add/{id}', [ClassController::class, 'join'])
    ->name('class.join');
