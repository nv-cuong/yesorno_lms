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

    
   

    public function dots(Request $request,$id)
    {
        $user_test = UserTest::find($id);
        // $user_test_answers =  $user_test->answers->where('answer_essay','')->groupBy('question_id');
        // dd($user_test_answers);
        
        $user_test_answers = UserTestAnswer::select([
            
            'questions.content',
            'questions.id',
            'questions.score',
            
            'user_test.id as user_test_id',
            'user_test_answers.answer'
        ])
        ->where('user_test_id',$id)
        ->LeftJoin('user_tests as user_test', 'user_test_id', 'user_test.id')
        ->join('questions','question_id','questions.id')     
        ->where('questions.category',0)
        ->get();
       
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
        
            $score += $answer_value;
         
        }
    }

    $test_user = UserTest::find($test_user_item['user_test_id']);
    $test_user->score = $test_user->score_s + $score;
    $test_user->save();
    return redirect(route('score.index'))->with('message', 'Chấm điểm thành công !')->with('type_alert', "success");
}

public function ajaxstudent($id)
{
    

    $users['data']=ClassStudy::find($id)->users;
    
    return response()->json($users);

}
public function getStudent(Request $request)
    {
        
       
        $select = $request->get('select');

        $value = $request->get('value');
        dd($value);
        $dependent = $request->get('dependent');
        $users = ClassStudy::find($value)->users;

        //  $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        $k = 1;
        foreach ($users as $row) {
            
            $output = '<option name ="student_' . $row->id . '"  value="' . $row->id . '">. ' . $row->first_name . '</option>';
            $k++;
            echo $output;
        }
    }
}
