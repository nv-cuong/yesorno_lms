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
        $questions      = '';

        // Multiple choice questions
        if (isset($testUserItems['multiQuest'])) {
            foreach ($testUserItems['multiQuest'] as $key  => $givenAnswer) {
                $answerItem     = Answer::find($givenAnswer);
                $questionId     = $answerItem->question->id;
                $question       = $answerItem->question;

                if ($answerItem->checked == 0) {
                    $check = 0;
                } else {
                    $check = 1;
                }

                if ($questions != $questionId) {
                    $answers[$questionId] = [
                        'question_id'   => $questionId,
                        'answer'        => $answerItem->id,
                        'correct'       => $check
                    ];
                    if ($answerItem->checked == 1) {
                        $testScore += $question->score;
                    }

                } else {
                    $testScore -= $question->score;
                    if ($answerItem->checked == 0) {
                        $answers[$questionId]['correct'] = 0;
                    }
                    $answers[$questionId]['answer'] = $answers[$questionId]['answer'] . "," . $answerItem->id;
                    if ($answers[$questionId]['correct'] == 1) {
                        $testScore += $question->score;
                    }
                }
                $questions = $questionId;
            }
        }

        // True - False questions
        $tfQuest = $request->input('tfQuest', []);
        foreach ($tfQuest as $questionId => $givenAnswer) {
            $question   = Question::find($questionId);
            $correct    = Question::where('id', $questionId)
                ->where('answer', $givenAnswer)
                ->count() > 0;
            $answers[]  = [
                'question_id'   => $questionId,
                'answer'        => $givenAnswer,
                'correct'       => $correct
            ];
            if ($correct) {
                $testScore += $question->score;
            }
        }
        
        // Essay questions
        $essayQuest = $request->input('essayQuest', []);
        if ($essayQuest) {
            foreach ($essayQuest as $questionId => $givenAnswer) {
                $answers[]  = [
                    'question_id'   => $questionId,
                    'answer'        => $givenAnswer,
                ];
            }
            $testScore = '';
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

        return view('client.modules.user_tests_detail', compact('user_test_answers'));
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
}
