<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Notification;
use App\Models\User;
use App\Models\Question;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{



    public function compose(View $view)
    {
        $user = Sentinel::getUser();
        if ($user) {
            $user_tests = UserTest::where('user_id', $user->id)->where('status', 0)->get();
            $count_user_tests = $user_tests->count();
            $view->with('user_tests', $user_tests);
            $view->with('count_user_tests', $count_user_tests);
        }
    }


    public function index()
    {



        $courses = Course::select([
            'id',
            'title',
            'slug',
            'status',
            'description',
            'begin_date',
            'end_date',
            'image'

        ])
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();

        $classes = ClassStudy::select([
            'id'
        ]);
        return view('client.modules.home', compact('courses', 'classes'));
    }

    public function courses(Request $request)
    {
        if ($request->sort == 'old') {
            $name = 'created_at';
            $sort = 'ASC';
        } elseif ($request->sort == 'new') {
            $name = 'created_at';
            $sort = 'DESC';
        } elseif ($request->sort == 'name') {
            $name = 'title';
            $sort = 'ASC';
        } else {
            $name = 'created_at';
            $sort = 'DESC';
        }
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'status',
            'description',
            'begin_date',
            'end_date',
            'image'
        ])
            ->with('units', 'users')
            ->orderBy($name, $sort)
            // ->where('status', $filter)
            ->paginate(6);
        $courseTotal = Course::select([
            'id',
        ]);
        return view('client.modules.courses', compact('courses', 'courseTotal'));
    }

    public function courseFilter(Request $request)
    {
        if ($request->filter == 'free') {
            $filter = '0';
        } elseif ($request->filter == 'pro') {
            $filter = '1';
        }
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'status',
            'description',
            'begin_date',
            'end_date',
            'image'
        ])
            ->with('units', 'users')
            ->where('status', $filter)
            ->paginate(6);
        $courseTotal = Course::select([
            'id',
        ]);
        return view('client.modules.courses', compact('courses', 'courseTotal'));
    }

    public function personal(Request $request)
    {
        $getUser = Sentinel::getUser();
        $id = $getUser->id;
        $student = User::where('id', $id)->first();;
        $courses = User::find($id)->courses()->where("user_id", $id)->paginate(3);
        $lessons = User::find($id)->lessons()->where([["user_id", $id], ['status', 1]])->count();
        $courseLesson = Lesson::select()
            ->leftJoin('units AS u', 'u.id', 'lessons.unit_id')
            ->join('courses AS c', 'c.id', 'u.course_id')
            ->where('c.status', 1)
            ->count();
            if($courseLesson != 0){
                $progress = ceil(($lessons*100)/$courseLesson);
            }
            else $progress = 0;
        return view('client.modules.personal', compact('student', 'progress', 'courses'));
    }


    public function contact()
    {
        return view('client.modules.contact');
    }

    public function search(Request $request)
    {
        $output = '';
        $course = Course::where('title', 'LIKE', '%' . $request->keyword . '%')->get();
    }
    public function notifications()
    {
        $user = Sentinel::getUser();
        $notifications = Notification::select(
            'notifications.id',
            'content'
        )
            ->join('user_notifications as un', 'un.notification_id', 'notifications.id')
            ->where('un.user_id', $user->id);
        return view('client.modules.home', compact('notifications', 'user'));
    }
    public function doTest(Request $request, $id)
    {


        $test = UserTest::find($id)->test;
        $user_test = $id;
        $questions = $test->question;
        $score = UserTest::find($id)->score;
        return view('client.modules.do_tests', compact('questions', 'user_test', 'test', 'score'));
    }

    public function sendTest(Request $request, $id)
    {
        $test_user_item = $request->except('_token');

        //dd( $test_user_item['questions']);
        $test_users = UserTest::find($id);
        $answers = [];
        $test_score = 0;
        $questions = 0;
        if ($test_user_item['answers']) {



            foreach ($test_user_item['answers'] as $key  => $answer_id) {


                $question_id = Answer::find($answer_id)->question->id;
                $question = Answer::find($answer_id)->question;
                $answers_item = Answer::find($answer_id);

                if ($answers_item->checked == 0) {
                    $check = 0;
                } else {
                    $check = 1;
                }





                if ($questions != $question_id) {

                    $answers[$question_id] = [
                        'question_id' => $question_id,
                        'answer' =>  $answers_item->id,
                        'correct' => $check
                    ];
                } else {

                    if ($answers[$question_id]['answer']) {
                        if ($check == 0) {
                            $answers[$question_id]['correct'] =  0;
                        }
                        $answers[$question_id]['answer'] = $answers[$question_id]['answer'] . "," . $answers_item->id;
                    }
                }


                if ($check == 1) {

                    $test_score += $question->score;
                }
                $questions = $question_id;
            }
        }
        if ($request->get('true')) {
            foreach ($request->get('true') as $question_id => $answer_id) {
                $question = Question::find($question_id);

                $correct = Question::where('id', $question_id)
                    ->where('answer', $answer_id)
                    ->count() > 0;

                $answers[] = [
                    'question_id' => $question_id,
                    'answer' => $answer_id,
                    'correct' =>  $correct
                ];
                if ($correct) {
                    $test_score += $question->score;
                }
            }
        }
        $test_users->status = 1;
        $test_users->score =  $test_score;

        $test_users->save();

        if ($request->get('essay')) {
            foreach ($request->get('essay') as $question_id => $answer_id) {
                $answers[] = [
                    'question_id' => $question_id,
                    'answer' => $answer_id,

                ];
            }
            $test_users->score = '';
        }

        $test_users->answers()->createMany($answers);
        $test_users->save();
    }

    public function test_user()
    {
        $user = Sentinel::getUser();

        $user_test_status = UserTest::where('user_id', $user->id)->where('status', 1)->get();

        return view('client.modules.user_test', compact('user_test_status'));
    }
}
