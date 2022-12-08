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
use Yajra\DataTables\Facades\DataTables;

class LessonController extends Controller
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showLesson($id)
    {
        $lesson = Lesson::find($id);
        if ($lesson){
            $files = $lesson->files()->get();
            return view(
                'admin.modules.courses.units.lessons.detail',
                compact('lesson', 'files'));
        }

        return abort(404);
    }

    /**
     *
     * @param integer $id
     * @return DataTables
     */
    public function getLessonData($id)
    {
        $lessons = Lesson::select([
            'id',
            'title',
            'content',
        ])->where('unit_id', $id);
        // @phpstan-ignore-next-line
        return DataTables::of($lessons)
            ->addColumn('actions', function ($lesson) {
                return view('admin.modules.courses.units.actions', ['row' => $lesson])->render();
            })
            ->editColumn('content', function ($lesson) {
                $tmp = <<<EOD
                    $lesson->content
                EOD;
                return $tmp;
            })
            ->rawColumns(['actions', 'content'])
            ->make(true);
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
                'published' => $lesson_item['published'],
                'content' => $lesson_item['content'],
            ]);
            if ($request->input('path_link'))
                $this->saveDocument($request, $lesson, 'path_link');
            if ($request->input('path_zip'))
                $this->saveDocument($request, $lesson, 'path_zip');
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function editLesson(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        if ($lesson) {
            $unit = Unit::pluck('title', 'id');
            $files = $lesson->files()->get();
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

            $hasFiles = $lesson->files()->exists();

            if ($hasFiles) {
                $files = $lesson->files()->get();

                foreach ($files as $file) {
                    if ($file->type == 'link') {
                        $file->path = $request->input('path_link');
                        $file->save();
                    }
                }
            } else {
                $this->saveDocument($request, $lesson, 'path_link');
            }
            if ($request->file('path_zip') != null) {
                $this->saveDocument($request, $lesson, 'path_zip');
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
        $lesson_id = 0 + $request->input('lesson_id', 0);
        $msg = 'Bài học không tồn tại';
        $type = 'danger';
        if ($lesson_id > 0) {
            Lesson::destroy($lesson_id);
            $msg = 'Bài học đã được xóa';
            $type = 'success';
        }
        return redirect(route('unit.detail', [$unit_id]))
            ->with('message', $msg)
            ->with('type_alert', $type);
    }

    /**
     * @param int $id
     * @throws ModelNotFoundException
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadFile($id)
    {
        $file = File::find($id);
        $name = 'baihoc' . $id . '.zip';
        if ($file && $file->path) {
            return Storage::download($file->path, $name);
        }
        throw new ModelNotFoundException();
    }

    /**
     * @param LessonRequest $request
     * @param Lesson $lesson
     * @param string $docType
     * @return boolean
     */
    private static function saveDocument(LessonRequest $request, Lesson $lesson, $docType)
    {
        $lesson_item = $request->except('_token');
        $type = '';
        $path = '';

        if ($docType == 'path_link') {
            $type = 'link';
            $path = $lesson_item[$docType];
        } elseif($request->hasFile($docType)) {
            $file = $request->file($docType);
            $type = $file->extension();
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('files', $fileName);
        }

        File::create([
            'lesson_id' => $lesson->id,
            'type' => $type,
            'path' => $path,
        ]);

        return true;
    }
}
