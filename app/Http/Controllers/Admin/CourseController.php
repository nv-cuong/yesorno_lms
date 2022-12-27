<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use App\Models\Test;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\AssignCourse;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailCourse;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseData()
    {
        $user = Sentinel::getUser();
        $course = Course::select([
            'id',
            'title',
            'status',
            'begin_date',
            'end_date',
            'teacher_id',
        ])->withCount(['users' => function ($query) {
            return $query->where('user_courses.status', 0);
        }])->with(['users', 'user']);

        if ($user->inRole('teacher')) {
            $course = $course->where('teacher_id', $user->id);
        }

        return DataTables::of($course)
            ->editColumn('status', function ($course) {
                if ($course->status == 0) return 'Miễn phí';
                if ($course->status == 1) return 'Tính phí';
                return '';
            })
            ->editColumn('teacher_id', function ($course) {
                $teacher = $course->user;
                if($teacher){
                    return $teacher->last_name . ' ' . $teacher->first_name;
                }
                return '';
            })
            ->addColumn('actions', function ($course) {
                return view('admin.modules.courses.actions', ['row' => $course])->render();
            })
            ->rawColumns(['actions'])
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
        $teacher = Sentinel::getUser();
        $course_item['teacher_id'] = $teacher->id;
        $course_item['slug'] = Str::slug($course_item['title']);
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $path = $this->uploadFile($photo);
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
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
            $course->slug           = Str::slug($course->title);
            $course->status         = $request->input('status');
            $course->begin_date     = $request->input('begin_date');
            $course->end_date       = $request->input('end_date');
            $course->description    = $request->input('description');

            if ($request->hasFile('image')) {
                $photo                  = $request->file('image');
                $course->image = $this->uploadFile($photo);
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
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
     * @param integer $id
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
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
     * @param integer $id
     * @return DataTables
     */
    public function getStudentData($id)
    {
        $users = User::select([
            'users.id',
            'email',
            'status',
            'stu_id',
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
     * @param int $courseId
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function activeStudent(Request $request, $courseId)
    {
        $user_id = $request->input('user_id', 0);
        $user = User::find($user_id);
        $course = Course::find($courseId);

        $msg = 'Học viên không tồn tại';
        $type = 'danger';

        if ($user && $course) {
            if ($user->courses()
                ->where('course_id', $courseId)
                ->where('user_courses.status', 0)
                ->exists()
            ) {
                $user->courses()
                    ->updateExistingPivot($courseId, ['status' => 1]);
                $assignNotification = [
                    'course_id' => $courseId,
                    'course_name' => $course->title,
                    'course_slug' => $course->slug,
                    'course_begin_date' => $course->begin_date->format('d/m/Y'),
                    'course_end_date' => $course->end_date->format('d/m/Y'),

                ];
                $email_user = $user->email;
                Mail::to($email_user)->send(new SendEmailCourse($assignNotification,$user));
                $user->notify(new AssignCourse($assignNotification));

                $msg = 'Học viên đã được chấp nhận vào khóa học';
                $type = 'success';
            }
        }
        return redirect(route('course.student', $courseId))
            ->with('message', $msg)
            ->with('type_alert', $type);
    }

    // @phpstan-ignore-next-line
    private function uploadFile($photo)
    {
        $name = $photo->getClientOriginalName();
        return $photo->storeAs('images', $name);
    }
}
