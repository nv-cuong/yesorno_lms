<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LessonRequest;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function showLesson($slug)
    {
        $lesson = Lesson::where('slug', $slug)
            ->first();

        return view('admin.modules.courses.units.lessons.detail', compact('lesson'));
    }

    public function createLesson($unit_id)
    {
        $lesson = new Lesson();
        $unit = Unit::where('id', $unit_id)
            ->pluck('title', 'id');
        return view('admin.modules.courses.units.lessons.create', compact('lesson', 'unit'));
    }

    public function storeLesson(LessonRequest $request)
    {
        $lesson_item = $request->except('_token');
        $lesson_item['slug'] = Str::slug($lesson_item['title']);
        try {
            Lesson::create($lesson_item);
        } catch (\Throwable $th) {
            throw new ModelNotFoundException();
        }

        return redirect(route('unit.detail', ['id' => $lesson_item['unit_id']]))
            ->with('msg', 'Thêm bài học mới thành công');;
    }

    public function editLesson(Request $request, $id)
    {
        $lesson = Lesson::find($id);

        if ($lesson) {
            $unit = Unit::pluck('title', 'id');
            return view('admin.modules.courses.units.lessons.edit', compact('lesson', 'unit'));
        }
        return redirect(route('course.index'))
            ->with('msg', 'Bài học không tồn tại');
    }

    public function updateLesson(LessonRequest $request, $id)
    {
        $msg = 'Bài học không tồn tại';
        $lesson = Lesson::find($id);
        if ($lesson) {
            $lesson->title = $request->input('title');
            $lesson->unit_id = $request->input('unit_id');
            $lesson->slug = Str::slug($lesson->title);
            $lesson->config = $request->input('config');
            $lesson->path = $request->input('path');
            $lesson->content = $request->input('content');
            $lesson->published = $request->input('published');
            $lesson->save();
            $msg = 'Cập nhật bài học thành công';
        }

        return redirect(route('course.index'))->with('msg', $msg);
    }

    public function destroyLesson(Request $request, $unit_id)
    {
        $lesson_id = $request->input('lesson_id', 0);
        if ($lesson_id) {
            Lesson::destroy($lesson_id);
            return redirect(route('unit.detail', ['id' => $unit_id]))
                ->with('msg', 'Bài học đã được xóa');
        } else
            return redirect(route('unit.detail', ['id' => $unit_id]))
                ->with('msg', 'Bài học không tồn tại');
    }
}
