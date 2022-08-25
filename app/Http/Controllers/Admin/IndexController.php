<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassStudy;
use App\Models\Course;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class IndexController extends Controller
{
    //
    public function index(){
        $std = Sentinel::findRoleBySlug('student');
        $course = Course::select('id');
        $class = ClassStudy::select('id');
        return view('admin.dashboard', compact('class', 'course', 'std'));
    }
}
