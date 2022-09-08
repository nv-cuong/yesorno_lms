<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\File;
use App\Models\Lesson;
use App\Models\Unit;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CourseDetailController extends Controller
{
    /**
     * @param string $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function courseDetail($slug)
    {
        $courses = Course::select([
            'title',
            'slug',
            'image',
        ])
        ->take(4)
        ->get();
        $course = Course::where('slug', $slug)->with('classStudies', 'users')->first();
        $units = Unit::where('course_id', $course->id)->get();
        $user = Sentinel::getUser();
        $access = '';
        $class_of_user = '';
        if ($user) {
            $access = Course::select([
                'courses.id',
                'uc.status',
            ])
                ->join('user_courses AS uc', 'uc.course_id', 'courses.id')
                ->where('courses.id', $course->id)
                ->where('uc.user_id', $user->id)
                ->first();
            $class_of_user = ClassStudy::select([
                'class_studies.id'
            ])
                ->join('class_study_users AS cu', 'cu.class_study_id', 'class_studies.id')
                ->join('class_study_courses as cc', 'cc.class_study_id', 'class_studies.id')
                ->where('cu.user_id', $user->id)
                ->where('cc.course_id', $course->id)
                ->pluck('id')
                ->toArray();

        }
        return view('client.modules.course_detail', compact('courses', 'course', 'units', 'user', 'access', 'class_of_user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function attachClass(Request $request)
    {
        $user = Sentinel::getUser();
        $class = ClassStudy::where('id', $request->class_id)->first();
        $class->users()->attach($user->id);
        return redirect(route('detail', $request->course_slug))
            ->with('message', "Bạn đã đăng kí lớp thành công !")
            ->with('type_alert', "success");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function detachClass(Request $request)
    {
        // dd($request->class_id);
        $user = Sentinel::getUser();
        $class = ClassStudy::where('id', $request->class_id)->first();
        $class->users()->detach($user->id);
        return redirect(route('detail', $request->course_slug))
            ->with('message', "Bạn đã hủy đăng kí lớp thành công !")
            ->with('type_alert', "success");
    }

        
    /**
     * showLesson
     *
     * @param  mixed $id
     * @return void
     */
    public function showLesson($id)
    {
        $lesson = Lesson::where('id', $id)
            ->first();
        $files = File::all()
            ->where('lesson_id', $lesson->id);
        return view('client.modules.learning', compact('lesson', 'files'));
    }
}
