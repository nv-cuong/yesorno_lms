<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::select([
            'id',
            'statistic_id',
            'title',
            'slug',
            'created_at',
            'updated_at',
        ])
            ->orderBy('id', 'desc')
            ->paginate();
        return view('admin.modules.courses.index', compact('courses'));
    }

    public function showCourse($slug)
    {
        $course = Course::where('slug', $slug)
            ->first();

        $units = Unit::select([
            'units.id',
            'units.title',
            'units.slug',
            'units.created_at',
            'units.updated_at',
        ])
            ->join('courses', 'units.course_id', 'courses.id')
            ->where('courses.slug', $slug)
            ->orderBy('id', 'desc')
            ->paginate();

        return view('admin.modules.courses.detail', compact('course', 'units'));
    }

    public function createCourse()
    {
        return view('admin.modules.courses.create');
    }

    public function storeCourse(CourseRequest $request)
    {
        $course_item = $request->except('_token');

        $course_item['slug'] = Str::slug($course_item['title']);
        try {
            Course::create($course_item);
        } catch (\Throwable $th) {
            throw new ModelNotFoundException();
        }

        return redirect(route('course.index'));
    }

    public function destroyCourse(Request $request)
    {
        $course_id = $request->input('course_id', 0);
        if($course_id)
        {
            Course::destroy($course_id);
            return redirect(route('course.index'))
            ->with('msg', 'Khóa học '.$course_id.' đã được xóa');
        } else 
        return redirect(route('course.index'))
        ->with('msg', 'Khóa học không tồn tại');
    }
}
