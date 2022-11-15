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
use App\Notifications\SendMessageNotification;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        if ($user) {
            $notifications = Notification::select(
                'notifications.id',
                'content',
                'un.user_id',
                'un.course_id',
            )
                ->join('user_notifications as un', 'un.notification_id', 'notifications.id')
                ->where('un.user_id', $user->id)
                ->with('users')
                ->get();
            $view->with('notifications', $notifications);
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function personal()
    {
        $getUser = Sentinel::getUser();
        $id = $getUser->id;
        $student = User::withCount(['courses', 'lessons' => function ($query) {
            return $query->where('status', 1);
        }])->find($id);

        return view('client.modules.personal', compact('student'));
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

    public function uploadImg(Request $request)
    {
        $user = User::find($request['student_id']);

        $file_image = $request->file('name_img');
        $path_old = $user->path;
        $path = Storage::putFile('images', $file_image);
        $name = Storage::url($path);
        if ($path_old != NULL) {
            Storage::delete($path_old);
        }


        $user->name_img = $name;
        $user->path = $path;
        $user->save();

        return redirect(route('personal'));
    }

    public function profile_edit($id)
    {
        $student = User::find($id);
        return view('client.modules.profile', compact('student'));
    }

    public function profile_update(Request $request, $id)
    {

        $student = User::findOrFail($id);
        $student->phone = $request->input('phone');
        $student->first_name = $request->input('first_name');
        $student->gender = $request->input('gender');
        $student->last_name = $request->input('last_name');
        $student->address = $request->input('address');
        $student->birthday = $request->input('birthday');

        $file_image = $request->file('name_img');
        if ($file_image) {
            $path_old = $student->path;
            $path = Storage::putFile('images', $file_image);
            $name = Storage::url($path);
            if ($path_old != NULL) {
                Storage::delete($path_old);
            }
            $student->name_img = $name;
            $student->path = $path;
        }

        $student->save();
        return redirect()->route('personal');
    }
}
