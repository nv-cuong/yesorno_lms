<?php

use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;

Route::prefix('teachers')->name('teacher.')->group(function () {
    Route::get('/', [TeacherController::class, 'index'])
        ->name('index')->middleware('myweb.auth:teacher.view');
    Route::get('/data', [TeacherController::class, 'getTeacherData'])
        ->name('data')->middleware('myweb.auth:teacher.view');
    Route::get('/create', [TeacherController::class, 'create'])
        ->name('create')->middleware('myweb.auth:teacher.create');
    Route::post('/store', [TeacherController::class, 'store'])
        ->name('store')->middleware('myweb.auth:teacher.create');
    Route::get('/edit/{id}', [TeacherController::class, 'edit'])
        ->name('edit')->middleware('myweb.auth:teacher.update');
    Route::put('/update/{id}', [TeacherController::class, 'update'])
        ->name('update')->middleware('myweb.auth:teacher.update');
    Route::delete('/delete', [TeacherController::class, 'destroy'])
        ->name('delete')->middleware('myweb.auth:teacher.delete');
    Route::get('/course/{id}', [TeacherController::class, 'showCourse'])
        ->name('course')->middleware('myweb.auth:teacher.view');
    Route::get('/detail/{id}', [TeacherController::class, 'show'])
        ->name('detail')->middleware('myweb.auth:teacher.view');
});
