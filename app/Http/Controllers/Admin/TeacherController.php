<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\UserRequest;
use App\Http\Requests\Admin\TeacherRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.teachers.index');
    }

    /**
     *
     * @return DataTables
     */
    public function getTeacherData()
    {
        $teachers = User::select([
            'users.id',
            'phone',
            'email',
            'gender',
            'stu_id',
            DB::raw("CONCAT(last_name,' ', first_name) as fullname"),
            'first_name',
            'last_name'
        ])
            ->leftJoin('role_users AS ru', 'user_id', 'users.id')
            ->where('ru.role_id', 3)
            ->with('roles', 'activations');

        // @phpstan-ignore-next-line
        return DataTables::of($teachers)
            ->filterColumn('fullname', function ($query, $keyword) {
                $sql = "CONCAT(last_name,' ',first_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('gender', function ($teacher) {
                if ($teacher->gender == 'male') return 'Nam';
                if ($teacher->gender == 'female') return 'Nữ';
                if ($teacher->gender == 'other') return 'Khác';
            })
            ->addColumn('actions', function ($teacher) {
                return view('admin.teachers.actions', ['row' => $teacher])->render();
            })
            ->rawColumns(['fullname', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
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
                'phone'      => $request->phone,
                'created_by' => $user,
                'updated_by' => $user,
                'stu_id'     => $request->stu_id,
            ];

            //Create a new user
            $newUser = Sentinel::registerAndActivate($data);

            //Attach the user to the role
            $newUser->roles()->attach($request->role);

            DB::commit();

            return redirect()->route('teacher.index')
                ->with('msg', 'Thêm giảng viên thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getFile() . ':' . $e->getFile() . ' : ' . $e->getMessage());
            Session::flash('failed', $e->getMessage() . ' ' . $e->getLine());

            return redirect()
                ->back()
                ->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $teacher = User::find($id);
        if ($teacher) {
            return view('admin.teachers.detail', compact('teacher'));
        }
        return redirect(route('teacher.index'))
            ->with('msg', 'Giảng viên không tồn tại!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $teacher = User::find($id);
        if ($teacher) {
            $classes = $teacher->classStudies()->where("user_id", $id)->get();
            return view('admin.teachers.edit', compact('teacher', 'classes'));
        }

        return redirect(route('teacher.index'))
            ->with('msg', 'Giảng viên không tồn tại!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeacherRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TeacherRequest $request, $id)
    {
        $msg = 'Học sinh chưa tồn tại!';
        $teacher = User::find($id);
        if ($teacher) {
            $teacher->phone = $request->input('phone');
            $teacher->first_name = $request->input('first_name');
            $teacher->gender = $request->input('gender');
            $teacher->last_name = $request->input('last_name');
            $teacher->address = $request->input('address');
            $teacher->birthday = $request->input('birthday');
            $teacher->stu_id = $request->input('stu_id');
            $teacher->age = \Carbon\Carbon::parse($request->input('birthday', ''))->age;
            $teacher->save();
            $msg = 'Thay đổi thành công!';
        }
        return redirect(route('teacher.index'))
            ->with('msg', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $teacher_id = $request->input('student_id', 0);
        if ($teacher_id) {
            User::destroy($teacher_id);
            return redirect(route('teacher.index'))
                ->with('msg', "Xóa giảng viên {$teacher_id} thành công!");
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function showCourse(Request $request, $id)
    {
        $teacher = User::find($id);
        if ($teacher) {
            $courses = Course::select([
                'courses.id',
                'teacher_id',
                'courses.slug',
                'title',
            ])
                ->where('teacher_id', $id)
                ->get();
            return view('admin.teachers.course', compact('teacher', 'courses'));
        }
        return redirect(route('teacher.index'))
            ->with('msg', 'Không có giảng viên theo yêu cầu, vui lòng kiểm tra lại!');
    }
}
