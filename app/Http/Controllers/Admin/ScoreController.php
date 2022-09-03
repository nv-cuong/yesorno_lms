<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\ClassStudy;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use App\Models\UserTest;
use App\Models\UserTestAnswer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ScoreController extends Controller
{
    public function index()
    {
        $test_users = User::select([
            'users.id',
            'first_name',  
            'te.test_id',
            'status',
            'tests.title',
            'te.score',
            'te.id'
        ])
        ->LeftJoin('user_tests AS te', 'user_id', 'users.id')
        ->Join('tests','te.test_id','tests.id')
        ->get();
        
        return view('admin.score.index', compact('test_users'));
    }

    public function create()
    {
        $tests = Test::select(['id', 'title'])->get();
        $classes = ClassStudy::select(['id','name'])->get();
        $users = User::all();
        return view('admin.score.create', compact(['tests', 'users','classes']));
    }

    public function store(Request $request)
    {
        $test_user_item = $request->except('_token');

        try {
            $student_id = $test_user_item['student_id'];
            foreach ($student_id as $user_id) {

                $user  = User::find($user_id);

                $user->tests()->attach($test_user_item['test_id']);
            }
        } catch (\Throwable $t) {

            throw new ModelNotFoundException();
        }

        return redirect(route('score.index'))->with('message', 'Thêm bài test thành công !')->with('type_alert', "success");
    }

    public function edit(Request $request, $id)
    {
        $test = Test::find($id);
        
        $questions = $test->question;
       
        return view('admin.score.edit', compact('questions'));

    }

    public function update(Request $request, $id)
    {
        $test_user_item = $request->except('_token');
        
        //dd( $test_user_item['questions']);
        $test_users = UserTest::find($id);
        $answers = [];
        $test_score = 0;
        if($test_user_item['questions'])
        {
        foreach ($test_user_item['questions'] as  $answer_id) {
            $question_id = Answer::find($answer_id)->question->id;
           
            $answers_item = Answer::where('question_id', $question_id)->get();
            $check = 1;
            foreach($answers_item as $as)
            {
                if( $as->checked == 0)
                {
                    if($as->id = $answer_id)
                    {
                        $check = 0;
                    }
                }
                
                
            }
            $correct = Answer::where('question_id', $question_id)
                ->where('id', $answer_id)
                ->where('checked', 1)->count() > 0;
            $answers[] = [
                'question_id' => $question_id,
                'answer' => $answer_id,
                'correct' => $correct,
            ];
           
            if ($check == 1) {
                
                $test_score += $question_id->score;
                
            }
            
            
        }
        
       }
       if($request->get('true'))
       {
        foreach ($request->get('true') as $question_id => $answer_id) {
            $question = Question::find($question_id);
           
            $correct = Question::where('id', $question_id)
                ->where('answer', $answer_id)
                ->count() > 0;
                
            $answers[] = [
                'question_id' => $question_id,
                'answer_essay' => $answer_id,
                'correct' => $correct
            ];
            if ($correct) {
                $test_score += $question->score;
            }
            
        }
       }
       $test_users->status = 1;       
       $test_users->score =  $test_score;
       $test_users->save();
      
        if($request->get('essay'))
        {
            foreach($request->get('essay') as $question_id => $answer_id)
            {
                $answers[] = [
                    'question_id' => $question_id,
                    'answer_essay' => $answer_id,
                   
                ];
            }
            $test_users->score = '';
            
        }
        
        $test_users->answers()->createMany($answers);
        $test_users->save();
    }

    public function dots(Request $request,$id)
    {
        $user_test = UserTest::find($id);
        //$user_test_answers =  $user_test->answers->where('answer_essay','')->groupBy('question_id');
        
        $user_test_answers = UserTestAnswer::select([
            'questions.answer',
            'questions.content',
            'questions.id',
            'questions.score',
            'answer_essay',
            'user_test.id as user_test_id'
        ])
        ->where('user_test_id',$id)
        ->LeftJoin('user_tests as user_test', 'user_test_id', 'user_test.id')
        ->join('questions','question_id','questions.id')     
        ->where('questions.category',0)
        ->get();
       //dd($user_test_answers);
        return view('admin.score.dots', compact('user_test_answers'));
    }

    public function point(Request $request)
    {
        $test_user_item = $request->except('_token');
       
        if($request->get('true'))
        {
            $score = 0;
        foreach ( $request->get('true')  as $question_id  => $answer_value) {
           $question= Question::find($question_id);
         if( $answer_value == 1)
         {
            $score+=$question->score;
         }
        }
    }

    $test_user = UserTest::find($test_user_item['user_test_id']);
    $test_user->score = $test_user->score_s + $score;
    $test_user->save();
    return redirect(route('score.index'))->with('message', 'Chấm điểm thành công !')->with('type_alert', "success");
}

public function ajax_student($id)
{
    $output = '';
    $users=ClassStudy::find($id)->users;
    
   if ($users) {

    foreach ($users as $user) {
        

        $output .= "<option value='".$user->id."'>".$user->first_name."</option>";
    }
}
return Response($output);
}
}
