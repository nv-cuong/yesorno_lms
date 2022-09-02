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
            'title',
            'slug',
            'status',
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
        $photo = $request->file('image');
            if ($photo) {
                $path = Storage::putFile('images', $photo);
                $course_item['image'] = $path;
            }
        try {
            Course::create($course_item);
        } catch (\Throwable $th) {
            throw new ModelNotFoundException();
        }

        return redirect(route('course.index'))
            ->with('message', 'Khóa học đã được thêm mới')
            ->with('type_alert', "success");;
    }

    public function editCourse(Request $request, $id)
    {
        $course = Course::find($id);

        if ($course) {
            return view('admin.modules.courses.edit', compact('course'));
        }
        return redirect(route('course.index'))
            ->with('message', 'Khóa học không tồn tại')
            ->with('type_alert', "danger");;
    }

    public function updateCourse(CourseRequest $request, $id)
    {
        $message = 'Khóa học không tồn tại';
        $course = Course::find($id);
        if ($course) {
            $course->title = $request->input('title');
            $course->statistic_id = $course->statistic_id;
            $course->slug = Str::slug($course->title);
            $course->status = $request->input('status');
            $course->begin_date = $request->input('begin_date');
            $course->end_date = $request->input('end_date');
            $photo = $request->file('image');
            dd($photo);
            if ($photo) {
                $path = Storage::putFile('images', $photo);
                $course->image = $path;
            }
            else $course->image = $course->image;
            $course->description = $request->input('description');
            $course->save();
            $message = 'Cập nhật khóa học thành công';
        }

        return redirect(route('course.index'))
            ->with('message', $message)
            ->with('type_alert', "success");;
    }

    public function destroyCourse(Request $request)
    {
        $course_id = $request->input('course_id', 0);
        if ($course_id) {
            Course::destroy($course_id);
            return redirect(route('course.index'))
                ->with('message', 'Khóa học đã được xóa')
                ->with('type_alert', "success");
        } else
            return redirect(route('course.index'))
                ->with('message', 'Khóa học không tồn tại')
                ->with('type_alert', "danger");
    }

    public function showTest($id){

    }
}
