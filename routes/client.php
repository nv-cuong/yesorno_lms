<?php

use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CourseDetailController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Client\StudentCoursesController;
use App\Http\Controllers\Client\TestCoursesController;
use App\Http\Controllers\Client\UserTestController;

Route::get('/courses', [HomeController::class, 'courses'])
    ->name('courses');
Route::get('/courses-filter', [HomeController::class, 'courseFilter'])
    ->name('courses.filter');
Route::get('/search', [SearchController::class, 'search'])
    ->name('search');
Route::get('/courses/detail/{slug}', [CourseDetailController::class, 'courseDetail'])
    ->name('detail');
Route::get('/personal', [HomeController::class, 'personal'])
    ->name('personal')
    ->middleware('myweb.auth');
Route::get('/contact', [HomeController::class, 'contact'])
    ->name('contact');
Route::get('/attach', [CourseDetailController::class, 'attach'])
    ->name('post.attach')->middleware('myweb.auth');
Route::get('/detach', [CourseDetailController::class, 'detach'])
    ->name('post.detach')->middleware('myweb.auth');
Route::get('/attach-class', [CourseDetailController::class, 'attachClass'])
    ->name('post.attach.class')->middleware('myweb.auth');
Route::get('/detach-class', [CourseDetailController::class, 'detachClass'])
    ->name('post.detach.class')->middleware('myweb.auth');
Route::get('/courses/lesson/{id}', [CourseDetailController::class, 'showLesson'])
    ->name('learning')->middleware('myweb.auth');

Route::get('/personal/courses/{slug}', [StudentCoursesController::class, 'personalCourse'])
    ->name('personal.course')->middleware('myweb.auth');
Route::get('/personal/lesson/{slug}', [StudentCoursesController::class, 'personalLesson'])
    ->name('personal.lesson')->middleware('myweb.auth');
Route::post('/personal/lessonprogress/{slug}', [StudentCoursesController::class, 'lessonProgress'])
    ->name('lessonProgress')->middleware('myweb.auth');
Route::post('/personal/detach', [StudentCoursesController::class, 'detach'])
    ->name('post.personal.detach')->middleware('myweb.auth');
Route::get('/downloadFile/{id}', [LessonController::class, 'downloadFile'])
    ->name('lesson.download')->middleware('myweb.auth');
Route::get('/doTest/{id}', [UserTestController::class, 'doTest'])
    ->name('doTest')->middleware('myweb.auth');

Route::get('/show_makes', [TestCoursesController::class, 'show_make'])
    ->name('show.make')->middleware('myweb.auth');
Route::get('/index/make_test/{id_test}', [TestCoursesController::class, 'index_make_test'])
    ->name('index_make')->middleware('myweb.auth');
Route::post('/index/save_maked/{id_test}/{id_user}', [TestCoursesController::class, 'save_maked'])
    ->name('save_maked')->middleware('myweb.auth');
Route::get('/index/save_maked/{id_test}/{id_user}', [TestCoursesController::class, 'save_maked'])
    ->name('save_maked_get')->middleware('myweb.auth');
Route::get('/index/show_maked_test/{id_user}/{id_test}', [TestController::class, 'view_maked'])
    ->name('view_maked')->middleware('myweb.auth');
Route::get('/index/random/{id_course}', [TestCoursesController::class, 'random_test'])
    ->name('random_test');

Route::post('/sendTest/{id}', [UserTestController::class, 'sendTest'])
    ->name('send.test')->middleware('myweb.auth');
Route::get('/user_tests', [UserTestController::class, 'test_user'])
    ->name('test_users')->middleware('myweb.auth');
Route::get('/user_tests/detail/{id}', [UserTestController::class, 'user_tests_detail'])
    ->name('user_tests_detail')->middleware('myweb.auth');

Route::post('/uploadImg', [HomeController::class, 'uploadImg'])
    ->name('uploadImg')->middleware('myweb.auth');
