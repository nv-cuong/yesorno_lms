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

class TestController extends Controller
{
    public function index()
    {
        // $tests = DB::table('tests')->paginate(15);
        $tests = Test::all();
        return view('admin.tests.index', compact('tests'));
    }
    public function create()
    {
        $course = Course::pluck('title', 'id');
        $question = Question::pluck('content', 'id');
        return view('admin.tests.create', compact('course', 'question'));
    }
    public function store(TestRequest $request)
    {
        $k = 0;
        $b = [0, 0, 0, 0];
        DB::beginTransaction();
        $test = new Test();
        $amount = $request->input('count_question_id', 'value');
        $category_question = "";
        try {
            for ($q = 0; $q < (count($request->question)); $q++) {
                $question  = Question::where('id', $request->question[$q])->select('id', 'content', 'category')->get();

                foreach ($question as $row) {
                    if ($row->category == "Trắc nhiệm nhiều lựa chọn" && $b[1] != 1) {
                        if ($k > 0) {
                            $category_question .= " + Trắc nhiệm nhiều lựa chọn";
                        } else {
                            $category_question .= "Trắc nhiệm nhiều lựa chọn";
                        }
                        $k = 1;
                        $b[$k] = 1;
                    } else if ($row->category == "Trắc nhiệm đúng sai" && $b[2] == 0) {
                        if ($k > 0) {
                            $category_question .= " + Trắc nhiệm đúng sai";
                        } else {
                            $category_question .= "Trắc nhiệm đúng sai";
                        }
                        $k = 2;
                        $b[$k] = 1;
                    } else if ($row->category == "Tự luận"  && $b[3] == 0) {
                        if ($k > 0) {
                            $category_question .= " + Tự luận";
                        } else {
                            $category_question .= "Tự luận";
                        }
                        $k = 3;
                        $b[$k] = 1;
                    }
                }
                if ($q == (count($request->question) - 1)) {
                    $category_question .= " .";
                }
            }


            $test->category = $category_question;
            $test->amount = $amount;
            $test->title = $request->title;
            $test->time = $request->time;
            $test->description = $request->description;
            $course_id = $request->course;
            $test->save();
            for ($q = 0; $q < (count($request->question)); $q++) {
                $question  = Question::find($request->question[$q]);
                $question->test()->attach($test->id);
            }
            $course  = Course::find($course_id);
            $course->test()->attach($test->id);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }

        return redirect()->route('index');
    }
    public function delete(Request $request)
    {
        $id = $request->input('test_id', 'value');
        $test = Test::find($id);
        $test->course()->detach();
        $test->question()->detach();
        Test::destroy($id);
        return redirect()->action([TestController::class, 'index'])->with('success', 'Dữ liệu xóa thành công.');
    }

    public function getQuestion(Request $request)
    {
        $select = $request->get('select');

        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $questions = Question::where('course_id', $value)->select('id', 'content', 'category')->get();

        //  $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        $k = 1;
        foreach ($questions as $row) {
            $output = '<option name ="question_' . $row->id . '"  value="' . $row->id . '">' . $k . '. ' . $row->content . ' [' . $row->category . ']</option>';
            $k++;
            echo $output;
        }
    }
    public function edit($id)
    {
        $tests  = Test::find($id);
        $course = Course::pluck('title', 'id');
        $question = Question::pluck('content', 'id');

        return view('admin.tests.edit', compact('course', 'question', 'tests'));
    }
    public function update(TestRequest $request, $id)
    {
        $test  = Test::find($id);
        try {
            $test->category = $request->category_question;
            $test->title = $request->title;
            $test->time = $request->time;
            $test->description = $request->description;
            $test->amount = 1;
            $test->save();
        } catch (\Throwable $t) {
            DB::rollback();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }

        return redirect()->route('index');
    }
    public function view(Request $request, $id)
    {
        $tests  = Test::find($id);
        $question1 = $tests->question;
        $question = $tests->question()->paginate(4);
        foreach ($question1 as $row) {
            $arr_question[] = $row->pivot->question_id;
        }
        $arr_question = implode(',',  $arr_question);
        return view('admin.tests.questions.view_question', compact('tests', 'question', 'arr_question'));
    }
    public function createquestion($id, $id_test, $arr_quest)
    {
        $arr_quest1 = explode(",", $arr_quest);
        $courses = Course::find($id);

        $question = Question::where('course_id', $id)

            ->WhereNotIn('id', $arr_quest1)
            ->select('id', 'content')->get();
        return view('admin.tests.questions.create_question', compact('courses', 'question', 'id_test'));
    }
    public function store_question(Request $request, $id_test)
    {
        $validated = $request->validate([
            'question' => 'required',
        ]);
        $tests = Test::find($id_test);
        $amount = $request->input('count_question_id', 'value');
        try {
            for ($q = 0; $q < (count($request->question)); $q++) {
                $question  = Question::find($request->question[$q]);
                $question->test()->attach($tests->id);
            }
        } catch (\Throwable $t) {
            DB::rollback();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }
        return redirect()->route('test.view', $id_test);
    }
    public function delete_question(Request $request, $id_test)
    {
        $id = $request->input('question_id', 'value');
        $question = Question::find($id);
        $question->test()->detach($id_test);
        return redirect()->route('test.view', $id_test);
    }
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
            ->select('id', 'content')->get();
        return view('admin.tests.questions.edit_question', compact('tests', 'question', 'question_old'));
    }
    public function question_update(Request $request, $id_test, $id_question_old)
    {
        $question = Question::find($request->id_question_old);
        $question->test()->detach($id_test);
        $question = Question::find($request->question);
        $question->test()->attach($id_test);

        return redirect()->route('test.view', $id_test);
    }
    public function search(Request $request)
    {
        if ($request->search == null) $tests = DB::table('tests')->paginate(15);
        else
            $tests = Test::where('title', 'like', '%' . $request->search . '%')->paginate(15);
        return view('admin.tests.index', compact('tests'));
    }
}
