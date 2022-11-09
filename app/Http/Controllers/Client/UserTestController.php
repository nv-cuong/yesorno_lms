<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\UserTest;
use App\Models\UserTestAnswer;
use App\Models\Answer;
use App\Models\Test;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Carbon\Carbon;

class UserTestController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function doTest(Request $request, $id)
    {
        $userTest       = UserTest::find($id);
        $test           = $userTest->test;
        $score          = $userTest->score;
        $startedTime    = $userTest->started_at;
        $submittedTime  = $userTest->submitted_at;
        $status         = $userTest->status;
        $questions      = $test->question;
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
        $questions      = 0;

        if ($request->get('answers')) {
            foreach ($testUserItems['answers'] as $key  => $answerId) {
                $questionId     = Answer::find($answerId)->question->id;
                $question       = Answer::find($answerId)->question;
                $answers_item   = Answer::find($answerId);

                if ($answers_item->checked == 0) {
                    $check = 0;
                } else {
                    $check = 1;
                }
                if ($questions != $questionId) {
                    $answers[$questionId] = [
                        'question_id'   => $questionId,
                        'answer'        => $answers_item->id,
                        'correct'       => $check
                    ];
                } else {
                    if ($answers[$questionId]['answer']) {
                        if ($check == 0) {
                            $answers[$questionId]['correct'] =  0;
                        }
                        $answers[$questionId]['answer'] = $answers[$questionId]['answer'] . "," . $answers_item->id;
                    }
                }
                if ($check == 1) {
                    $testScore += $question->score;
                }
                $questions = $questionId;
            }
        }

        if ($request->get('tfQuest')) {
            foreach ($request->get('tfQuest') as $questionId => $answerId) {
                $question   = Question::find($questionId);
                $correct    = Question::where('id', $questionId)
                    ->where('answer', $answerId)
                    ->count() > 0;
                $answers[]  = [
                    'question_id'   => $questionId,
                    'answer'        => $answerId,
                    'correct'       => $correct
                ];
                if ($correct) {
                    $testScore += $question->score;
                }
            }
        }

        $userTest->status       = 1;
        $userTest->score        = $testScore;
        $userTest->submitted_at = $submittedTime;
        $userTest->save();

        if ($request->get('essayQuest')) {
            foreach ($request->get('essayQuest') as $questionId => $answerId) {
                $answers[]  = [
                    'question_id'   => $questionId,
                    'answer'        => $answerId,
                ];
            }
            $userTest->score = 0;
        }
        $userTest->answers()->createMany($answers);
        $userTest->save();
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
}
