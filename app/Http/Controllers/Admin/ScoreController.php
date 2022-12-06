<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Score\ScoreRequest;
use App\Models\ClassStudy;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use App\Models\UserTest;
use App\Models\UserTestAnswer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Yajra\DataTables\Facades\DataTables;

class ScoreController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('admin.score.index');
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getScoreData()
    {
        $userTests = UserTest::select([
            'id',
            'user_id',
            'status',
            'score',
            'test_id',
        ])->with('test', 'user');

        return DataTables::of($userTests)
            ->editColumn('status', function ($userTest) {
                if ($userTest->status == 0) return 'Chưa làm';
                if ($userTest->status == 1) return 'Đã làm';
            })
            ->editColumn('test_id', function ($userTest) {
                return $userTest->test->title;
            })
            ->editColumn('user_id', function ($userTest) {
                $firstName  = $userTest->user->first_name;
                $lastName   = $userTest->user->last_name;
                $name       = $firstName . ' ' . $lastName;
                return $name;
            })->editColumn('score', function ($userTest) {
                $score      = $userTest->score;
                $totalScore = $userTest->test->total_score;
                return "$score / $totalScore";
            })
            ->addColumn('actions', function ($userTest) {
                return view('admin.score.actions', ['row' => $userTest])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $tests      = Test::select(['id', 'title'])->get();
        $classes    = ClassStudy::select(['id', 'name'])->get();
        $users      = User::all();
        return view('admin.score.create', compact('tests', 'users', 'classes'));
    }

    /**
     * @param ScoreRequest $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(ScoreRequest $request)
    {
        $userTestItems      = $request->except('_token');
        try {
            $studentIds     = $userTestItems['student_id'];
            $testIds        = $userTestItems['test_id'];
            foreach ($studentIds as $studentId) {
                $userTest   = UserTest::where('user_id', $studentId)->where('test_id', $testIds)->first();
                if ($userTest) {
                    return redirect(route('score.index'))
                        ->with('message', 'Thêm bài test thất bại, học viên ' . $studentId . ' đã được chỉ định bài test này!')
                        ->with('type_alert', "danger");
                }
                $student    = User::find($studentId);
                $student->tests()->attach($userTestItems['test_id']);
            }
        } catch (\Throwable $t) {
            throw new ModelNotFoundException();
        }
        return redirect(route('score.index'))
            ->with('message', 'Thêm bài test thành công !')
            ->with('type_alert', "success");
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function marking(Request $request, $id)
    {
        $user_test = UserTest::find($id);
        if($user_test){
            $userTestAnswers = UserTestAnswer::select([
                'questions.content',
                'questions.id',
                'questions.score',
                'user_test.id as user_test_id',
                'user_test_answers.answer'
            ])
                ->where('user_test_id', $id)
                ->LeftJoin('user_tests as user_test', 'user_test_id', 'user_test.id')
                ->join('questions', 'question_id', 'questions.id')
                ->where('questions.category', 0)
                ->get();
            return view('admin.score.marking', compact('userTestAnswers'));
        }
        return abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function storingMarks(Request $request)
    {
        $userTestItems = $request->except('_token');
        $score = 0;
        $marks = $request->get('marks');

        if ($marks) {
            foreach ($marks as $question_id => $givenMark) {
                $question = Question::find($question_id);
                if ($givenMark > $question->score) {
                    $score += $question->score;
                } else {
                    $score += $givenMark;
                }
            }
        }

        $test_user = UserTest::find($userTestItems['userTestId']);
        $user_test_answer = UserTestAnswer::select([
            'questions.score',
            'user_test_answers.correct'
        ])
            ->where('user_test_id', $userTestItems['userTestId'])
            ->join('questions', 'question_id', 'questions.id')
            ->where('questions.category', '!=', 0)
            ->get();
        if ($user_test_answer->count()) {
            foreach ($user_test_answer as $uta) {
                if ($uta->correct == 1) {
                    $score += $uta->score;
                }
            }
        }
        $test_user->score = $score;
        $test_user->save();
        return redirect(route('score.index'))
            ->with('message', 'Chấm điểm thành công !')
            ->with('type_alert', "success");
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getStudent($id)
    {
        $users = ClassStudy::find($id)->users;
        $output = '';
        foreach ($users as $row) {
            $output .= '<option name ="student_' . $row->id . '"  value="' . $row->id . '">' . $row->first_name . '</option>';
        }
        return Response($output);
    }
}
