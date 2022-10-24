<?php

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\ScoreController;

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [IndexController::class, 'index'])
        ->name('dashboard');

    Route::prefix('/questions')->name('question.')->group(function () {
        Route::get('index', [QuestionController::class, 'index'])->name('index')->middleware('myweb.auth:question.show');
        Route::get('create', [QuestionController::class, 'create'])->name('create')->middleware('myweb.auth:question.create');
        Route::post('store', [QuestionController::class, 'store'])->name('store')->middleware('myweb.auth:question.create');
        Route::get('/edit/{id}', [QuestionController::class, 'edit'])
            ->name('edit')->middleware('myweb.auth:question.edit');
        Route::post('/edit/{id}', [QuestionController::class, 'update'])
            ->name('update')->middleware('myweb.auth:question.edit');
        Route::delete('/delete', [QuestionController::class, 'destroy'])
            ->name('delete')->middleware('myweb.auth:question.destroy');
        Route::get('/answer/{id}', [QuestionController::class, 'show_answser'])
            ->name('answer')->middleware('myweb.auth:question.show');
    });

    Route::resource('class', ClassController::class)->middleware('myweb.auth:class.show');
    Route::delete('/class/delete', [ClassController::class, 'destroy'])
        ->name('class.delete')->middleware('myweb.auth:class.delete');
    Route::get('/class/add/{slug}', [ClassController::class, 'add'])
        ->name('class.add');
    Route::post('/class/add/{id}', [ClassController::class, 'join'])
        ->name('class.join');

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])
            ->name('students')->middleware('myweb.auth:student.show');
        Route::get('/create', [StudentController::class, 'create'])
            ->name('student.create')->middleware('myweb.auth:student.create');
        Route::post('/store', [StudentController::class, 'store'])
            ->name('student.store')->middleware('myweb.auth:student.store');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])
            ->name('student.edit')->middleware('myweb.auth:student.edit');
        Route::post('/edit/{id}', [StudentController::class, 'update'])
            ->name('student.update')->middleware('myweb.auth:student.edit');
        Route::delete('/delete', [StudentController::class, 'destroy'])
            ->name('student.delete')->middleware('myweb.auth:student.destroy');
        Route::get('/class/{id}', [StudentController::class, 'showClass'])
            ->name('student.class')->middleware('myweb.auth:student.show');
        Route::get('/course/{id}', [StudentController::class, 'showCourse'])
            ->name('student.course')->middleware('myweb.auth:student.show');
        Route::get('/statistic/{id}', [StudentController::class, 'showStatistic'])
            ->name('student.statistic')->middleware('myweb.auth:student.show');
    });

    Route::prefix('/courses')->name('course.')->group(function () {
        Route::get('index', [CourseController::class, 'index'])->name('index')->middleware('myweb.auth:course.show');
        Route::get('/showCourse/{id}', [CourseController::class, 'showCourse'])->name('detail')->middleware('myweb.auth:course.show');
        // Route::get('getData', [CourseController::class, 'getData'])->name('getData');
        Route::get('createCourse', [CourseController::class, 'createCourse'])->name('create')->middleware('myweb.auth:course.create');
        Route::post('storeCourse', [CourseController::class, 'storeCourse'])->name('store')->middleware('myweb.auth:course.create');
        Route::get('/editCourse/{id}', [CourseController::class, 'editCourse'])->name('edit')->middleware('myweb.auth:course.edit');
        Route::post('/editCourse/{id}', [CourseController::class, 'updateCourse'])->name('update')->middleware('myweb.auth:course.edit');
        Route::delete('/destroyCourse', [CourseController::class, 'destroyCourse'])->name('delete')->middleware('myweb.auth:course.destroy');
        Route::get('/showTest/{id}', [CourseController::class, 'showTest'])->name('test')->middleware('myweb.auth:course.show');
        Route::get('/showStudent/{id}', [CourseController::class, 'showStudent'])->name('student')->middleware('myweb.auth:course.show');
        Route::post('/activeStudent{id}', [CourseController::class, 'activeStudent'])->name('active')->middleware('myweb.auth:course.show');
    });

    Route::prefix('/units')->name('unit.')->group(function () {
        Route::get('/showUnit/{id}', [UnitController::class, 'showUnit'])->name('detail');
        // Route::get('getData', [UnitController::class, 'getData'])->name('getData');
        Route::get('createUnit/{course_id}', [UnitController::class, 'createUnit'])->name('create');
        Route::post('storeUnit', [UnitController::class, 'storeUnit'])->name('store');
        Route::get('/editUnit/{id}', [UnitController::class, 'editUnit'])->name('edit');
        Route::post('/editUnit/{id}', [UnitController::class, 'updateUnit'])->name('update');
        Route::delete('/destroyUnit/{course_id}', [UnitController::class, 'destroyUnit'])->name('delete');
    });

    Route::prefix('/lessons')->name('lesson.')->group(function () {
        Route::get('/showLesson/{id}', [LessonController::class, 'showLesson'])->name('detail');
        // Route::get('getData', [UnitController::class, 'getData'])->name('getData');
        Route::get('createLesson/{unit_id}', [LessonController::class, 'createLesson'])->name('create');
        Route::post('storeLesson', [LessonController::class, 'storeLesson'])->name('store');
        Route::get('/editLesson/{id}', [LessonController::class, 'editLesson'])->name('edit');
        Route::post('/editLesson/{id}', [LessonController::class, 'updateLesson'])->name('update');
        Route::delete('/destroyLesson/{unit_id}', [LessonController::class, 'destroyLesson'])->name('delete');
    });

    Route::prefix('/test')->name('test.')->group(function () {
        Route::get('/index', [TestController::class, 'index'])->name('index')->middleware('myweb.auth:test.show');
        Route::get('/create', [TestController::class, 'create'])->name('create')->middleware('myweb.auth:test.create');
        Route::post('/store', [TestController::class, 'store'])->name('store')->middleware('myweb.auth:test.create');
        Route::DELETE('/delete', [TestController::class, 'delete'])->name('delete')->middleware('myweb.auth:test.destroy');
        Route::get('/edit/{id}', [TestController::class, 'edit'])->name('edit')->middleware('myweb.auth:test.edit');
        Route::post('/update/{id}', [TestController::class, 'update'])->name('update')->middleware('myweb.auth:test.edit');
        Route::get('/view/{id}', [TestController::class, 'view'])->name('view');
        Route::get('/create/{id_course}/{id_test}/{arr_quest}', [TestController::class, 'createquestion'])->name('create_question');
        Route::post('/store/question/{id_test}', [TestController::class, 'store_question'])->name('store_question');
        Route::DELETE('/delete_question/{id_test}', [TestController::class, 'delete_question'])->name('question.delete');
        Route::get('/edit_question/{id_question}/{id_test}/{id_course}', [TestController::class, 'question_edit'])->name('question.edit');
        Route::post('/update_question/{id_test}/{id_question_old}', [TestController::class, 'question_update'])->name('question.update');
        Route::post('/search', [TestController::class, 'search'])->name('search');
        Route::get('/update_category_test', [TestController::class, 'update_category_test'])->name('update_category_test');
    });
    Route::prefix('/score')->name('score.')->group(function () {
        Route::get('index', [ScoreController::class, 'index'])->name('index')->middleware('myweb.auth:score.show');
        Route::get('create', [ScoreController::class, 'create'])->name('create')->middleware('myweb.auth:score.create');
        Route::post('store', [ScoreController::class, 'store'])->name('store')->middleware('myweb.auth:score.create');
        Route::get('/dots/{id}', [ScoreController::class, 'dots'])->name('dots')->middleware('myweb.auth:score.point');
        Route::post('/point', [ScoreController::class, 'point'])
            ->name('point')->middleware('myweb.auth:scores.point');
        Route::get('/getStudent/{id}', [ScoreController::class, 'getStudent'])->name('getStudent');
        Route::get('/dots/{id}', [ScoreController::class, 'dots'])->name('dots');
    });

    require 'users.php';
    require 'roles.php';
});

Route::post('/getQuestion', [TestController::class, 'getQuestion'])->name('getquestion');
