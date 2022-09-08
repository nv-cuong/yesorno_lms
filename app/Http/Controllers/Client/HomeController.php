<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Notification;
use App\Models\User;
use App\Models\Question;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * {@inheritDoc}
     * @see \App\Http\Controllers\Controller::compose()
     */
    public function compose(View $view)
    {
        $user = Sentinel::getUser();
        if ($user) {
            $user_tests = UserTest::where('user_id', $user->id)->where('status', 0)->get();
            $count_user_tests = $user_tests->count();
            $view->with('user_tests', $user_tests);
            $view->with('count_user_tests', $count_user_tests);
        }
    }

    /**
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index() 
    {
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'status',
            'description',
            'begin_date',
            'end_date',
            'image'

        ])
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();

        $classes = ClassStudy::select([
            'id'
        ]);
        return view('client.modules.home', compact('courses', 'classes'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function courses(Request $request)
    {
        if ($request->sort == 'old') {
            $name = 'created_at';
            $sort = 'ASC';
        } elseif ($request->sort == 'new') {
            $name = 'created_at';
            $sort = 'DESC';
        } elseif ($request->sort == 'name') {
            $name = 'title';
            $sort = 'ASC';
        } else {
            $name = 'created_at';
            $sort = 'DESC';
        }
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'status',
            'description',
            'begin_date',
            'end_date',
            'image'
        ])
            ->with('units', 'users')
            ->orderBy($name, $sort)
            // ->where('status', $filter)
            ->paginate(6);
        $courseTotal = Course::select([
            'id',
        ]);
        return view('client.modules.courses', compact('courses', 'courseTotal'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function courseFilter(Request $request)
    {
        if ($request->filter == 'free') {
            $filter = '0';
        } elseif ($request->filter == 'pro') {
            $filter = '1';
        }
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'status',
            'description',
            'begin_date',
            'end_date',
            'image'
        ])
            ->with('units', 'users')
            ->where('status', $filter)
            ->paginate(6);
        $courseTotal = Course::select([
            'id',
        ]);
        return view('client.modules.courses', compact('courses', 'courseTotal'));
    }

    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function personal(Request $request)
    {
        $getUser = Sentinel::getUser();
        $id = $getUser->id;
        $student = User::where('id', $id)->first();;
        $courses = User::find($id)->courses()->where("user_id", $id)->paginate(3);
        $lessons = User::find($id)->lessons()->where([["user_id", $id], ['status', 1]])->count();
        $courseLesson = Lesson::select()
            ->leftJoin('units AS u', 'u.id', 'lessons.unit_id')
            ->join('courses AS c', 'c.id', 'u.course_id')
            ->where('c.status', 1)
            ->count();
            if($courseLesson != 0){
                $progress = ceil(($lessons*100)/$courseLesson);
            }
            else $progress = 0;
        return view('client.modules.personal', compact('student', 'progress', 'courses'));
    }


    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function contact()
    {
        return view('client.modules.contact');
    }

    /**
     * @param Request $request
     */
    public function search(Request $request)
    {
        $output = '';
        $course = Course::where('title', 'LIKE', '%' . $request->keyword . '%')->get();
    }
}
