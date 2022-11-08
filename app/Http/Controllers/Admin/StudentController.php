<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentRequest;
use App\Http\Requests\Auth\User\CreateRequest as UserCreateRequest;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Role;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('admin.students.index');
    }

    /**
     *
     * @return DataTables
     */
    public function getStudentData()
    {
        $students = User::select([
            'users.id',
            'phone',
            'birthday',
            'address',
            'age',
            'gender',
            DB::raw("CONCAT(first_name,' ', last_name) as fullname"),
            'first_name',
            'last_name'
        ])
        ->leftJoin('role_users AS ru', 'user_id', 'users.id')
        ->where('ru.role_id', 5)
        ->with('roles', 'activations');

        // @phpstan-ignore-next-line
        return DataTables::of($students)
        ->filterColumn('fullname', function($query, $keyword) {
            $sql = "CONCAT(first_name,' ',last_name)  like ?";
            $query->whereRaw($sql, ["%{$keyword}%"]);
        })
        ->addColumn('actions', function ($student) {
            return view('admin.students.actions', ['row' => $student])->render();
        })
        ->rawColumns(['name', 'actions'])
        ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $roleDb = Role::select('id', 'name')
            ->get();

        return view('admin.students.create', array(
            'roleDb' => $roleDb,
        ));
    }

    /**
     * @param UserCreateRequest $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $email = $request->input('email', '');
        $user  = Sentinel::getUser()->first_name;

        DB::beginTransaction();
        try {
            $data = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => Str::lower($email),
                'password'   => $request->password,
                'phone'   => $request->phone,
                'created_by' => $user,
                'updated_by' => $user,
            ];

            //Create a new user
            $user = Sentinel::registerAndActivate($data);

            //Attach the user to the role
            $role = Sentinel::findRoleById($request->role);
            $role->users()
                ->attach($user);

            DB::commit();

            return redirect()->route('students')
            ->with('msg', 'Học sinh thêm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getFile() . ':'. $e->getFile(). ' : ' . $e->getMessage());
            Session::flash('failed', $e->getMessage() . ' ' . $e->getLine());

            return redirect()
                ->back()
                ->withInput($request->all());
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $classes = $student->classStudies()->where("user_id", $id)->get();
            return view('admin.students.edit', compact('student', 'classes'));
        }

        return redirect(route('students'))
            ->with('msg', 'Học sinh chưa tồn tại!');
    }

    /**
     * @param StudentRequest $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(StudentRequest $request, $id)
    {
        $msg = 'Học sinh chưa tồn tại!';
        $student = User::find($id);
        if ($student) {
            $student->phone = $request->input('phone');
            $student->first_name = $request->input('first_name');
            $student->gender = $request->input('gender');
            $student->last_name = $request->input('last_name');
            $student->address = $request->input('address');
            $student->birthday = $request->input('birthday');
            $student->age = \Carbon\Carbon::parse($request->input('birthday', ''))->age;
            $student->save();
            $msg = 'Thay đổi thành công!';
        }
        return redirect(route('students'))
            ->with('msg', $msg);
    }

    /**
     * @param Request $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $student_id = $request->input('student_id', 0);
        if ($student_id) {
            User::destroy($student_id);
            return redirect(route('students'))
                ->with('msg', "Xóa sinh viên {$student_id} thành công!");
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function showClass(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $classes = $student->classStudies()->where("user_id", $id)->get();
            return view('admin.students.class', compact('student', 'classes'));
        }
        return redirect(route('students'))
            ->with('msg', 'Học sinh chưa tồn tại!');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function showCourse(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $courses = Course::select([
                'courses.id',
                'uc.user_id',
                'courses.slug',
                'title',
            ])
                ->leftJoin('user_courses AS uc', 'uc.course_id', 'courses.id')
                ->where('uc.user_id', $id)
                ->get();

            $lessons = Lesson::select([
                'lessons.id',
                'ul.user_id',
                'title',
                'unit_id',
                'status',
            ])
                ->leftJoin('user_lessons AS ul', 'ul.lesson_id', 'lessons.id')
                ->where('ul.user_id', $id)
                ->get();
            return view('admin.students.course', compact('student', 'courses', 'lessons'));
        }
        return redirect(route('students'))
            ->with('msg', 'Học sinh chưa tồn tại!');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function showStatistic(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $classStudiesNumber = $student->classStudies()->where("user_id", $id)->count();
            $courseLesson = Lesson::select()
                ->leftJoin('units AS u', 'u.id', 'lessons.unit_id')
                ->join('courses AS c', 'c.id', 'u.course_id')
                ->where('c.status', 1)
                ->count();
            $lessonNumber = Lesson::select()
                ->leftJoin('user_lessons AS ul', 'ul.lesson_id', 'lessons.id')
                ->where('ul.user_id', $id)
                ->where('status', 1)
                ->count();

            $coursesNumber = 0;
            if ($courseLesson > 0) {
                $coursesNumber = ceil(($lessonNumber * 100) / $courseLesson);
            }
            return view('admin.students.statistic', compact('student', 'coursesNumber', 'classStudiesNumber'));
        }
        return redirect(route('students'))
            ->with('msg', 'Học sinh chưa tồn tại!');
    }

}
