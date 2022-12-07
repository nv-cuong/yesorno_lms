<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends Controller
{
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

        ])->withCount('users')
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();
        return view('client.modules.home', compact('courses'));
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
            ->withCount(['units', 'users'])
            ->orderBy($name, $sort)
            ->paginate(6);

        return view('client.modules.courses', compact('courses'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function courseFilter(Request $request)
    {
        $filter = '';
        if ($request->filter == 'free') {
            $filter = '0';
        } elseif ($request->filter == 'pro') {
            $filter = '1';
        }

        $query = Course::select([
            'id',
            'title',
            'slug',
            'status',
            'description',
            'begin_date',
            'end_date',
            'image'
        ])
            ->withCount(['units', 'users']);
        if ('' != $filter) {
            $query = $query->where('status', $filter);
        }
        $courses = $query->paginate(6);

        return view('client.modules.courses', compact('courses'));
    }


    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function profile()
    {
        $getUser    = Sentinel::getUser();
        $id         = $getUser->id;
        $user       = User::withCount(['courses', 'lessons' => function ($query) {
            return $query->where('status', 1);
        }])->find($id);

        return view('client.modules.profile', compact('user'));
    }


    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function contact()
    {
        return view('client.modules.contact');
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function uploadImg(Request $request)
    {
        $user = User::find($request['student_id']);

        if ($request->hasFile('name_img')) {
            $file_image = $request->file('name_img');
            $user = $this->uploadFile($user, $file_image);
            $user->save();
        }
        return redirect(route('profile'));
    }

    /**
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function profileUpdate()
    {
        $getUser    = Sentinel::getUser();
        $id         = $getUser->id;
        $user       = User::find($id);
        return view('client.modules.profileUpdate', compact('user'));
    }

    /**
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveProfileUpdates(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $student->phone         = $request->input('phone');
            $student->first_name    = $request->input('first_name');
            $student->last_name     = $request->input('last_name');
            $student->gender        = $request->input('gender');
            $student->address       = $request->input('address');
            $student->birthday      = $request->input('birthday');
            if ($request->hasFile('name_img')) {
                $file_image = $request->file('name_img');
                $student    = $this->uploadFile($student, $file_image);
            }
            $student->save();
        }
        return redirect()->route('profile');
    }

    /**
     *
     * @param User $user
     * @param File $file
     * @return User
     */
    private function uploadFile($user, $file)
    {
        $oldPath    = $user->path;
        $name       = $file->getClientOriginalName();
        $newPath    = $file->storeAs('images', $name);

        if ($oldPath != NULL) {
            Storage::delete("$oldPath");
        }
        $user->name_img = $name;
        $user->path     = $newPath;
        return $user;
    }
}
