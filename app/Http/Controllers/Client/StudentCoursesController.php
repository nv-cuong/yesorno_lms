<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\File;

class StudentCoursesController extends Controller
{
    public function personalCourse($id,$slug){
        $course = Course::where('slug', $slug)->first();
        $courses = Course::select()->paginate(3);
        $lessons = Lesson::select([
            'lessons.id',
            'ul.user_id',
            'title',
            'unit_id',
            'status',
            'lessons.slug'
        ])
        ->leftJoin('user_lessons AS ul','ul.lesson_id', 'lessons.id')
        ->where('ul.user_id',$id)
        ->get();
        $courseLesson =Lesson::select()
        ->leftJoin('units AS u','u.id', 'lessons.unit_id')
        ->join('courses AS c', 'c.id', 'u.course_id')
        ->where('c.id',$course->id)
        ->count();
        return view('client.modules.personal_course_detail',compact('course','courses','lessons','id','courseLesson'));
    }

    public function personalLesson($id,$slug){
        $lesson = Lesson::where('slug', $slug)->first();
        $slCount = Lesson::select()
        ->leftJoin('user_lessons AS ul','ul.lesson_id', 'lessons.id')
        ->where('ul.user_id',$id)
        ->where('status',1)
        ->count();
        $unitCount = Lesson::select()
        ->where('unit_id',$lesson->unit_id)
        ->count();
        $status = $slCount==$unitCount;
        $files = File::all()
            ->where('lesson_id', $lesson->id);
        return view('client.modules.lesson',compact('lesson','files','id','slug','status'));
    }

    public function lessonProgress($id,$slug){
        $lesson = Lesson::where('slug', $slug)->first();
        $studentLesson =Lesson::select([
            'lessons.id',
            'ul.user_id',
            'title',
            'unit_id',
            'status',
            'lessons.slug'
        ])
        ->leftJoin('user_lessons AS ul','ul.lesson_id', 'lessons.id')
        ->where('ul.user_id',$id)
        ->where('lesson_id', $lesson->id)
        ->update(['status' => 1]);
    }
}
