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
        $tests = Test::all();
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
        $question_id=$request->question;
        $test->save();
for ($q=1; $q <= 1000; $q++) {
    $option = $request->input('question_' . $q, '');
    if ($option != '') {
        $question  = Question::find($q);
        $question->test()->attach($test->id);
    }
}

        
        $course  = Course::find($course_id);
        $course ->test()->attach($test->id);
        // $question  = Question::find($question_id);
        // $question->test()->attach($test->id);
        return redirect('/admin/test');

    }
    public function delete(Request $request){
        $id=$request->input('product_id','value');
        Test::destroy($id);
        return redirect()->action([TestController::class, 'index'])->with('success','Dữ liệu xóa thành công.');
    }
    public function showQuestionInCourse(Request $request){
        if ($request->ajax()) {
			$questions = Question::where('course_id', 'like', '%' . $request->course_id. '%')->get();
            dd($questions);

			return response()->json($questions);
		}
    }
    
    public function getQuestion(Request $request)
    {   $select =$request->get('select');
       
        $value =$request->get('value');
        $dependent =$request->get('dependent');
        $questions = Question::where('course_id', 'like', '%' .$value. '%')->select('id', 'content')->get();
         
         //$output = '<option value="">Select '.ucfirst($dependent).'</option>';
     
        // foreach($questions as $row){
        //     $output='<option value="'.$row->id.'">'.$row->content.'</option>';
        //     echo $output;
           
        // }
        // foreach($questions as $row){
        //         $output='<option value="'.$row->id.'">'.$row->content.'</option>';
        //         echo $output;
               
        //     }
        foreach($questions as $row){
            $output='<label for="'.$row->id.'">
            <input type="checkbox" name ="question_'.$row->id.'" id="'.$row->id.'" />'.$row->content.'</label>';
            echo $output;
           
        }
         
    }
    public function edit($id){
       // $course1 = new Course();
        $tests  = Test::find($id);
        foreach($tests->course as $row)
        {
            $id1= $row->pivot->course_id;
        }
        foreach($tests->question as $row)
        {
            $id2 = $row->pivot->question_id;
            
        }
        $question1 = Question::find($id2);
        $course1 = Course::find($id1);
        $course = Course::pluck('title', 'id');
        $question = Question::pluck('content', 'id');
        return view('admin.tests.edit',compact('course','question','tests','course1','question1'));
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
        return redirect('/admin/test');
    }
    public function addQuestion(Request $request)
    {   $select =$request->get('select');
       
        $value =$request->get('value');
        $dependent =$request->get('dependent');
        $questions = Question::where('course_id', 'like', '%' .$value. '%')->select('id', 'content')->get();
         
         //$output = '<option value="">Select '.ucfirst($dependent).'</option>';
     
        // foreach($questions as $row){
        //     $output='<option value="'.$row->id.'">'.$row->content.'</option>';
        //     echo $output;
           
        // }
        // foreach($questions as $row){
                $output='<label for="one">
                <input type="checkbox" id="one" />First checkbox</label>';
                echo $output;
               
            // }
         
    }
}
