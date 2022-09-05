<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Course;
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
        $ok = '';
        if($user){
            $course_of_user = $user->courses()->get();
            foreach($course_of_user as $check){
                if($check->id == $course->id){
                    $ok = '1';
                }
            }
        }
        return view('client.modules.course_detail', compact('course', 'units', 'user', 'ok'));
    }

    public function attach(Request $request)
    {
        if ($getUser = Sentinel::getUser()) {
            $getUser->courses()->attach($request->course_id);
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
            return redirect(route('detail', $request->course_slug))
                ->with('message', "Bạn đã hủy đăng kí khóa học này !")
                ->with('type_alert', "success");
 
    }
}
