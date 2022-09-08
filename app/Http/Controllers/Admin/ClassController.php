<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Class\CreateRequest;
use App\Http\Requests\Admin\Class\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\ClassStudy;
use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $classes = ClassStudy::select([
            'id',
            'slug',
            'name',
            'schedule'
        ])
            ->with('courses', 'users')
            ->search()
            ->paginate(1000);
        return view('admin.modules.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            Log::info($t->getMessage());
            throw new ModelNotFoundException();
        }

        return redirect(route('class.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $class = ClassStudy::where('slug', $slug)->first();
        $course = $class->courses()->get();
        $std = $class->users()->get();
        return view('admin.modules.classes.show', compact('class', 'course', 'std'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
            return view('admin.modules.classes.edit', compact('class','courses', 'course'));
        }
        return redirect(route('class.index'))
            ->with('message', 'Không tìm thấy lớp học này')
            ->with('type_alert', "danger");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        //
        $message = 'Lớp học không tồn tại!';
        $class = ClassStudy::find($id);
        if ($class) {
            $class->name        = $request->input('name');
            $class->slug        = Str::slug($class->name);
            $class->description = $request->input('description');
            $class->schedule  = $request->input('schedule');
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
            dd($t);
        }
        return redirect(route('class.index'))
        ->with('message', $message)
        ->with('type_alert', $type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $class_id = $request->input('class_id', 0);
        if ($class_id)
        {
            $data = ClassStudy::find($class_id);
            $name = $data->name;

            if($data->users->count() > 0){
                return redirect(route('class.index'))
                ->with('message', "Không thể xóa! Đang có học sinh đăng kí lớp")
                ->with('type_alert', "danger");
            }
            else{
                $class_dettach = ClassStudy::find($class_id);
                ClassStudy::destroy($class_id);
                $class_dettach->courses()->detach();
                return redirect(route('class.index'))
                ->with('message', "Xóa thành công: ". $name )
                ->with('type_alert', "success");
            }
        }else {
            throw new ModelNotFoundException();
        }
    }
}
