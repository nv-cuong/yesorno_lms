<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function showCourse($id)
    {
        $course = Course::where('id', $id)
            ->first();

        $units = Unit::select([
            'units.id',
            'units.title',
            'units.slug',
            'units.created_at',
            'units.updated_at',
        ])
            ->join('courses', 'units.course_id', 'courses.id')
            ->where('courses.id', $id)
            ->orderBy('id', 'desc')
            ->paginate();

        return view('admin.modules.courses.detail', compact('course', 'units'));

    }

    public function createCourse()
    {
        $course = new Course();
        return view('admin.modules.courses.create', compact('course'));
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

    public function editCourse(Request $request, $id)
    {
        $course = Course::find($id);

        if ($course) {
            return view('admin.modules.courses.edit', compact('course'));
        }
        return redirect(route('course.index'))
            ->with('msg', 'Khóa học không tồn tại');
    }

    public function updateCourse(CourseRequest $request, $id)
    {
        $msg = 'Khóa học không tồn tại';
        $course = Course::find($id);
        if ($course) {
            $course->title = $request->input('title');
            $course->statistic_id = $course->statistic_id;
            $course->slug = Str::slug($course->title);
            $course->begin_date = $request->input('begin_date');
            $course->end_date = $request->input('end_date');
            $photo = $request->file('image');
            $path = Storage::putFile('image', $photo);
            $course->image = $path;
            $course->description = $request->input('description');
            $course->save();
            $msg = 'Cập nhật khóa học thành công';
        }

        return redirect(route('course.index'))->with('msg', $msg);
    }

    public function destroyCourse(Request $request)
    {
        $course_id = $request->input('course_id', 0);
        if ($course_id) {
            Course::destroy($course_id);
            return redirect(route('course.index'))
                ->with('msg', 'Khóa học đã được xóa');
        } else
            return redirect(route('course.index'))
                ->with('msg', 'Khóa học không tồn tại');
    }

}

