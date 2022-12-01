<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TestRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

/**
 * @author sant1ago
 *
 */
class TestController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('admin.tests.index');
    }

    /**
     *
     * @return DataTables
     */
    public function getTestData()
    {
        $tests = Test::select([
            'id',
            'category',
            'total_score',
            'time',
            'title',
            'description',
        ])->with('courses')
            ->withCount('questions');

        return DataTables::of($tests)
            ->editColumn('category', function ($test) {
                if ($test->category == 0) return 'Bài thi cuối khoá';
                if ($test->category == 1) return 'Bài thi';
                return 'Khảo sát';
            })
            ->addColumn('category_name', function ($test) {
                $courseName = '';
                foreach ($test->courses as $courseItem) {
                    $courseName .= $courseItem->title . '<br/>';
                }
                return $courseName;
            })
            ->addColumn('total_score', function ($test) {
                $totalScore = $test->total_score;
                return $totalScore;
            })
            ->addColumn('actions', function ($test) {
                return view('admin.tests.actions', ['row' => $test])->render();
            })
            ->rawColumns(['actions', 'category_name'])
            ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $course     = Course::pluck('title', 'id');
        $question   = Question::pluck('content', 'id');
        return view('admin.tests.create', compact('course', 'question'));
    }

    /**
     * @param TestRequest $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TestRequest $request)
    {
        DB::beginTransaction();
        $test = new Test();

        try {
            $course_id      = $request->course;
            $givenCategory  = $request->category;
            $course         = Course::find($course_id)->with('tests')->first();
            $existingTests  = $course->tests;

            foreach ($existingTests as $existingTest) {
                if ($givenCategory == 0 && $existingTest->category == 0) {
                    return redirect()
                        ->back()
                        ->with('message', 'Khóa học này đã có bài thi cuối khoá')
                        ->with('type_alert', 'danger');
                }
            }
            $totalScore         = 0;
            $test->category     = $request->category;
            $test->title        = $request->title;
            $test->time         = $request->time;
            $test->description  = $request->description;
            $questionIds        = $request->question;
            foreach ($questionIds as $id) {
                $question       = Question::find($id);
                $totalScore    += $question->score;
            }
            $test->total_score  = $totalScore;
            $test->save();
            
            foreach ($questionIds as $id) {
                $question       = Question::find($id);
                $question->tests()->attach($test->id);
            }
            $course->tests()->attach($test->id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new ModelNotFoundException();
        }
        return redirect()->route('test.index');
    }

    /**
     * @param Request $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->input('test_id');
        $test = Test::find($id);

        if ($test->users()->exists() == false) {
            $test->courses()->detach();
            $test->questions()->detach();

            Test::destroy($id);
            return redirect()
                ->action([TestController::class, 'index'])
                ->with('success', 'Dữ liệu xóa thành công.');
        } else {
            return redirect()
                ->action([TestController::class, 'index'])
                ->with('message', 'Bài test đang được sử dụng.')
                ->with('type_alert', "danger");
        }
    }

    /**
     * @param Request $request
     * @return NULL
     */
    public function getQuestion(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        if ($value == "#") {
            $questions = Question::all();
        } else {
            $questions = Question::where('course_id', $value)
                ->select('id', 'content', 'category')
                ->get();
        }
        $k = 1;
        $category = "";
        foreach ($questions as $row) {
            if ($row->category == 0) {
                $category = "Tự luận";
            } elseif ($row->category == 1) {
                $category = "Trắc nhiệm nhiều lựa chọn";
            } elseif ($row->category == 2) {
                $category = "Câu hỏi đúng sai";
            }
            $output = '<option name ="question_' . $row->id . '"  value="' . $row->id . '">' . $k . '. ' . $row->content . ' [' . $category . ']</option>';
            $k++;
            echo $output;
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $tests  = Test::find($id);
        if ($tests->users()->exists()) {
            return redirect()
                ->action([TestController::class, 'index'])
                ->with('message', 'Không thể sửa! Đã có học viên làm bài kiểm tra!')
                ->with('type_alert', 'danger');
        }
        $course = Course::pluck('title', 'id');
        $question = Question::pluck('content', 'id');

        return view('admin.tests.edit', compact('course', 'question', 'tests'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @throws ModelNotFoundException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TestRequest $request, $id)
    {
        $test  = Test::find($id);
        try {
            $test->title = $request->title;
            $test->time = $request->time;
            $test->description = $request->description;
            $test->save();
        } catch (\Throwable $t) {
            DB::rollback();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }
        return redirect()->route('test.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function view($id)
    {
        $tests  = Test::find($id);
        $questions = $tests->questions;
        $arr_question = [];

        foreach ($questions as $question) {
            $arr_question[] = $question->pivot->question_id;
        }

        if ($arr_question == []) {
            $arr_question = "";
            $this->delete_test($id);
            return redirect()->route('test.index');
        } else {
            $arr_question = implode('-', $arr_question);
            $q_categories = [];
            $q_categories[0] = "Tự luận";
            $q_categories[1] = "Trắc nhiệm nhiều lựa chọn";
            $q_categories[2] = "Trắc nhiệm đúng sai";
            return view('admin.tests.questions.view_question', compact('tests', 'questions', 'arr_question', 'q_categories'));
        }
    }

    /**
     * @param int $id
     * @param int $testId
     * @param string $arr_quest
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function createquestion($id, $testId, $arr_quest)
    {
        $test = Test::find($testId);
        if ($test->users()->exists()) {
            return redirect(route('test.view', $testId))
                ->with('message', 'Không thể chỉnh sửa! Đã có học viên làm bài kiểm tra!')
                ->with('type_alert', 'danger');
        }
        $arr = explode("-", $arr_quest);
        $courses = Course::find($id);
        $questions = Question::where('course_id', $id)
            ->WhereNotIn('id', $arr)
            ->select('id', 'content', 'category')
            ->get();
        $q_categories = [];
        $q_categories[0] = "Tự luận";
        $q_categories[1] = "Trắc nhiệm nhiều lựa chọn";
        $q_categories[2] = "Trắc nhiệm đúng sai";
        return view('admin.tests.questions.create_question', compact('courses', 'questions', 'testId', 'q_categories'));
    }

    /**
     * @param Request $request
     * @param int $id_test
     * @throws ModelNotFoundException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_question(Request $request, $id_test)
    {
        $validated = $request->validate([
            'question' => 'required',
        ]);
        $tests = Test::find($id_test);
        try {
            for ($q = 0; $q < (count($request->question)); $q++) {
                $question  = Question::find($request->question[$q]);
                $question->tests()->attach($tests->id);
            }
        } catch (\Throwable $t) {
            DB::rollback();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }
        $tests->save();
        return redirect()->route('test.view', $id_test);
    }

    /**
     * @param int $id_test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_question(Request $request, $id_test)
    {
        $test = Test::find($id_test);
        if ($test->users()->exists()) {
            return redirect(route('test.view', $id_test))
                ->with('message', 'Không thể chỉnh sửa! Đã có học viên làm bài kiểm tra!')
                ->with('type_alert', 'danger');
        }
        $id = $request->input('question_id', 'value');
        $question = Question::find($id);
        $question->tests()->detach($id_test);
        return redirect()->route('test.view', $id_test);
    }

    /**
     * @param int $questionId
     * @param int $testId
     * @param int $courseId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function question_edit($questionId, $testId, $courseId)
    {
        $test = Test::find($testId);
        if ($test->users()->exists()) {
            return redirect(route('test.view', $testId))
                ->with('message', 'Không thể chỉnh sửa! Đã có học viên làm bài kiểm tra!')
                ->with('type_alert', 'danger');
        }
        $question = Question::find($questionId);
        $tests  = Test::find($testId);
        $questions = $tests->question;
        $questArray[] = "";
        foreach ($questions as $quest) {
            $questArray[] = $quest->pivot->question_id;
        }
        $question_old = Question::where('course_id', $courseId)
            ->WhereNotIn('id', $questArray)
            ->select('id', 'content', 'category')->get();
        $categories = [];
        $categories[0] = "Tự luận";
        $categories[1] = "Trắc nhiệm nhiều lựa chọn";
        $categories[2] = "Trắc nhiệm đúng sai";
        return view('admin.tests.questions.edit_question', compact('tests', 'question', 'question_old', 'categories'));
    }

    /**
     * @param Request $request
     * @param int $id, $id_question_old
     * @param int $id_question_old
     * @throws ModelNotFoundException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function question_update(Request $request, $id, $id_question_old)
    {
        $test = Test::find($id);

        foreach ($test->question as $row) {
            if ($row->pivot->question_id == $id_question_old) {
                $row->pivot->question_id = $request->question;
                $row->pivot->save();
            }
        }
        return redirect()->route('test.view', $id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_test($id)
    {
        $test = Test::find($id);
        $test->course()->detach();
        $test->question()->detach();
        Test::destroy($id);
        return redirect()
            ->action([TestController::class, 'index'])
            ->with('success', 'Dữ liệu xóa thành công.');
    }
}
