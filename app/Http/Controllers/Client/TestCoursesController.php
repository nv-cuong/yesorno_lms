<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\Course;
use App\Models\UserTest;
use App\Models\UserTestAnswer;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class TestCoursesController extends Controller
{
    /**
     * @param int $id_course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function random_test($id_course)
    {
        $course = Course::find($id_course);
        $test_course=$course->test;
        $category='Tự luận';
        foreach ($test_course as $row) {
            //if (strlen(strstr($row->category, $category)) <= 0) {
                $id_tests[]=$row->id;
            //}
        }
       // dd($id_tests);
        $random=rand(0, count($id_tests)-1);
        $id_test=$id_tests[$random];
        $getUser = Sentinel::getUser();
        $id_user = $getUser->id;
        $user  = User::find($id_user);
        $user->tests()->attach($id_test);
        return redirect()->route('index_make', [$id_test]);
    }

    /**
     * @param int $id_test
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index_make_test($id_test)
    {
        $getUser = Sentinel::getUser();
        $id_user = $getUser->id;
        $user  = User::find($id_user);
        $users_test=UserTest::where('user_id', $id_user)
        ->select('id', 'score', 'status')
        ->get();
        $tests = Test::find($id_test);
        $question= $tests->question;
        $answers=Answer::all();
        foreach ($users_test as $users_test) {
            $id_user_test=$users_test->id;
        }
        $u = $users_test;
        return view('client.modules.test_make_index', compact('tests', 'question', 'answers', 'user', 'u', 'id_user_test'));
    }
    /**
     * @param Request $request
     * @param int $id_test
     * @param int $id_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save_maked(Request $request, $id_test, $id_user)
    {
        $user_test_answer = DB::table('user_test_answers');
        $tests = Test::find($id_test);
        $question = $tests->question;
        $answers=Answer::all();
        $user  = User::find($id_user);
        $k=1;
        foreach ($question as $row) {
            $user_test_answer1=[];
            $q='q'.$k;
            $user_test_answer->question_id=$row->id;
            if ($request->$q==null) {
                $correct=0;
                $user_test_answer1=null;
            } else {
                $t=count($request->$q);
                for ($i = 0; $i < $t; $i++) {
                    if ($t>1) {
                        $user_test_answer1[]=$request->$q[$i];
                    } else {
                        $user_test_answer1=$request->$q[$i];
                    }
                }
                if ($t>1) {
                    $user_test_answer1 = implode(',', $user_test_answer1);
                }
                $correct=null;
                if ($row->category==2) {
                    $question1=Question::find($row->id);
                    if ($question1->answer==$user_test_answer1) {
                        $correct=1;
                    } else {
                        $correct=0;
                    }
                }
                if ($row->category==1) {
                    $arr_answer = explode(",", $user_test_answer1);
                    $dem=0;
                    for ($i=0;$i<count($arr_answer);$i++) {
                        $answer=Answer::find($arr_answer[$i]);

                        if ($answer->checked!=1) {
                            $dem++;
                        }
                    }
                    if ($dem==0) {
                        $correct=1;
                    } else {
                        $correct=0;
                    }
                }
            }
            $users_test=UserTest::where('user_id', $id_user)
                ->select('id', 'score', 'status')
                ->get();
            foreach ($users_test as $users_test) {
                $id_user_test=$users_test->id;
            }
            DB::insert('insert into user_test_answers (user_test_id, question_id,answer,correct) values (?, ?,?,?)', [$id_user_test, $user_test_answer->question_id,$user_test_answer1,$correct]);
            $k++;
        }
        $diem=0;
        $category='Tự luận';
        if (strlen(strstr($tests->category, $category)) > 0) {
            foreach ($tests->user as $row) {
                if ($row->pivot->user_id==$id_user) {
                    $row->pivot->status = 1;
                    $row->pivot->save();
                }
            }
        } else {
            $users_test = UserTestAnswer::where('user_test_id', $id_user_test)
            ->select('correct', 'answer', 'question_id')->get();
            foreach ($users_test as $user_test) {
                $question=Question::find($user_test->question_id);
                if ($user_test->correct==1) {
                    $diem+=$question->score;
                }
            }
            $user_test = UserTest::find($id_user_test);
            $user_test->score=$diem;
            $user_test->status=1;
            $user_test->save();
        }
        $tests = Test::find($id_test);
        $question = $tests->question;
        return redirect()->route('index_make', [$id_test]);
    }

}
