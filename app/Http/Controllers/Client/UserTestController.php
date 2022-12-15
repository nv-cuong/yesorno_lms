<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;

use App\Models\Test;
use App\Models\User;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\UserTest;
use App\Models\UserTestAnswer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class UserTestController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function doTest($id)
    {
        $userTest       = UserTest::find($id);
        $test           = $userTest->test;
        $score          = $userTest->score;
        $startedTime    = $userTest->started_at;
        $submittedTime  = $userTest->submitted_at;
        $status         = $userTest->status;
        $questions      = $test->questions;
        $time           = $test->time;

        if ($submittedTime || $status == 1) {
            return view('client.modules.user_test_result', compact('userTest'));
        }

        if ($startedTime == null) {
            $startedTime = now();
            $userTest->started_at = $startedTime;
            $userTest->save();
        } else {
            $passedSeconds  = now()->diffInSeconds($startedTime);
            if ($passedSeconds >= $test->time * 60) {
                return view('client.modules.user_test_result', compact('userTest'));
            }
        }
        return view('client.modules.do_tests', compact('questions', 'id', 'test', 'score', 'startedTime', 'time'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function sendTest(Request $request, $id)
    {
        $submittedTime  = now();
        $testUserItems  = $request->except('_token');
        $userTest       = UserTest::find($id);

        if ($userTest->submitted_at || $userTest->status == 1) {
            return view('client.modules.user_test_result', compact('userTest'));
        }

        $answers        = [];
        $testScore      = 0;

        // Multiple choice questions
        if (isset($testUserItems['multiQuest'])) {
            $multiQuest = $testUserItems['multiQuest'];
            foreach ($multiQuest as $key  => $givenAnswers) {
                $question = Question::where('id', $key)
                    ->withCount(['answers' => function ($query) {
                        return $query->where('checked', 1);
                    }])->first();
                $count = 0;
                $answers[$key] = [
                    'question_id'   => $key,
                    'answer'        => '',
                    'correct'       => 0
                ];
                foreach ($givenAnswers as $givenAnswer) {
                    $answerItem     = Answer::find($givenAnswer);
                    $questionId     = $key;

                    if ($answerItem->checked == 0) {
                        $check = 0;
                        $count--;
                    } else {
                        $check = 1;
                        $count++;
                    }
                    if ($answers[$questionId]['answer'] == '')
                        $answers[$questionId]['answer'] = $givenAnswer;
                    else
                        $answers[$questionId]['answer'] = $answers[$questionId]['answer'] . "," . $answerItem->id;
                }
                if ($question->answers_count == $count) {
                    $testScore += $question->score;
                    $answers[$questionId]['correct'] = 1;
                }
            }
        }

        // True - False questions
        if (isset($testUserItems['tfQuest'])) {
            $tfQuest = $testUserItems['tfQuest'];
            foreach ($tfQuest as $questionId => $givenAnswer) {
                $question   = Question::find($questionId);
                $correct    = $question->answer == $givenAnswer  ? 1 : 0;
                $answers[$questionId]  = [
                    'question_id'   => $questionId,
                    'answer'        => $givenAnswer,
                    'correct'       => $correct
                ];
                if ($correct) {
                    $testScore += $question->score;
                }
            }
        }

        // Essay questions
        if (isset($testUserItems['essayQuest'])) {
            $essayQuest = $testUserItems['essayQuest'];
            foreach ($essayQuest as $questionId => $givenAnswer) {
                $answers[$questionId]  = [
                    'question_id'   => $questionId,
                    'answer'        => $givenAnswer,
                ];
            }
            $testScore = '';
        }

        //If user not answered
        $questions = $userTest->test->questions;
        foreach($questions as $question) {
            if(!array_key_exists($question->id, $answers)){
                $answers[$question->id] = [
                    'question_id'   => $question->id,
                    'answer'        => '',
                    'correct'       => 0,
                ];
            }
        }
        
        $userTest->status       = 1;
        $userTest->score        = $testScore;
        $userTest->submitted_at = $submittedTime;
        $userTest->save();
        $userTest->answers()->createMany($answers);
        return view('client.modules.user_test_result', compact('userTest'));
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function test_user()
    {
        $user = Sentinel::getUser();

        $user_test_status = UserTest::select([
            'user_tests.id',
            'title',
            'score'
        ])
            ->where('user_id', $user->id)->where('status', 1)
            ->join('tests', 'test_id', 'tests.id')
            ->get();
        return view('client.modules.user_test', compact('user_test_status'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function user_tests_detail($id)
    {
        $user_test_answers = UserTestAnswer::select([
            'questions.content',
            'questions.id',
            'questions.category',
            'questions.score',
            'user_test_answers.answer',
            'user_test_answers.correct'
        ])
            ->where('user_test_id', $id)
            ->join('questions', 'question_id', 'questions.id')
            ->get();
        $user_test = UserTest::find($id);
        
        return view('client.modules.user_tests_detail', compact('user_test_answers', 'user_test'));
    }

    /**
     * @param int $courseId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finalTest($courseId)
    {
        $course     = Course::find($courseId);
        $test       = $course->tests()
            ->where('category', 0)
            ->first();
        if ($test) {
            $testId     = $test->id;
            $userId     = Sentinel::getUser()->id;
            $user       = User::find($userId);

            $userTest   = UserTest::where('user_id', $userId)
                ->where('test_id', $testId)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($userTest == null) {
                $user->tests()->attach($testId);
            }
            return redirect()->route('doTest', [$userTest->id]); 
        }
        return abort(404);
    }
}
