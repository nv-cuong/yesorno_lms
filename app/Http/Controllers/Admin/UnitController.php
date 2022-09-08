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
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showUnit($id)
    {
        $unit = Unit::where('id', $id)
            ->first();

        $lessons = Lesson::select([
            'lessons.id',
            'lessons.title',
            'lessons.slug',
            'lessons.config',
            'published'
        ])
            ->join('units', 'lessons.unit_id', 'units.id')
            ->where('units.id', $id)
            ->paginate(1000);

        return view('admin.modules.courses.units.detail', compact('unit', 'lessons'));
    }

    /**
     * @param int $course_id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createUnit($course_id)
    {
        $unit = new Unit();
        $course = Course::where('id', $course_id)
            ->pluck('title', 'id');
        return view('admin.modules.courses.units.create', compact('unit', 'course'));
    }

    /**
     * @param UnitRequest $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function storeUnit(UnitRequest $request)
    {
        $unit_item = $request->except('_token');
        $unit_item['slug'] = Str::slug($unit_item['title']);
        try {
            Unit::create($unit_item);
        } catch (\Throwable $th) {
            throw new ModelNotFoundException();
        }

        return redirect(route('course.detail', [$unit_item['course_id']]))
        ->with('message', 'Thêm chương mới thành công')
        ->with('type_alert', "success");
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function editUnit(Request $request, $id)
    {
        $unit = Unit::find($id);

        if ($unit) {
            $course = Course::pluck('title', 'id');
            return view('admin.modules.courses.units.edit', compact('unit', 'course'));
        }
        return redirect(route('course.detail', [$unit->course_id]))
        ->with('message', 'Chương không tồn tại')
        ->with('type_alert', "danger");
    }

    /**
     * @param UnitRequest $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function updateUnit(UnitRequest $request, $id)
    {
        $message = 'Chương không tồn tại';
        $type = 'danger';
        $unit = Unit::find($id);
        if ($unit) {
            $unit->title = $request->input('title');
            $unit->course_id = $request->input('course_id');
            $unit->slug = Str::slug($unit->title);
            $unit->save();
            $message = 'Cập nhật khóa học thành công';
            $type = 'success';
        }

        return redirect(route('course.detail', [$unit->course_id]))
        ->with('message', $message)
        ->with('type_alert', $type);
    }

    /**
     * @param Request $request
     * @param int $course_id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroyUnit(Request $request, $course_id)
    {
        $unit_id = $request->input('unit_id', 0);
        if ($unit_id) {
            Unit::destroy($unit_id);
            return redirect(route('course.detail', [$course_id]))
            ->with('message', 'Chương đã được xóa')
            ->with('type_alert', "success");
        } else
            return redirect(route('course.detail', [$course_id]))
            ->with('message', 'Chương không tồn tại')
            ->with('type_alert', "danger");
    }
}
