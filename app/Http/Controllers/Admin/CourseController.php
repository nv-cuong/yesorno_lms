<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Test;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $courses = Course::select([
            'id',
            'title',
            'slug',
            'status',
            'begin_date',
            'end_date',
        ])
            ->paginate(1000);
        return view('admin.modules.courses.index', compact('courses'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
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
            ->paginate(1000);

        return view('admin.modules.courses.detail', compact('course', 'units'));
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createCourse()
    {
        $course = new Course();
        return view('admin.modules.courses.create', compact('course'));
    }

    /**
     * @param CourseRequest $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
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
            ->with('type_alert', "success");
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function editCourse(Request $request, $id)
    {
        $course = Course::find($id);

        if ($course) {
            return view('admin.modules.courses.edit', compact('course'));
        }
        return redirect(route('course.index'))
            ->with('message', 'Khóa học không tồn tại')
            ->with('type_alert', "danger");
    }

    /**
     * @param CourseRequest $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function updateCourse(CourseRequest $request, $id)
    {
        $message = 'Khóa học không tồn tại';
        $type = 'danger';
        $course = Course::find($id);
        if ($course) {
            $course->title = $request->input('title');
            $course->statistic_id = $course->statistic_id;
            $course->slug = Str::slug($course->title);
            $course->status = $request->input('status');
            $course->begin_date = $request->input('begin_date');
            $course->end_date = $request->input('end_date');
            $photo = $request->file('image');
            if ($photo) {
                $path = Storage::putFile('images', $photo);
                $course->image = $path;
            } else $course->image = $course->image;
            $course->description = $request->input('description');
            $course->save();
            $message = 'Cập nhật khóa học thành công';
            $type = 'success';
        }

        return redirect(route('course.index'))
            ->with('message', $message)
            ->with('type_alert', $type);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function showTest($id)
    {
        $course = Course::find($id);
        if ($course) {
            $tests = Test::select([
                'tests.id',
                'ct.course_id',
                'category',
                'title',
            ])
                ->leftJoin('course_tests AS ct', 'ct.test_id', 'tests.id')
                ->where('ct.course_id', $id)
                ->get();

            return view('admin.modules.courses.test', compact('course', 'tests'));
        }
        return redirect(route('course.index'))
            ->with('message', 'Khóa học không tồn tại')
            ->with('type_alert', "danger");
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function showStudent(Request $request, $id)
    {
        $course = Course::find($id);
        if ($course) {
            $users = User::select([
                'users.id',
                'uc.course_id as course_id',
                'first_name',
                'last_name',
                'email',
                'uc.status as status'
            ])
                ->leftJoin('user_courses AS uc', 'uc.user_id', 'users.id')
                ->where('uc.course_id', $id)
                ->get();
            return view('admin.modules.courses.student', compact('users', 'course'));
        }
        return redirect(route('course.index'))
            ->with('message', 'Khóa học không tồn tại')
            ->with('type_alert', "danger");
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function activeStudent(Request $request, $id)
    {
        $user_id = $request->input('user_id', 0);
        if ($user_id) {
            $user_course = DB::table('user_courses')
                ->where('user_id', $user_id)
                ->where('course_id', $id)
                ->first();
            if ($user_course->status == 0) {
                DB::table('user_courses')->where('id', $user_course->id)->update(['status' => 1]);
            }
            $user = User::find($user_id);
            $notification = Notification::find(1);
            $user->notifications()->attach($notification->id);
            return redirect(route('course.student', $id))
                ->with('message', 'Học viên đã được chấp nhận vào khóa học')
                ->with('type_alert', "success");
        } else
            return redirect(route('course.student', $id))
                ->with('message', 'Học viên không tồn tại')
                ->with('type_alert', "danger");
    }
}
