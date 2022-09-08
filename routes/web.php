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
use App\Http\Controllers\Client\LessonProgress;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CourseDetailController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Client\StudentCoursesController;
use App\Http\Controllers\Client\TestCoursesController;
use App\Http\Controllers\Client\UserTestController;
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
Route::get('/notifications', [HomeController::class, 'notifications'])
    ->name('notifications');
Route::get('/courses', [HomeController::class, 'courses'])
    ->name('courses');
Route::get('/courses-filter', [HomeController::class, 'courseFilter'])
    ->name('courses.filter');
Route::get('/search', [SearchController::class, 'search'])
    ->name('search');
Route::get('/courses/detail/{slug}', [CourseDetailController::class, 'courseDetail'])
    ->name('detail');
Route::get('/personal', [HomeController::class, 'personal'])
    ->name('personal');
Route::get('/contact', [HomeController::class, 'contact'])
    ->name('contact');
Route::get('/attach', [CourseDetailController::class, 'attach'])
    ->name('post.attach');
Route::get('/detach', [CourseDetailController::class, 'detach'])
    ->name('post.detach');
Route::get('/attach-class', [CourseDetailController::class, 'attachClass'])
    ->name('post.attach.class');
Route::get('/detach-class', [CourseDetailController::class, 'detachClass'])
    ->name('post.detach.class');



Route::get('/personal/courses/{slug}', [StudentCoursesController::class, 'personalCourse'])
    ->name('personal.course');
Route::get('/personal/lesson/{slug}', [StudentCoursesController::class, 'personalLesson'])
    ->name('personal.lesson');
Route::post('/personal/lessonprogress/{slug}', [StudentCoursesController::class, 'lessonProgress'])
    ->name('lessonProgress');
Route::post('/personal/detach', [StudentCoursesController::class, 'detach'])
    ->name('post.personal.detach');
Route::get('/downloadFile/{id}', [LessonController::class, 'downloadFile'])
    ->name('lesson.download');
Route::get('/doTest/{id}', [UserTestController::class, 'doTest'])
    ->name('doTest');

Route::get('/show_makes', [TestCoursesController::class, 'show_make'])
    ->name('show.make');
Route::get('/index/make_test/{id_test}', [TestCoursesController::class, 'index_make_test'])
    ->name('index_make');
Route::post('/index/save_maked/{id_test}/{id_user}', [TestCoursesController::class, 'save_maked'])
    ->name('save_maked');
Route::get('/index/save_maked/{id_test}/{id_user}', [TestCoursesController::class, 'save_maked'])
    ->name('save_maked_get');
Route::get('/index/show_maked_test/{id_user}/{id_test}', [TestController::class, 'view_maked'])
    ->name('view_maked');
Route::get('/index/random/{id_course}', [TestCoursesController::class, 'random_test'])
    ->name('random_test');
Route::get('/list_test_maked', [TestCoursesController::class, 'list_test_maked'])
    ->name('list_test_maked');

Route::post('/sendTest/{id}', [UserTestController::class, 'sendTest'])
    ->name('send.test');
Route::get('/user_tests', [UserTestController::class, 'test_user'])
    ->name('test_users')->middleware('myweb.auth');
Route::get('/user_tests/detail/{id}', [UserTestController::class, 'user_tests_detail'])
    ->name('user_tests_detail');

Route::get('/login', [LoginController::class, 'login'])
    ->name('login.form');
Route::post('/login', [LoginController::class, 'postLogin'])
    ->name('login.post');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');


Route::get('/course', function () {
    return view('course');
});
// Route::post('/lessonProgress', [LessonProgressController::class, 'lessonProgress'])->name('lesson.progress');

Route::prefix('admin')

    ->group(function () {

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
        // Conflict thì để cái này lại nhé | Đức
        Route::resource('class', ClassController::class)->middleware('myweb.auth:class.show');
        Route::delete('/class/delete', [ClassController::class, 'destroy'])
            ->name('class.delete')->middleware('myweb.auth:class.destroy');
        // Đức
        Route::prefix('students')->group(function () {
            Route::get('/', [StudentController::class, 'index'])
                ->name('students')->middleware('myweb.auth:student.show');
            Route::get('/edit/{id}', [StudentController::class, 'edit'])
                ->name('student.edit')->middleware('myweb.auth:students.edit');
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
            Route::get('index', [CourseController::class, 'index'])->name('index')->middleware('myweb.auth:courses.show');
            Route::get('/showCourse/{id}', [CourseController::class, 'showCourse'])->name('detail')->middleware('myweb.auth:course.show');
            // Route::get('getData', [CourseController::class, 'getData'])->name('getData');
            Route::get('createCourse', [CourseController::class, 'createCourse'])->name('create')->middleware('myweb.auth:course.create');
            Route::post('storeCourse', [CourseController::class, 'storeCourse'])->name('store')->middleware('myweb.auth:courses.create');
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

require 'auth.php';
Route::post('/getQuestion', [TestController::class, 'getQuestion'])->name('getquestion');

