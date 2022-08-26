<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Course;
use App\Models\Question;
use Sentinel;
use DB;
class TestController extends Controller
{   
    public function index(){
        $tests = DB::table('tests')->paginate(15);
        return view('admin.tests.index',compact('tests'));
    }
    public function create(){
        $course = Course::pluck('title', 'id');
        $question = Question::pluck('content', 'id');
        return view('admin.tests.create',compact('course','question'));
    }
    public function store(Request $request){
        $test = new Test();
        $test->category=$request->category_question;
        $test->amount=$request->amount;
        $test->title=$request->title;
        $test->time=$request->time;
        $test->description=$request->description;
        $course_id=$request->course;
        $test->save();
        for ($q=0; $q < (count($request->question)); $q++) {
        $question  = Question::find($request->question[$q]);
        $question->test()->attach($test->id);
}       
        $course  = Course::find($course_id);
        $course ->test()->attach($test->id);
        return redirect()->route('index');

    }
    public function delete(Request $request){
        $id=$request->input('test_id','value');
        $test=Test::find($id);
        $test->course()->detach();
        $test->question()->detach();
        Test::destroy($id);
        return redirect()->action([TestController::class, 'index'])->with('success','Dữ liệu xóa thành công.');
    }
    
    public function getQuestion(Request $request)
    {   $select =$request->get('select');
       
        $value =$request->get('value');
        $dependent =$request->get('dependent');
        $questions = Question::where('course_id',$value)->select('id', 'content')->get();
         
        //  $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        $k=1;
        foreach($questions as $row){
                $output='<option name ="question_'.$row->id.'"  value="'.$row->id.'">'.$k.'. '.$row->content.'</option>';
                $k++;
                echo $output;
               
            }  
    }
    public function edit($id){
        $tests  = Test::find($id);
        $course = Course::pluck('title', 'id');
        $question = Question::pluck('content', 'id');
        return view('admin.tests.edit',compact('course','question','tests'));
    }
    public function update(Request $request, $id){
        $test  = Test::find($id);
        
        $test->category=$request->category_question;
        $test->amount=$request->amount;
        $test->title=$request->title;
        $test->time=$request->time;
        $test->description=$request->description;
        $course_id=$request->course;
        $question_id=$request->question;
        
        $test->save();
        return redirect()->route('index');
    }
    public function view(Request $request, $id){
         $tests  = Test::find($id);
        $question=$tests->question()->paginate(15);
        foreach($question as $row){
            $arr_question1[]=$row->id;
        }
        $arr_question=implode(',',  $arr_question1);
        return view('admin.tests.questions.view_question',compact('tests','question','arr_question'));
    }
    public function createquestion($id,$id_test,$arr_quest)
    {
        $arr_quest1= explode (",", $arr_quest);
        $courses = Course::find($id);
  
        $question = Question::where('course_id',$id)
            
        ->WhereNotIn('id',$arr_quest1)
        ->select('id', 'content')->get();
        return view('admin.tests.questions.create_question',compact('courses','question','id_test'));
        
        
    }
    public function store_question(Request $request, $id_test){
        $tests = Test::find($id_test);
    for ($q=0; $q < (count($request->question)); $q++) {
        $question  = Question::find($request->question[$q]);
        $question->test()->attach($tests->id);
}
$question=$tests->question()->paginate(15);
foreach($question as $row){
    $arr_question1[]=$row->id;
}
$arr_question=implode(',',  $arr_question1);
        return view('admin.tests.questions.view_question',compact('tests','question','arr_question'));
    }
    public function delete_question(Request $request,$id_test){
        $id=$request->input('question_id','value');
        $question = Question::find($id);
        $question->test()->detach($id_test);
        $tests  = Test::find($id_test);
        $question=$tests->question()->paginate(15);
        foreach($question as $row){
            $arr_question1[]=$row->id;
        }
        $arr_question=implode(',',  $arr_question1);
        return view('admin.tests.questions.view_question',compact('tests','question','arr_question'));
    }
    public function question_edit($id_question,$id_test,$id_course){
        $question = Question::find($id_question);
        $tests  = Test::find($id_test);
        $question1=$tests->question()->paginate(15);
        foreach($question1 as $row){
            $arr_question1[]=$row->id;
        }
        $question_old = Question::where('course_id',$id_course)
            
        ->WhereNotIn('id',$arr_question1)
        ->select('id', 'content')->get();
        return view('admin.tests.questions.edit_question',compact('tests','question','question_old'));
    }
    public function question_update(Request $request,$id_test, $id_question_old){
        $question = Question::find($request->id_question_old);
        $question->test()->detach($id_test);
        $question = Question::find($request->question);
        $question->test()->attach($id_test);
        $tests  = Test::find($id_test);
        $question=$tests->question()->paginate(15);
        foreach($question as $row){
            $arr_question1[]=$row->id;
        }
        $arr_question=implode(',',  $arr_question1);
        return view('admin.tests.questions.view_question',compact('tests','question','arr_question'));

    }
}
