<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\UnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('/courses')->name('course.')->group(function () {
    Route::get('index', [CourseController::class, 'index'])
        ->name('index')->middleware('myweb.auth:course.show');

    Route::get('/show/{id}', [CourseController::class, 'showCourse'])
        ->name('detail')->middleware('myweb.auth:course.show');
    Route::get('/course/data', [CourseController::class, 'getCourseData'])
        ->name('dataCourse')->middleware('myweb.auth:course.show');
    Route::get('/test/data/{id}', [CourseController::class, 'getTestData'])
        ->name('dataTest')->middleware('myweb.auth:course.show');
    Route::get('/unit/data/{id}', [CourseController::class, 'getUnitData'])
        ->name('dataUnit')->middleware('myweb.auth:course.show');
    Route::get('/student/data/{id}', [CourseController::class, 'getStudentData'])
        ->name('dataStudent')->middleware('myweb.auth:course.show');
    Route::get('create', [CourseController::class, 'createCourse'])
        ->name('create')->middleware('myweb.auth:course.create');
    Route::post('store', [CourseController::class, 'storeCourse'])
        ->name('store')->middleware('myweb.auth:course.create');
    Route::get('/edit/{id}', [CourseController::class, 'editCourse'])
        ->name('edit')->middleware('myweb.auth:course.edit');
    Route::post('/edit/{id}', [CourseController::class, 'updateCourse'])
        ->name('update')->middleware('myweb.auth:course.edit');
    Route::delete('/destroy', [CourseController::class, 'destroyCourse'])
        ->name('delete')->middleware('myweb.auth:course.destroy');
    Route::get('/test/show/{id}', [CourseController::class, 'showTest'])
        ->name('test')->middleware('myweb.auth:course.show');
    Route::get('/student/show/{id}', [CourseController::class, 'showStudent'])
        ->name('student')->middleware('myweb.auth:course.show');
    Route::post('student/active/{id}', [CourseController::class, 'activeStudent'])
        ->name('active')->middleware('myweb.auth:course.show');
});

Route::prefix('/units')->name('unit.')->group(function () {
    Route::get('/show/{id}', [UnitController::class, 'showUnit'])
        ->name('detail')->middleware('myweb.auth:course.show');
    Route::get('/data/{id}', [UnitController::class, 'getUnitData'])
        ->name('data')->middleware('myweb.auth:course.show');
    Route::get('/create/{course_id}', [UnitController::class, 'createUnit'])
        ->name('create')->middleware('myweb.auth:course.show');
    Route::post('/store', [UnitController::class, 'storeUnit'])
        ->name('store')->middleware('myweb.auth:course.show');
    Route::get('/edit/{id}', [UnitController::class, 'editUnit'])
        ->name('edit')->middleware('myweb.auth:course.show');
    Route::post('/edit/{id}', [UnitController::class, 'updateUnit'])
        ->name('update')->middleware('myweb.auth:course.show');
    Route::delete('/destroy/{course_id}', [UnitController::class, 'destroyUnit'])
        ->name('delete')->middleware('myweb.auth:course.show');
});

Route::prefix('/lessons')->name('lesson.')->group(function () {
    Route::get('/show/{id}', [LessonController::class, 'showLesson'])
        ->name('detail')->middleware('myweb.auth:course.show');
    Route::get('/create/{unit_id}', [LessonController::class, 'createLesson'])
        ->name('create')->middleware('myweb.auth:course.show');
    Route::post('/store', [LessonController::class, 'storeLesson'])
        ->name('store')->middleware('myweb.auth:course.show');
    Route::get('/edit/{id}', [LessonController::class, 'editLesson'])
        ->name('edit')->middleware('myweb.auth:course.show');
    Route::post('/edit/{id}', [LessonController::class, 'updateLesson'])
        ->name('update')->middleware('myweb.auth:course.show');
    Route::delete('/destroy/{unit_id}', [LessonController::class, 'destroyLesson'])
        ->name('delete')->middleware('myweb.auth:course.show');
});
