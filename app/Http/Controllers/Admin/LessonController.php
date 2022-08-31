<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LessonRequest;
use App\Models\File;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function showLesson($slug)
    {
        $lesson = Lesson::where('slug', $slug)
            ->first();
        $files = File::all()
            ->where('lesson_id', $lesson->id);
        return view('admin.modules.courses.units.lessons.detail', compact('lesson', 'files'));
    }

    public function createLesson($unit_id)
    {
        $lesson = new Lesson();
        $file = new File();
        $unit = Unit::where('id', $unit_id)
            ->pluck('title', 'id');
        return view('admin.modules.courses.units.lessons.create', compact('lesson', 'file', 'unit'));
    }

    public function storeLesson(LessonRequest $request)
    {
        $lesson_item = $request->except('_token');
        try {
            $lesson = Lesson::create([
                'unit_id' => $lesson_item['unit_id'],
                'title' => $lesson_item['title'],
                'slug' => Str::slug($lesson_item['title']),
                'config' => $lesson_item['config'],
                'published' => $lesson_item['published'],
                'content' => $lesson_item['content'],
            ]);
            File::create([
                'lesson_id' => $lesson->id,
                'type' => 'link',
                'path' => $lesson_item['path_link'],
            ]);
            $zip = $request->file('path_zip');
            if ($zip) {
                $path = Storage::putFile('images', $zip);
                File::create([
                    'lesson_id' => $lesson->id,
                    'type' => 'zip',
                    'path' => $path
                ]);
            }
        } catch (\Throwable $th) {
            throw new ModelNotFoundException();
        }

        return redirect(route('unit.detail', [$lesson_item['unit_id']]))
            ->with('msg', 'Thêm bài học mới thành công');;
    }

    public function editLesson(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        if ($lesson) {
            $unit = Unit::pluck('title', 'id');
            $files = File::select(
                'id',
                'type',
                'path'
            )
                ->where('lesson_id', $lesson->id);
            return view('admin.modules.courses.units.lessons.edit', compact('lesson', 'files', 'unit'));
        }
        return redirect(route('unit.detail', [$lesson->unit_id]))
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
            $lesson->content = $request->input('content');
            $lesson->published = $request->input('published');
            $lesson->save();
            $msg = 'Cập nhật bài học thành công';
        }

        return redirect(route('unit.detail', [$lesson->unit_id]))->with('msg', $msg);
    }

    public function destroyLesson(Request $request, $unit_id)
    {
        $lesson_id = $request->input('lesson_id', 0);
        if ($lesson_id) {
            Lesson::destroy($lesson_id);
            return redirect(route('unit.detail', [$unit_id]))
                ->with('msg', 'Bài học đã được xóa');
        } else
            return redirect(route('unit.detail', [$unit_id]))
                ->with('msg', 'Bài học không tồn tại');
    }
}
