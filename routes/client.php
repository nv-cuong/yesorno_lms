<?php

use App\Http\Controllers\Admin\LessonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CourseDetailController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Client\UserTestController;
use App\Http\Controllers\UserNotificationController;

Route::get('/courses', [HomeController::class, 'courses'])
    ->name('courses')->middleware('myweb.auth');
Route::get('/courses-filter', [HomeController::class, 'courseFilter'])
    ->name('courses.filter')->middleware('myweb.auth');
Route::get('/search', [SearchController::class, 'search'])
    ->name('search')->middleware('myweb.auth');
Route::get('/courses/detail/{slug}', [CourseDetailController::class, 'courseDetail'])
    ->name('detail')->middleware('myweb.auth');
Route::get('/profile', [HomeController::class, 'profile'])
    ->name('profile')->middleware('myweb.auth');
Route::get('/contact', [HomeController::class, 'contact'])
    ->name('contact')->middleware('myweb.auth');
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

Route::get('/personal/lesson/{slug}', [CourseDetailController::class, 'personalLesson'])
    ->name('personal.lesson')->middleware('myweb.auth');
Route::post('/personal/lessonprogress/{slug}', [CourseDetailController::class, 'lessonProgress'])
    ->name('lessonProgress')->middleware('myweb.auth');
Route::post('/personal/detach', [CourseDetailController::class, 'detach'])
    ->name('post.personal.detach')->middleware('myweb.auth');
Route::get('/downloadFile/{id}', [LessonController::class, 'downloadFile'])
    ->name('lesson.download')->middleware('myweb.auth');
Route::get('/doTest/{id}', [UserTestController::class, 'doTest'])
    ->name('doTest')->middleware('myweb.auth');
Route::get('/index/final/{courseId}', [UserTestController::class, 'finalTest'])
    ->name('finalTest');

Route::post('/sendTest/{id}', [UserTestController::class, 'sendTest'])
    ->name('send.test')->middleware('myweb.auth');
Route::get('/user_tests', [UserTestController::class, 'test_user'])
    ->name('test_users')->middleware('myweb.auth');
Route::get('/user_tests/detail/{id}', [UserTestController::class, 'user_tests_detail'])
    ->name('user_tests_detail')->middleware('myweb.auth');

//Profile users
Route::post('/uploadImg', [HomeController::class, 'uploadImg'])
    ->name('uploadImg')->middleware('myweb.auth');
Route::get('/profile/update', [HomeController::class, 'profileUpdate'])
    ->name('profile.update')->middleware('myweb.auth');
Route::put('/profile/saveUpdate/{id}', [HomeController::class, 'saveProfileUpdates'])
    ->name('profile.saveUpdate')->middleware('myweb.auth')->middleware('myweb.auth');

Route::get('/notifications/{id}', [UserNotificationController::class, 'show'])
    ->name('notification.show')->middleware('myweb.auth');
