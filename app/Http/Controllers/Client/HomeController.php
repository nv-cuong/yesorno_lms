<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\User;
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

    public function courses(){
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'description',
            'begin_date',
            'end_date',
            'image'

        ])->paginate(3);
        return view('client.modules.courses',compact('courses'));

    }

    public function courseDetail($slug){
        $course = Course::where('slug', $slug)->first();
        return view('client.modules.course_detail',compact('course'));

    }

    public function personal($id){
        $student = User::where('id', $id)->first();;
        return view('client.modules.personal', compact('student'));
    }
}
