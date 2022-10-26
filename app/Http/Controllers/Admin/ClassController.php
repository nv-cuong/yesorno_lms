<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Class\CreateRequest;
use App\Http\Requests\Admin\Class\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // $classes = ClassStudy::select([
        //     'id',
        //     'slug',
        //     'name',
        //     'schedule'
        // ])
        //     ->with(['users', 'courses'])
        //     ->search()
        //     ->paginate(100);
        // return view('admin.modules.classes.index', compact('classes'));
        return view('admin.modules.classes.index');
    }

    /**
     *
     * @return DataTables
     */
    public function getClassData()
    {
        $class = ClassStudy::select([
            'class.id',
            'name',
            'description',
            'schedule',
        ]);

        // @phpstan-ignore-next-line
        return DataTables::of($class)
        // ->addColumn('actions', function ($class) {
        //     return view('admin.classes.actions', ['row' => $class])->render();
        // })->addColumn('total_stu', function ($class) {
        //     $total = $class->user->count();
        //     return $total;
        // })
        // ->rawColumns(['total_stu', 'actions'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $course = [];
        $class = new ClassStudy();
        $courses = Course::select([
            'id',
            'title',
        ])->get();
        return view('admin.modules.classes.create', compact('courses', 'class', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Class\CreateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {

        $class_item = $request->except('_token');
        DB::beginTransaction();
        try {
            $class = ClassStudy::create([
                'name'          => $class_item['name'],
                'slug'          => Str::slug($class_item['name']),
                'description'   => $class_item['description'],
                'schedule'    => $class_item['schedule'],
            ]);
            if (isset($_POST['course_id'])) {
                foreach ($_POST['course_id'] as $value) {
                    //Xử lý các phần tử được chọn
                    $course = Course::find($value);
                    $class->courses()->attach($course->id);
                }
            }
            $message            = 'Tạo lớp học thành công';
            $type               = 'success';
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }

        return redirect(route('class.index'))
            ->with('message', $message)
            ->with('type_alert', $type);;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $class = ClassStudy::where('slug', $slug)->with('courses', 'users')->first();
        return view('admin.modules.classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $courses = Course::select([
            'id',
            'title',
        ])->get();
        $class = ClassStudy::find($id);
        if ($class) {
            $course = $class->courses()->get();
            return view('admin.modules.classes.edit', compact('class', 'courses', 'course'));
        }
        return redirect(route('class.index'))
            ->with('message', 'Không tìm thấy lớp học này')
            ->with('type_alert', "danger");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Class\UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        //
        $message = 'Lớp học không tồn tại!';
        $type    = 'danger';
        $class = ClassStudy::find($id);
        if ($class->users->count() > 0) {
            return redirect(route('class.index'))
                ->with('message', "Không thể sửa! Đã có học viên đăng kí lớp")
                ->with('type_alert', "danger");
        } 
        if ($class) {
            $class->name        = $request->input('name');
            $class->slug        = Str::slug($class->name);
            $class->description = $request->input('description');
            $class->schedule    = $request->input('schedule');
            $class->save();
            $message            = 'Cập nhật lớp học thành công';
            $type               = 'success';
        }

        try {
            if (isset($_POST['course_id'])) {
                $class_dettach = ClassStudy::find($class->id);
                $class_dettach->courses()->detach();
                foreach ($_POST['course_id'] as $value) {
                    //Xử lý các phần tử được chọn
                    $course = Course::find($value);
                    $class->courses()->attach($course->id);
                }
            }
        } catch (\Throwable $t) {
            throw new ModelNotFoundException();
        }
        return redirect(route('class.index'))
            ->with('message', $message)
            ->with('type_alert', $type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $class_id = $request->input('class_id', 0);
        if ($class_id) {
            $data = ClassStudy::find($class_id);
            $name = $data->name;

            if ($data->users->count() > 0) {
                return redirect(route('class.index'))
                    ->with('message', "Không thể xóa! Đang có học sinh đăng kí lớp")
                    ->with('type_alert', "danger");
            } else {
                $class_dettach = ClassStudy::find($class_id);
                ClassStudy::destroy($class_id);
                $class_dettach->courses()->detach();
                return redirect(route('class.index'))
                    ->with('message', "Xóa thành công: " . $name)
                    ->with('type_alert', "success");
            }
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * Show the form for adding a new resource.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function add($slug)
    {
        $class = ClassStudy::where('slug', $slug)->first();
        $std = $class->users()->get();
        $stds = User::select([
            'users.id',
            'email',
            'birthday',
            'gender',
            'first_name',
            'last_name'
        ])
            ->leftJoin('role_users AS ru', 'user_id', 'users.id')
            ->where('ru.role_id', 5)
            ->with('roles', 'activations')
            ->search()
            ->paginate(1000);
        return view('admin.modules.classes.add_student', compact('class', 'std', 'stds'));
    }

    /**
     * Show the form for adding a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join($id)
    {
        $message = 'Học viên không tồn tại!';
        $type = 'danger';
        $class = ClassStudy::find($id);
        $courses = $class->courses()->get();
        try {
            if (isset($_POST['std_id'])) {
                foreach ($_POST['std_id'] as $value) {
                    //Xử lý các phần tử được chọn
                    $student = User::find($value);
                    if ($student->hasClass($class->id)) continue;
                    else {
                        $class->users()->attach($student->id);
                        foreach ($courses as $course) {
                            if ($student->hasCourse($course->id)) continue;
                            else {
                                $student->courses()->attach($course->id, ['status' => 1]);
                                $units = Unit::where('course_id', $course->id)->with('lessons')->get();
                                foreach ($units as $unit) {
                                    foreach ($unit->lessons as $lesson) {
                                        $student->lessons()->attach($lesson->id);
                                    }
                                }
                            }
                        }
                    }
                }
                $message    = 'Thêm học viên mới thành công';
                $type       = 'success';
            } else {
                return redirect(route('class.show', $class->slug));
            }
        } catch (\Throwable $t) {
            throw new ModelNotFoundException();
        }
        return redirect(route('class.show', $class->slug))
            ->with('message', $message)
            ->with('type_alert', $type);
    }
}
