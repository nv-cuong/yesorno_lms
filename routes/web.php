<?php

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ScoreController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/courses', [HomeController::class, 'courses'])
    ->name('courses');
Route::get('/courses/detail/{slug}', [HomeController::class, 'courseDetail'])
    ->name('detail');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('contact');
    Route::get('/personal/{id}', [HomeController::class, 'personal'])
    ->name('personal');
    Route::get('/doTest/{id}', [HomeController::class, 'doTest'])
    ->name('doTest');

    Route::post('/sendTest/{id}', [HomeController::class, 'sendTest'])
    ->name('send.test');
    Route::get('/test_users', [HomeController::class, 'test_user'])
    ->name('test_users');


Route::get('/login', [LoginController::class, 'login'])
    ->name('login');
Route::post('/login', [LoginController::class, 'postLogin'])
    ->name('login.post');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('', [RegisterController::class, 'processRegistration'])->name('register.action');

Route::prefix('admin')
    ->middleware('myweb.auth')
    ->group(function () {
        
        Route::get('/downloadFile', [LessonController::class, 'downloadFile']);

        Route::get('/dashboard', [IndexController::class, 'index'])
            ->name('dashboard');
            
        Route::prefix('/questions')->name('question.')->group(function () {
            Route::get('index', [QuestionController::class, 'index'])->name('index');
            Route::get('getData', [QuestionController::class, 'getData'])->name('getData');
            Route::get('create', [QuestionController::class, 'create'])->name('create');
            Route::post('store', [QuestionController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [QuestionController::class, 'edit'])
                ->name('edit');
            Route::post('/edit/{id}', [QuestionController::class, 'update'])
                ->name('update');
            Route::delete('/delete', [QuestionController::class, 'destroy'])
                ->name('delete');
            Route::get('/answer/{id}', [QuestionController::class, 'show_answser'])
                ->name('answer');
        });
        // Conflict thì để cái này lại nhé | Đức
        Route::resource('class', ClassController::class);
        Route::delete('/class/delete', [ClassController::class, 'destroy'])
            ->name('class.delete');
        // Đức
        Route::prefix('students')->group(function () {
            Route::get('/', [StudentController::class, 'index'])
                ->name('students');
            Route::get('/edit/{id}', [StudentController::class, 'edit'])
                ->name('student.edit');
            Route::post('/edit/{id}', [StudentController::class, 'update'])
                ->name('student.update');
            Route::delete('/delete', [StudentController::class, 'destroy'])
                ->name('student.delete');
            Route::get('/class/{id}', [StudentController::class, 'showClass'])
                ->name('student.class');
            Route::get('/course/{id}', [StudentController::class, 'showCourse'])
                ->name('student.course');
            Route::get('/statistic/{id}', [StudentController::class, 'showStatistic'])
                ->name('student.statistic');
        });

        Route::prefix('/courses')->name('course.')->group(function () {
            Route::get('index', [CourseController::class, 'index'])->name('index');
            Route::get('/showCourse/{id}', [CourseController::class, 'showCourse'])->name('detail');
            // Route::get('getData', [CourseController::class, 'getData'])->name('getData');
            Route::get('createCourse', [CourseController::class, 'createCourse'])->name('create');
            Route::post('storeCourse', [CourseController::class, 'storeCourse'])->name('store');
            Route::get('/editCourse/{id}', [CourseController::class, 'editCourse'])->name('edit');
            Route::post('/editCourse{id}', [CourseController::class, 'updateCourse'])->name('update');
            Route::delete('/destroyCourse', [CourseController::class, 'destroyCourse'])->name('delete');
            Route::get('/showTest/{id}', [CourseController::class, 'showTest'])->name('test');
        });

        Route::prefix('/units')->name('unit.')->group(function () {
            Route::get('/showUnit/{id}', [UnitController::class, 'showUnit'])->name('detail');
            // Route::get('getData', [UnitController::class, 'getData'])->name('getData');
            Route::get('createUnit/{course_id}', [UnitController::class, 'createUnit'])->name('create');
            Route::post('storeUnit', [UnitController::class, 'storeUnit'])->name('store');
            Route::get('/editUnit/{id}', [UnitController::class, 'editUnit'])->name('edit');
            Route::post('/editUnit{id}', [UnitController::class, 'updateUnit'])->name('update');
            Route::delete('/destroyUnit/{course_id}', [UnitController::class, 'destroyUnit'])->name('delete');
        });

        Route::prefix('/lessons')->name('lesson.')->group(function () {
            Route::get('/showLesson/{id}', [LessonController::class, 'showLesson'])->name('detail');
            // Route::get('getData', [UnitController::class, 'getData'])->name('getData');
            Route::get('createLesson/{unit_id}', [LessonController::class, 'createLesson'])->name('create');
            Route::post('storeLesson', [LessonController::class, 'storeLesson'])->name('store');
            Route::get('/editLesson/{id}', [LessonController::class, 'editLesson'])->name('edit');
            Route::post('/editLesson{id}', [LessonController::class, 'updateLesson'])->name('update');
            Route::delete('/destroyLesson/{unit_id}', [LessonController::class, 'destroyLesson'])->name('delete');
            Route::get('/downloadFile{file_name}', [LessonController::class, 'downloadFile'])->name('download');
        });

        Route::prefix('/test')->name('test.')->group(function () {
            Route::get('/index', [TestController::class, 'index'])->name('index');
            Route::get('/create', [TestController::class, 'create'])->name('create');
            Route::post('/store', [TestController::class, 'store'])->name('store');
            Route::DELETE('/delete', [TestController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [TestController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [TestController::class, 'update'])->name('update');
            Route::get('/view/{id}', [TestController::class, 'view'])->name('view');
            Route::get('/create/{id_course}/{id_test}/{arr_quest}', [TestController::class, 'createquestion'])->name('create_question');
            Route::post('/store/question/{id_test}', [TestController::class, 'store_question'])->name('store_question');
            Route::DELETE('/delete_question/{id_test}', [TestController::class, 'delete_question'])->name('question.delete');
            Route::get('/edit_question/{id_question}/{id_test}/{id_course}', [TestController::class, 'question_edit'])->name('question.edit');
            Route::post('/update_question/{id_test}/{id_question_old}', [TestController::class, 'question_update'])->name('question.update');
            Route::post('/search', [TestController::class, 'search'])->name('search');
        });
        Route::prefix('/score')->name('score.')->group(function () {
            Route::get('index', [ScoreController::class, 'index'])->name('index');
            Route::get('create', [ScoreController::class, 'create'])->name('create');
            Route::post('store', [ScoreController::class, 'store'])->name('store');
            
            Route::get('/dots/{id}', [ScoreController::class, 'dots'])
                ->name('dots');
            Route::post('/point', [ScoreController::class, 'point'])
                ->name('point');
            Route::get('/ajax/student/{id}', [ScoreController::class, 'ajaxstudent'])
                ->name('ajaxstudent');
            
        });

        require 'users.php';
        require 'roles.php';
    });

require 'auth.php';
Route::post('/getQuestion', [TestController::class, 'getQuestion'])->name('getquestion');
Route::post('/getStudent', [ScoreController::class, 'getStudent'])->name('getStudent');
?>