<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
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
            'description',
            'begin_date',
            'end_date',
            'image'

        ])->take(4)
            ->get();

        $classes = ClassStudy::select([
            'id'
        ]);
        return view('client.modules.home', compact('courses', 'classes'));
    }

    public function courses()
    {

        $courses = Course::select([
            'id',
            'title',
            'slug',
            'description',
            'begin_date',
            'end_date',
            'image'

        ])->paginate(3);
        return view('client.modules.courses', compact('courses'));
    }

    public function courseDetail($slug)
    {
        $course = Course::where('slug', $slug)->first();
        return view('client.modules.course_detail', compact('course'));
    }

    public function personal($id)
    {
        $student = User::where('id', $id)->first();;
        return view('client.modules.personal', compact('student'));
    }


    public function contact()
    {
        return view('client.modules.contact');
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
