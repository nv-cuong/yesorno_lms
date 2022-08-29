<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnitRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    public function showUnit($id)
    {
        $unit = Unit::where('id', $id)
            ->first();

        $lessons = Lesson::select([
            'lessons.id',
            'lessons.title',
            'lessons.slug',
            'lessons.config',
            'lessons.created_at',
            'lessons.updated_at',
        ])
            ->join('units', 'lessons.unit_id', 'units.id')
            ->where('units.id', $id)
            ->orderBy('id', 'desc')
            ->paginate();

        return view('admin.modules.courses.units.detail', compact('unit', 'lessons'));
    }

    public function createUnit($course_id)
    {
        $unit = new Unit();
        $course = Course::where('id', $course_id)
            ->pluck('title', 'id');
        return view('admin.modules.courses.units.create', compact('unit', 'course'));
    }

    public function storeUnit(UnitRequest $request)
    {
        $unit_item = $request->except('_token');
        $unit_item['slug'] = Str::slug($unit_item['title']);
        try {
            Unit::create($unit_item);
        } catch (\Throwable $th) {
            throw new ModelNotFoundException();
        }

        return redirect(route('course.detail', ['id' => $unit_item['course_id']]))
            ->with('msg', 'Thêm chương mới thành công');;
    }

    public function editUnit(Request $request, $id)
    {
        $unit = Unit::find($id);

        if ($unit) {
            $course = Course::pluck('title', 'id');
            return view('admin.modules.courses.units.edit', compact('unit', 'course'));
        }
        return redirect(route('course.index'))
            ->with('msg', 'Chương không tồn tại');
    }

    public function updateUnit(UnitRequest $request, $id)
    {
        $msg = 'Chương không tồn tại';
        $unit = Unit::find($id);
        if ($unit) {
            $unit->title = $request->input('title');
            $unit->course_id = $request->input('course_id');
            $unit->slug = Str::slug($unit->title);
            $unit->save();
            $msg = 'Cập nhật khóa học thành công';
        }

        return redirect(route('course.index'))->with('msg', $msg);
    }

    public function destroyUnit(Request $request, $course_id)
    {
        $unit_id = $request->input('unit_id', 0);
        if ($unit_id) {
            Unit::destroy($unit_id);
            return redirect(route('course.detail', ['id' => $course_id]))
                ->with('msg', 'Chương đã được xóa');
        } else
            return redirect(route('course.detail', ['id' => $course_id]))
                ->with('msg', 'Chương không tồn tại');
    }
}
