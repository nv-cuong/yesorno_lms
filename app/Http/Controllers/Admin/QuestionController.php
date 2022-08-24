<?php

namespace App\Http\Controllers\Admin;
use App\Models\Question;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\QuestionRequest;
use App\Models\Answer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Ramsey\Collection\Queue;

class QuestionController extends Controller
{
    public function getData()
    {
        $questions = Question::query();
     
        return DataTables::of($questions)
           ->addColumn('action', function($row){
             $actionBtn = '<a href="'. route('question.edit', $row->id) .'" class="edit btn btn-success btn-sm">Edit</a> 
             <a class="btn btn-sm btn-danger delete_question" data-toggle="modal" data-target="#deleteModalQuestion" value="' .$row->id. '" onclick="javascript:question_delete(' .$row->id. ')">Delete</a>';
        return $actionBtn;
    })
    ->rawColumns(['action'])
    ->make(true);
    }

    public function index()
    {
       
        return view('Admin.questions.index');
    }
    
    public function create()
    { 
        return view('Admin.questions.create');
    }

    public function store(QuestionRequest $request)
    {
        $question_item = $request->except('_token');
         
       
        try{
            if($question_item['category']==0)
            {
                $question = Question::create([
                    'content'        => $question_item['content'],
                    'course_id'   => $question_item['course_id'],
                    'category'    => $question_item['category'],
                    'score'       => $question_item['score'],
                ]);
            }elseif($question_item['category']==1)
            {
                $question = Question::create([
                    'content'          => $question_item['content'],
                    'course_id'   => $question_item['course_id'],
                    'category'      => $question_item['category'],
                    'score'         => $question_item['score'],
                ]);
                for ($q=1; $q <= 4; $q++) {
                    $option = $request->input('content_' . $q, '');
                    if ($option != '') {
                        Answer::create([
                            'question_id' => $question->id,
                            'content' => $option,
                            'checked' => $request->input('correct_' . $q) ? 1 : 0,
                        ]);
                    }
                }
            }else{
                $question = Question::create([
                    'content'          => $question_item['content'],
                    'course_id'   => $question_item['course_id'],
                    'category'      => $question_item['category'],
                    'score'         => $question_item['score'],
                    'answer'         => $question_item['answer'],
                ]);
            }
            
        

        } catch (\Throwable $t) {
            
            throw new ModelNotFoundException();
        }

        return redirect(route('question.index'))->with('msg', 'Product is not exitsting');

        
    }
    public function edit(Request $request, $id)
    {
        $question = Question::find($id);
       
        if ($question) {
            // if($question->category == 1)
            // {
            //     $answers = Answer::where('question_id',$id)->get();
                
            
            // return view('Admin.questions.edit',compact(['question','answers']));
            // }else{
            //     $answers = 0;            
            //     return view('Admin.questions.edit',compact(['question','answers']));
            // }
            $answers = Answer::where('question_id',$id)->get();
                
           
             return view('Admin.questions.edit',compact(['question','answers']));
        }

        
    }

    public function update(QuestionRequest $request, $id, Answer $answer)
    {
        $msg = 'Product is not exitsting!';
        $question = Question::find($id);
        if ($question->category == 1) {
            $question->content = $request->input('content');
            $question->course_id = $request->input('course_id');
            $question->score = $request->input('score');
            $question->save();
            //$question->answer()->attach($id);
            for ($q=1; $q <= 4; $q++) {
                $option = $request->input('content_' . $q, '');
                if ($option != '') {
                    $answers = Answer::where('question_id',$id)->get();
                    $data=[
                      'content' => $option,
                      'checked' => $request->input('correct_' . $q) ? 1 : 0,
                    ];
                    $answer->update($data);
                    //dd($answer);
                }
            }
            $msg = 'Update question is success!';
        }
    }
    
    public function destroy(Request $request)
    {
        $question_id = $request->input('question_id', 0);
        if ($question_id) {
            Question::destroy($question_id);
            return redirect(route('question.index'))
            ->with('msg', "Delete product {$question_id} success!");
        } else {
            throw new ModelNotFoundException();
        }
    }
    
}
