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
            'amount',
            'time',
            'title',
            'description',
        ])->with('course')
        ->withCount('question');

        // @phpstan-ignore-next-line
        return DataTables::of($tests)
        ->editColumn('category', function ($test) {
            if($test->category == 0) return 'Bài thi';
            return 'Khảo sát';
        })
        ->addColumn('category_name', function ($test) {
            $course_name = '';
            foreach($test->course as $courseItem){
                $course_name .= $courseItem->title .'<br/>';
            }
            return $course_name;

        })
        ->addColumn('actions', function ($test) {
            return view('admin.tests.actions', ['row' => $test])->render();
        })
        ->rawColumns(['actions', 'category_name'])
        ->make(true);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $course = Course::pluck('title', 'id');
        $question = Question::pluck('content', 'id');
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
            $category = $request->category;
            $course_id = $request->course;

            $test->category = $category;
            $test->title = $request->title;
            $test->time = $request->time;
            $test->description = $request->description;
            $test->save();

            for ($i = 0; $i < (count($request->question)); $i++) {
                $question  = Question::find($request->question[$i]);
                $question->tests()->attach($test->id);
            }

            $course  = Course::find($course_id);
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
        $id = $request->input('test_id', 'value');
        $test = Test::find($id);
        if ($test) {
            $test->course()->detach();
            $test->question()->detach();
            Test::destroy($id);
            return redirect()
                ->action([TestController::class, 'index'])
                ->with('success', 'Dữ liệu xóa thành công.');
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * @param Request $request
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($id)
    {
        $tests  = Test::find($id);
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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'time' => ['required', 'numeric'],
            'description' => ['required', 'min:5'],
        ]);
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
     * @return \Illuminate\Http\RedirectResponse|unknown
     */
    public function view($id)
    {
        $tests  = Test::find($id);
        $question1 = $tests->question;
        $question = $tests->question;
        $arr_question = [];

        foreach ($question1 as $row) {
            $arr_question[] = $row->pivot->question_id;
        }

        if ($arr_question == []) {
            $arr_question = "";
            $this->delete_test($id);
            return redirect()->route('test.index');
        } else {
            $arr_question = implode('-', $arr_question);
            $a = [];
            $a[0] = "Tự luận";
            $a[1] = "Trắc nhiệm nhiều lựa chọn";
            $a[2] = "Trắc nhiệm đúng sai";
            return view('admin.tests.questions.view_question', compact('tests', 'question', 'arr_question', 'a'));
        }
    }

    /**
     * @param int $id
     * @param int $id_test
     * @param int $arr_quest
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createquestion($id, $testId, $arr_quest)
    {
        $arr = explode("-", $arr_quest);
        $courses = Course::find($id);
        $questions = Question::where('course_id', $id)
            ->WhereNotIn('id', $arr)
            ->select('id', 'content', 'category')
            ->get();
        $a = [];
        $a[0] = "Tự luận";
        $a[1] = "Trắc nhiệm nhiều lựa chọn";
        $a[2] = "Trắc nhiệm đúng sai";
        return view('admin.tests.questions.create_question', compact('courses', 'questions', 'testId', 'a'));
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
        $a = $this->updateTestCategory($id_test);
        return redirect()->route('test.view', $id_test);
    }

    /**
     * @param int $id_test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_question(Request $request, $id_test)
    {
        $id = $request->input('question_id', 'value');
        $question = Question::find($id);
        $question->tests()->detach($id_test);
        $a = $this->updateTestCategory($id_test);
        return redirect()->route('test.view', $id_test);
    }

    /**
     * @param int $id_test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function question_edit($id_question, $id_test, $id_course)
    {
        $question = Question::find($id_question);
        $tests  = Test::find($id_test);
        $question1 = $tests->question;
        foreach ($question1 as $row) {
            $arr_question1[] = $row->pivot->question_id;
        }
        $question_old = Question::where('course_id', $id_course)
            ->WhereNotIn('id', $arr_question1)
            ->select('id', 'content', 'category')->get();
        $b = [];
        $b[0] = "Tự luận";
        $b[1] = "Trắc nhiệm nhiều lựa chọn";
        $b[2] = "Trắc nhiệm đúng sai";
        return view('admin.tests.questions.edit_question', compact('tests', 'question', 'question_old', 'b'));
    }

    /**
     * @param Request $request
     * @param int $id_test
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
        $this->updateTestCategory($id);
        return redirect()->route('test.view', $id);
    }

    /**
     * @param int $id_test
     * @return \Illuminate\Http\RedirectResponse
     */
    private function decodeTestCategory($category)
    {
        $type = '';
        $categories = json_decode($category);
        if ($categories[0] == $categories[1] && $categories[0] == $categories[2]) {
            $type = 'Hỗn hợp';
        } else {
            if ($categories[0] == true) {
                $type = 'Tự luận';
                if ($categories[1] == true) {
                    $type = $type . ', Trắc nghiệm nhiều câu hỏi';
                }
                if ($categories[2] == true) {
                    $type = $type . ', Trắc nghiệm';
                }
            } elseif ($categories[1] == true) {
                $type = 'Trắc nghiệm nhiều câu hỏi';
                if ($categories[2] == true) {
                    $type = $type . ', Trắc nghiệm';
                }
            } else {
                $type = 'Trắc nghiệm';
            }
        }

        return $type;
    }

    /**
     * @param int $id_test
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
