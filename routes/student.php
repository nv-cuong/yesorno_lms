<?php

use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])
        ->name('students')->middleware('myweb.auth:student.view');
    Route::get('/data', [StudentController::class, 'getStudentData'])
        ->name('students.data')->middleware('myweb.auth:student.view');
    Route::get('/create', [StudentController::class, 'create'])
        ->name('student.create')->middleware('myweb.auth:student.create');
    Route::post('/store', [StudentController::class, 'store'])
        ->name('student.store')->middleware('myweb.auth:student.create');
    Route::get('/edit/{id}', [StudentController::class, 'edit'])
        ->name('student.edit')->middleware('myweb.auth:student.edit');
    Route::post('/edit/{id}', [StudentController::class, 'update'])
        ->name('student.update')->middleware('myweb.auth:student.edit');
    Route::delete('/delete', [StudentController::class, 'destroy'])
        ->name('student.delete')->middleware('myweb.auth:student.delete');
    Route::get('/class/{id}', [StudentController::class, 'showClass'])
        ->name('student.class')->middleware('myweb.auth:student.view');
    Route::get('/course/{id}', [StudentController::class, 'showCourse'])
        ->name('student.course')->middleware('myweb.auth:student.view');
    Route::get('/statistic/{id}', [StudentController::class, 'showStatistic'])
        ->name('student.statistic')->middleware('myweb.auth:student.view');
});
