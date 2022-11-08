<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Score\ScoreRequest;
use App\Models\Answer;
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
     * @return DataTables
     */
    public function getScoreData()
    {
        $usertests = UserTest::select([
            'id',
            'user_id',
            'status',
            'score',
            'test_id',
        ])->with('test', 'user');

        // @phpstan-ignore-next-line
        return DataTables::of($usertests)
            ->editColumn('status', function ($usertest) {
                if ($usertest->status == 0) return 'Chưa làm';
                if ($usertest->status == 1) return 'Đã làm';
            })
            ->editColumn('test_id', function ($usertest) {
                return $usertest->test->title;
            })
            ->editColumn('user_id', function ($usertest) {
                $lastname = $usertest->user->last_name;
                $firstname = $usertest->user->first_name;
                $name = $lastname.' '.$firstname;
                return $name;
            })
            ->addColumn('actions', function ($usertest) {
                return view('admin.score.actions', ['row' => $usertest])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $tests = Test::select(['id', 'title'])->get();
        $classes = ClassStudy::select(['id', 'name'])->get();
        $users = User::all();
        return view('admin.score.create', compact(['tests', 'users', 'classes']));
    }

    /**
     * @param ScoreRequest $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(ScoreRequest $request)
    {
        $test_user_item = $request->except('_token');

        try {
            $student_id = $test_user_item['student_id'];
            foreach ($student_id as $user_id) {

                $user  = User::find($user_id);
                // dd($user);

                // $user->tests()->attach();
                $user->tests()->attach($test_user_item['test_id']);
            }
        } catch (\Throwable $t) {

            throw new ModelNotFoundException();
        }

        return redirect(route('score.index'))->with('message', 'Thêm bài test thành công !')->with('type_alert', "success");
    }




    /**
     * @param Request $request
     * @param unknown $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function dots(Request $request, $id)
    {
        $user_test = UserTest::find($id);

        $user_test_answers = UserTestAnswer::select([

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

        return view('admin.score.dots', compact('user_test_answers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function point(Request $request)
    {
        $test_user_item = $request->except('_token');

        $score = 0;
        if ($request->get('true')) {
           
            foreach ($request->get('true')  as $question_id  => $answer_value) {
                $question = Question::find($question_id);
                if ($answer_value > $question->score) {
                    $score += $question->score;
                } else {
                    $score += $answer_value;
                }
            }
        }

        $test_user = UserTest::find($test_user_item['user_test_id']);
        $user_test_answer = UserTestAnswer::select([
            'questions.score',
            'user_test_answers.correct'
        ])
            ->where('user_test_id', $test_user_item['user_test_id'])
            ->join('questions', 'question_id', 'questions.id')
            ->where('questions.category', '!=', 0)
            ->get();
        if ($user_test_answer) {
            foreach ($user_test_answer as $uta) {
                if ($uta->correct == 1) {
                    $score += $uta->score;
                }
            }
        }
        $test_user->score = $score;
        $test_user->save();
        return redirect(route('score.index'))->with('message', 'Chấm điểm thành công !')->with('type_alert', "success");
    }

    
    /**
     * @param int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getStudent($id)
    {

        $users = ClassStudy::find($id)->users;
        
        
        foreach ($users as $row) {

            $output = '<option name ="student_' . $row->id . '"  value="' . $row->id . '">' . $row->first_name . '</option>';
           
            
        }
        
        return Response($output);
    }
}
