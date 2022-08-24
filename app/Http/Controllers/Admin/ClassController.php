<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassStudy;
use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'name',
            'amount'
        ])
            ->with('courses', 'users')
            ->search()
            ->paginate(5);
        return view('admin.modules.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::select([
            'id',
            'title',
        ])
            ->get();
        return view('admin.modules.classes.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $class_item = $request->except('_token');

        DB::beginTransaction();
        try {
            $class = ClassStudy::create([
                'name'   => $class_item['name'],
                'slug' => \Str::slug($class_item['name']),
                'description'   => $class_item['description'],
                'amount'   => $class_item['amount'],
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
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = ClassStudy::find($id)->with('courses');
        if ($class) {
            // $courses = $class->courses()-get();
            // dd($courses);
            return view('admin.modules.classes.edit', compact('class', 'courses'));
        }
        return redirect(route('class.index'))
            ->with('msg', 'Không tìm thấy lớp học này');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            ClassStudy::destroy($class_id);
            return redirect(route('class.index'))
            ->with('message', "Xóa lớp học thành công!")
            ->with('type_alert', "success");
        }else {
            throw new ModelNotFoundException();
        }
    }
}
