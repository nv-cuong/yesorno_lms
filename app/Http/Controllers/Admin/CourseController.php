<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::select([
            'id',
            'statistic_id',
            'title',
            'slug',
            'description',
            'begin_date',
            'end_date',
            'image',
            'created_at',
            'updated_at',
        ])
        ->paginate();
        return view('admin.modules.courses.index', compact('courses'));
    }

    public function show($slug)
    {
        $course = Course::join('units', 'units.course_id', 'courses.id')
        ->where('slug', $slug)
        ->first();

        return view('admin.modules.courses.detail', compact('course'));
    }
}
