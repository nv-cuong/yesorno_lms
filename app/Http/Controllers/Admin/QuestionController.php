<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\QuestionRequest;
use App\Http\Requests\Question\EditQuestionRequest;
use App\Models\Answer;
use App\Models\Course;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionController extends Controller
{


    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {

        $questions = Question::select([
            'id',
            'course_id',
            'content',
            'answer',
            'category',
            'score'
        ])->get();

        return view('admin.questions.index', compact('questions'));


    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $course = Course::all();


        return view('admin.questions.create', compact('course'));


    }

    /**
     * @param QuestionRequest $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(QuestionRequest $request)
    {
        $question_item = $request->except('_token');


        try {
            if ($question_item['category'] == 0) {


                $question = Question::create([
                    'content' => $question_item['content'],
                    'course_id' => $question_item['course_id'],
                    'category' => $question_item['category'],
                    'score' => $question_item['score']
                ]);

            } elseif ($question_item['category'] == 1) {


                $question = Question::create([
                    'content' => $question_item['content'],
                    'course_id' => $question_item['course_id'],
                    'category' => $question_item['category'],
                    'score' => $question_item['score']
                ]);
                for ($q = 1; $q <= 4; $q++) {
                    $option = $request->input('content_' . $q, '');
                    if ($option != '') {
                        Answer::create([
                            'question_id' => $question->id,
                            'content' => $option,
                            'checked' => $request->input('correct_' . $q) ? 1 : 0
                        ]);
                    }
                }
            } else {
                $question = Question::create([
                    'content' => $question_item['content'],
                    'course_id' => $question_item['course_id'],
                    'category' => $question_item['category'],
                    'score' => $question_item['score'],
                    'answer' => $question_item['answer']
                ]);
            }
        } catch (\Throwable $t) {

            throw new ModelNotFoundException();
        }

        return redirect(route('question.index'))->with('message', 'Thêm câu hỏi thành công !')->with('type_alert', "success");
    }



    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $question_test = Question::find($id);


        if ($question_test->test()->count() > 0) {
            return redirect(route('question.index'))->with('message', "Câu hỏi có trong bài test không thể sửa !")->with('type_alert', "danger");
        } else {
            $question = Question::find($id);
            if ($question) {

                $answers = Answer::where('question_id', $id)->get();
                $course = Course::all();

                return view('admin.questions.edit', compact([
                    'question',
                    'answers',
                    'course'
                ]));

            }
        }
    }

    /**
     * @param EditQuestionRequest $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditQuestionRequest $request, $id)
    {

        $msg = 'Câu hỏi không tồn tại !';

        $question = Question::find($id);
        if ($question->category == 1) {
            $question->content = $request->input('content');
            $question->course_id = $request->input('course_id');
            $question->score = $request->input('score');
            $question->save();

            $answers = Answer::where('question_id', $id)->get();

            foreach ($answers as $q => $ans) {

                $option = $request->input('content_' . $q, '');
                if ($option != '') {

                    $ans->content = $option;
                    $ans->checked = $request->input('correct_' . $q) ? 1 : 0;
                    $ans->save();
                }
            }

            $msg = 'Sửa thành công câu hỏi :' . $question->content;

        } elseif ($question->category == 2) {
            $question->content = $request->input('content');
            $question->course_id = $request->input('course_id');
            $question->score = $request->input('score');
            $question->answer = $request->input('answer');
            $question->save();

            $msg = 'Sửa thành công câu hỏi :' . $question->content;

        } else {
            $question->content = $request->input('content');
            $question->course_id = $request->input('course_id');
            $question->score = $request->input('score');

            $question->save();
            $msg = 'Sửa thành công câu hỏi :' . $question->content;
        }

        return redirect(route('question.index'))->with('message', $msg)->with('type_alert', "success");

    }


    /**
     * @param Request $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $question_id = $request->input('question_id', 0);
        $question = Question::find($question_id);

        if ($question->test()->count() > 0) {
            return redirect(route('question.index'))->with('message', "Câu hỏi có trong bài test không thể sửa !")->with('type_alert', "danger");
        } else {
            if ($question_id) {
                Question::destroy($question_id);
                return redirect(route('question.index'))->with('message', "Xóa câu hỏi {$question_id} thành công !")->with('type_alert', "success");
            } else {
                throw new ModelNotFoundException();
            }
        }
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function show_answser($id)
    {
        $output = '';
        $answers = Answer::where('question_id', $id)->get();
        // dd($id);
        if ($answers) {

            foreach ($answers as $an) {
                if ($an->checked == 1) {
                    $checked = 'Đúng';
                } else {
                    $checked = 'Sai';

                }

                $output .= '<tr>

                     <td class="text-center">' . $an->content . '</td>
                     <td class="text-center">' . $checked . '</td>

                     </tr>';
            }
        }
        return Response($output);
    }

}
