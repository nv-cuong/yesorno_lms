<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\Question;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class IndexController extends Controller
{
    //
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $user = Sentinel::getUser();
        if (!$user) {
            return view('login');
        }

        if (!$user->hasAccess('dashboard')) {
            abort(403);
        }

        $students   = User::select([
            'users.id',
        ])
            ->leftJoin('role_users AS ru', 'user_id', 'users.id')
            ->where('ru.role_id', 5);
        $course     = Course::select('id');
        $class      = ClassStudy::select('id');
        $question   = Question::select('id');
        return view('admin.dashboard', compact('class', 'course', 'students', 'question'));
    }
}
