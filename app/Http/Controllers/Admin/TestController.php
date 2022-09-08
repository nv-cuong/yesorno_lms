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

/**
 * @author DELL
 *
 */
class TestController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {      
        $tests = Test::all();
        return view('admin.tests.index', compact('tests'));
    }
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
        $k = 0;
        $b = [0, 0, 0, 0];
        DB::beginTransaction();
        $test = new Test();
        $category_question = "";
        try {
            for ($q = 0; $q < (count($request->question)); $q++) {
                $question  = Question::where('id', $request->question[$q])->select('id', 'content', 'category')->get();

                foreach ($question as $row) {
                    if ($row->category == 1 && $b[1] != 1) {
                        if ($k > 0) {
                            $category_question .= " + Trắc nhiệm nhiều lựa chọn";
                        } else {
                            $category_question .= "Trắc nhiệm nhiều lựa chọn";
                        }
                        $k = 1;
                        $b[$k] = 1;
                    } elseif ($row->category == 2 && $b[2] == 0) {
                        if ($k > 0) {
                            $category_question .= " + Trắc nhiệm đúng sai";
                        } else {
                            $category_question .= "Trắc nhiệm đúng sai";
                        }
                        $k = 2;
                        $b[$k] = 1;
                    } elseif ($row->category == 0  && $b[3] == 0) {
                        if ($k > 0) {
                            $category_question .= " + Tự luận";
                        } else {
                            $category_question .= "Tự luận";
                        }
                        $k = 3;
                        $b[$k] = 1;
                    }
                }
            }
            $test->category = $category_question;
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
        return redirect()->action([TestController::class, 'index'])->with('success', 'Dữ liệu xóa thành công.');
    }
    else {
        
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
            $questions = Question::where('course_id', $value)->select('id', 'content', 'category')->get();
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
            $arr_question = implode(',', $arr_question);
            $a=[];
            $a[0]="Tự luận";
            $a[1]="Trắc nhiệm nhiều lựa chọn";
            $a[2]="Trắc nhiệm đúng sai";
            return view('admin.tests.questions.view_question', compact('tests', 'question', 'arr_question', 'a'));
        }
    }
    /**
     * @param int $id
     * @param int $id_test
     * @param int $arr_quest
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createquestion($id, $id_test, $arr_quest)
    {
        $arr_quest1 = explode(",", $arr_quest);
        $courses = Course::find($id);
        $question = Question::where('course_id', $id)
            ->WhereNotIn('id', $arr_quest1)
            ->select('id', 'content', 'category')->get();
        $a = [];
        $a[0] = "Tự luận";
        $a[1] = "Trắc nhiệm nhiều lựa chọn";
        $a[2] = "Trắc nhiệm đúng sai";
        return view('admin.tests.questions.create_question', compact('courses', 'question', 'id_test', 'a'));
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
                $question->test()->attach($tests->id);
            }
        } catch (\Throwable $t) {
            DB::rollback();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }
        $tests->save();
        $a = $this->update_category_test($id_test);
        return redirect()->route('test.view', $id_test);
    }
    public function delete_question(Request $request, $id_test)
    {
        $id = $request->input('question_id', 'value');
        $question = Question::find($id);
        $question->test()->detach($id_test);
        $a = $this->update_category_test($id_test);
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
            ->select('id', 'content', 'category')->get();
        $b = [];
        $b[0] = "Tự luận";
        $b[1] = "Trắc nhiệm nhiều lựa chọn";
        $b[2] = "Trắc nhiệm đúng sai";
        return view('admin.tests.questions.edit_question', compact('tests', 'question', 'question_old', 'b'));
    }
    public function question_update(Request $request, $id_test, $id_question_old)
    {
        $test = Test::find($id_test);

        foreach ($test->question as $row) {
            if ($row->pivot->question_id == $id_question_old) {
                $row->pivot->question_id = $request->question;
                $row->pivot->save();
            }
        }
        $this->update_category_test($id_test);
        return redirect()->route('test.view', $id_test);
    }
    public function update_category_test($id_test)
    {
        $tests = Test::find($id_test);
        $question = $tests->question;
        $k = 0;
        $b = [0, 0, 0, 0];
        $category_question = "";
        foreach ($question as $row) {
            if ($row->category == 1 && $b[1] != 1) {
                if ($k > 0) {
                    $category_question .= " + Trắc nhiệm nhiều lựa chọn";
                } else {
                    $category_question .= "Trắc nhiệm nhiều lựa chọn";
                }
                $k = 1;
                $b[$k] = 1;
            } elseif ($row->category == 2 && $b[2] == 0) {
                if ($k > 0) {
                    $category_question .= " + Trắc nhiệm đúng sai";
                } else {
                    $category_question .= "Trắc nhiệm đúng sai";
                }
                $k = 2;
                $b[$k] = 1;
            } elseif ($row->category == 0  && $b[3] == 0) {
                if ($k > 0) {
                    $category_question .= " + Tự luận";
                } else {
                    $category_question .= "Tự luận";
                }
                $k = 3;
                $b[$k] = 1;
            }
        }
        $tests->category=$category_question;
        $tests->save();

    }
    /**
     * @param int $id_test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_test($id_test)
    {
        $test = Test::find($id_test);
        $test->course()->detach();
        $test->question()->detach();
        Test::destroy($id_test);
        return redirect()->action([TestController::class, 'index'])->with('success', 'Dữ liệu xóa thành công.');
    } 
}
