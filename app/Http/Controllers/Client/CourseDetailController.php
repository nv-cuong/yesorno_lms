<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Unit;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class CourseDetailController extends Controller
{
    public function courseDetail($slug)
    {
        $course = Course::where('slug', $slug)->with('classStudies', 'users')->first();
        $units = Unit::where('course_id', $course->id)->get();
        $user = Sentinel::getUser();
        $access = '';
        if ($user) {
            $access = Course::select([
                'courses.id',
                'uc.status',
            ])
                ->join('user_courses AS uc', 'uc.course_id', 'courses.id')
                ->where('courses.id', $course->id)
                ->where('uc.user_id', $user->id)
                ->first();
        }
        return view('client.modules.course_detail', compact('course', 'units', 'user', 'access'));
    }

    public function attach(Request $request)
    {
        if ($getUser = Sentinel::getUser()) {
            $getUser->courses()->attach($request->course_id);
            $getUser->lessons()->attach($request->lesson_id);
            return redirect(route('detail', $request->course_slug))
                ->with('message', "Đăng kí khóa học thành công. Hãy học ngay !")
                ->with('type_alert', "success");
        } else {
            return redirect(route('detail', $request->course_slug))
                ->with('message', "Không thể đăng kí. Hãy đăng nhập !")
                ->with('type_alert', "success");
        }
    }

    public function detach(Request $request)
    {
        $getUser = Sentinel::getUser();
        $getUser->courses()->detach($request->course_id);
        $lessons = Lesson::select([
            'ul.lesson_id'
        ])
            ->leftJoin('user_lessons AS ul', 'ul.lesson_id', 'lessons.id')
            ->leftJoin('units AS u', 'u.id', 'lessons.unit_id')
            ->join('courses AS c', 'c.id', 'u.course_id')
            ->where('ul.user_id', $getUser->id)
            ->where('c.id', $request->course_id)
            ->get();
        foreach ($lessons as $lesson) {
            $getUser->lessons()->detach($lesson->lesson_id);
        }
        return redirect(route('detail', $request->course_slug))
            ->with('message', "Bạn đã hủy đăng kí khóa học này !")
            ->with('type_alert', "success");
    }
}
