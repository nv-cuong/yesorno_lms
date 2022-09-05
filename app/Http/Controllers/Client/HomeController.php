<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'description',
            'begin_date',
            'end_date',
            'image'

        ])->take(4)
            ->get();

        $classes = ClassStudy::select([
            'id'
        ]);
        return view('client.modules.home', compact('courses', 'classes'));
    }

    public function courses()
    {
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'description',
            'begin_date',
            'end_date',
            'image'
        ])->with('units')->paginate(3);
        $courseTotal = Course::select([
            'id',
        ]);
        return view('client.modules.courses', compact('courses', 'courseTotal'));
    }

    public function personal($id)
    {
        $student = User::where('id', $id)->first();;
        $courses = User::find($id)->courses()->where("user_id",$id)->paginate(3);
        $lessons = User::find($id)->lessons()->where([["user_id",$id],['status',1]])->count();
        $progress= ceil( ($lessons*100)/(Lesson::all()->count()));
        return view('client.modules.personal', compact('student','progress','courses'));
    }

    public function contact()
    {
        return view('client.modules.contact');
    }

    public function search( Request $request)
    {
        $output = '';
        $course = Course::where('title', 'LIKE', '%'.$request->keyword.'%')->get();


    }
}
