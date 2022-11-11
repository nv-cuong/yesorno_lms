<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Mail\SendEmail;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Test;
use App\Models\Unit;
use App\Models\User;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('admin.modules.courses.index');
    }

    /**
     *
     * @return DataTables
     */
    public function getCourseData()
    {
        $course = Course::select([
            'id',
            'title',
            'status',
            'begin_date',
            'end_date',
        ])
            ->withCount(['users' => function ($query) {
                return $query->where('status', 0);
            }]);

        return DataTables::of($course)
            ->editColumn('status', function ($course) {
                if ($course->status == 0) return 'Miễn phí';
                if ($course->status == 1) return 'Tính phí';
            })
            ->addColumn('actions', function ($course) {
                return view('admin.modules.courses.actions', ['row' => $course])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     *
     * @return DataTables
     */
    public function getUnitData($id)
    {
        $units = Unit::select([
            'id',
            'course_id',
            'title',
        ])->where('course_id', $id);

        // @phpstan-ignore-next-line
        return DataTables::of($units)
            ->addColumn('actions_unit', function ($unit) {
                return view('admin.modules.courses.actions_unit', ['row' => $unit])->render();
            })
            ->rawColumns(['actions_unit'])
            ->make(true);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showCourse($id)
    {
        $course = Course::find($id);
        return view('admin.modules.courses.detail', compact('course'));
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
            $course->title          = $request->input('title');
            $course->statistic_id   = $course->statistic_id;
            $course->slug           = Str::slug($course->title);
            $course->status         = $request->input('status');
            $course->begin_date     = $request->input('begin_date');
            $course->end_date       = $request->input('end_date');
            $course->description    = $request->input('description');
            $photo                  = $request->file('image');
            if ($photo) {
                $path = Storage::putFile('images', $photo);
                $course->image = $path;
            } else {
                $course->image          = $course->image;
            }

            $course->save();
            $message                = 'Cập nhật khóa học thành công';
            $type                   = 'success';
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
        $course_id  = $request->input('course_id', 0);
        $course     = Course::find($course_id);

        if ($course) {
            if ($course->users()->exists()) {
                return redirect(route('course.index'))
                    ->with('message', 'Khóa học đã có người tham gia, không thể xóa!')
                    ->with('type_alert', "danger");
            } else {
                $course->questions()->delete();
                $course->destroy($course_id);

                return redirect(route('course.index'))
                    ->with('message', 'Khóa học đã được xóa!')
                    ->with('type_alert', "success");
            }
        } else
            return redirect(route('course.index'))
                ->with('message', 'Khóa học không tồn tại!')
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
            return view('admin.modules.courses.test', compact('course'));
        }
        return abort(404);
    }

    /**
     *
     * @return DataTables
     */
    public function getTestData($id)
    {
        $tests = Test::select([
            'tests.id',
            'title',
            'category',
        ])->leftJoin('course_tests AS ct', 'ct.test_id', 'tests.id')
            ->where('ct.course_id', $id);

        // @phpstan-ignore-next-line
        return DataTables::of($tests)
            ->editColumn('category', function ($test) {
                if ($test->category == 0) return 'Bài thi';
                return 'Khảo sát';
            })
            ->rawColumns(['category'])
            ->make(true);
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
            $users = $course->users()->get();
            return view('admin.modules.courses.student', compact('users', 'course'));
        }
        return redirect(route('course.index'))
            ->with('message', 'Khóa học không tồn tại')
            ->with('type_alert', "danger");
    }

    /**
     *
     * @return DataTables
     */
    public function getStudentData($id)
    {
        $users = User::select([
            'users.id',
            'email',
            'status',
            DB::raw("CONCAT(last_name,' ', first_name) as fullname"),
        ])->leftJoin('user_courses AS uc', 'uc.user_id', 'users.id')
            ->where('uc.course_id', $id);

        // @phpstan-ignore-next-line
        return DataTables::of($users)
            ->editColumn('status', function ($user) {
                if ($user->status == 0) {
                    $message = 'Chấp nhận';
                    return '<a href="" data-toggle="modal" data-target="#activeModal"
                        onclick="javascript:user_active(' . $user->id . ')">' .
                        $message . '
                    </a>';
                } else {
                    $message = 'Đã chấp nhận';
                    return $message;
                }
            })
            ->filterColumn('fullname', function ($user, $keyword) {
                $sql = "CONCAT(last_name,' ',first_name)  like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['fullname', 'status'])
            ->make(true);
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

            $email_user = $user->email;
            //send mail
            Mail::to($email_user)->send(new SendEmail());

            return redirect(route('course.student', $id))
                ->with('message', 'Học viên đã được chấp nhận vào khóa học')
                ->with('type_alert', "success");
        } else
            return redirect(route('course.student', $id))
                ->with('message', 'Học viên không tồn tại')
                ->with('type_alert', "danger");
    }
}
