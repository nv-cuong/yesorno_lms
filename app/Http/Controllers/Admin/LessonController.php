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
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showLesson($id)
    {
        $lesson = Lesson::where('id', $id)
            ->first();
        $files = File::all()
            ->where('lesson_id', $lesson->id);
        return view('admin.modules.courses.units.lessons.detail', compact('lesson', 'files'));
    }

    /**
     * @param int $unit_id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createLesson($unit_id)
    {
        $lesson = new Lesson();
        $file = new File();
        $unit = Unit::where('id', $unit_id)
            ->pluck('title', 'id');
        return view('admin.modules.courses.units.lessons.create', compact('lesson', 'file', 'unit'));
    }

    /**
     * @param LessonRequest $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
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
                $path = Storage::putFile('files', $zip);
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
        ->with('message', 'Thêm bài học mới thành công')
        ->with('type_alert', "success");
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function editLesson(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        if ($lesson) {
            $unit = Unit::pluck('title', 'id');
            $files = File::all()
                ->where('lesson_id', $lesson->id);
            return view('admin.modules.courses.units.lessons.edit', compact('lesson', 'files', 'unit'));
        }
        return redirect(route('unit.detail', [$lesson->unit_id]))
            ->with('message', 'Bài học không tồn tại')
            ->with('type_alert', "danger");
    }

    /**
     * @param LessonRequest $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function updateLesson(LessonRequest $request, $id)
    {
        $message = 'Bài học không tồn tại';
        $type = 'danger';
        $lesson = Lesson::find($id);
        if ($lesson) {
            $lesson->title = $request->input('title');
            $lesson->unit_id = $request->input('unit_id');
            $lesson->slug = Str::slug($lesson->title);
            $lesson->content = $request->input('content');
            $lesson->published = $request->input('published');
            $lesson->save();

            $hasFiles = File::where('lesson_id', $lesson->id)->first();

            if ($hasFiles != null) {
                $files = File::all()->where('lesson_id', $lesson->id);

                foreach ($files as $file) {
                    if ($file->type == 'link') {
                        $file->path = $request->input('path_link');
                        $file->save();
                    }
                }
            } else {
                File::create([
                    'lesson_id' => $lesson->id,
                    'type' => 'link',
                    'path' => $request->input('path_link'),
                ]);
            }
            $zip = $request->file('path_zip');
            if ($zip) {
                $path = Storage::putFile('files', $zip);
                File::create([
                    'lesson_id' => $lesson->id,
                    'type' => 'zip',
                    'path' => $path
                ]);
            }
            $message = 'Cập nhật bài học thành công';
            $type = 'success';
        }

        return redirect(route('unit.detail', [$lesson->unit_id]))
        ->with('message', $message)
        ->with('type_alert', $type);
    }

    /**
     * @param Request $request
     * @param int $unit_id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroyLesson(Request $request, $unit_id)
    {
        $lesson_id = $request->input('lesson_id', 0);
        if ($lesson_id) {
            Lesson::destroy($lesson_id);
            return redirect(route('unit.detail', [$unit_id]))
            ->with('message', 'Bài học đã được xóa')
            ->with('type_alert', "success");
        } else
            return redirect(route('unit.detail', [$unit_id]))
            ->with('message', 'Bài học không tồn tại')
            ->with('type_alert', "danger");
    }

    /**
     * @param int $id
     * @throws ModelNotFoundException
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadFile($id) {
        $file = File::find($id);
        $name = 'baihoc'.$id.'.zip';
        if ($file){
            return Storage::download($file->path,$name);
        }
        throw new ModelNotFoundException();
    }
}
