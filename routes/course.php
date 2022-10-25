<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\UnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('/courses')->name('course.')->group(function () {
    Route::get('index', [CourseController::class, 'index'])
        ->name('index')->middleware('myweb.auth:course.show');
    Route::get('/showCourse/{id}', [CourseController::class, 'showCourse'])
        ->name('detail')->middleware('myweb.auth:course.show');
    Route::get('createCourse', [CourseController::class, 'createCourse'])
        ->name('create')->middleware('myweb.auth:course.create');
    Route::post('storeCourse', [CourseController::class, 'storeCourse'])
        ->name('store')->middleware('myweb.auth:course.create');
    Route::get('/editCourse/{id}', [CourseController::class, 'editCourse'])
        ->name('edit')->middleware('myweb.auth:course.edit');
    Route::post('/editCourse/{id}', [CourseController::class, 'updateCourse'])
        ->name('update')->middleware('myweb.auth:course.edit');
    Route::delete('/destroyCourse', [CourseController::class, 'destroyCourse'])
        ->name('delete')->middleware('myweb.auth:course.destroy');
    Route::get('/showTest/{id}', [CourseController::class, 'showTest'])
        ->name('test')->middleware('myweb.auth:course.show');
    Route::get('/showStudent/{id}', [CourseController::class, 'showStudent'])
        ->name('student')->middleware('myweb.auth:course.show');
    Route::post('/activeStudent{id}', [CourseController::class, 'activeStudent'])
        ->name('active')->middleware('myweb.auth:course.show');
});

Route::prefix('/units')->name('unit.')->group(function () {
    Route::get('/showUnit/{id}', [UnitController::class, 'showUnit'])
        ->name('detail');
    Route::get('createUnit/{course_id}', [UnitController::class, 'createUnit'])
        ->name('create');
    Route::post('storeUnit', [UnitController::class, 'storeUnit'])
        ->name('store');
    Route::get('/editUnit/{id}', [UnitController::class, 'editUnit'])
        ->name('edit');
    Route::post('/editUnit/{id}', [UnitController::class, 'updateUnit'])
        ->name('update');
    Route::delete('/destroyUnit/{course_id}', [UnitController::class, 'destroyUnit'])
        ->name('delete');
});

Route::prefix('/lessons')->name('lesson.')->group(function () {
    Route::get('/showLesson/{id}', [LessonController::class, 'showLesson'])
        ->name('detail');
    Route::get('createLesson/{unit_id}', [LessonController::class, 'createLesson'])
        ->name('create');
    Route::post('storeLesson', [LessonController::class, 'storeLesson'])
        ->name('store');
    Route::get('/editLesson/{id}', [LessonController::class, 'editLesson'])
        ->name('edit');
    Route::post('/editLesson/{id}', [LessonController::class, 'updateLesson'])
        ->name('update');
    Route::delete('/destroyLesson/{unit_id}', [LessonController::class, 'destroyLesson'])
        ->name('delete');
});
