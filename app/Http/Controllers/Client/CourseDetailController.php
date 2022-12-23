<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\File;
use App\Models\Lesson;
use App\Models\Unit;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class CourseDetailController extends Controller
{
    /**
     * @param string $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function courseDetail($slug)
    {
        $courses_slide = Course::select([
            'title',
            'slug',
            'image',
        ])->take(4)->get();

        $course = Course::where('slug', $slug)->with(['classStudies', 'users', 'units' => function ($q) {
            return $q->withCount('lessons');
        }])->first();

        $courseLesson = 0;
        foreach ($course->units as $unit) {
            $courseLesson += $unit->lessons_count;
        }

        $user = Sentinel::getUser();
        $id = $user->id;

        if ($course) {
            $units = Unit::where('course_id', $course->id)->get();
            $class_of_user = '';

            if ($user) {
                $access = $user->hasCourse($course->id);
                $class_of_user = ClassStudy::select(['class_studies.id'])
                    ->join('class_study_users AS cu', 'cu.class_study_id', 'class_studies.id')
                    ->join('class_study_courses as cc', 'cc.class_study_id', 'class_studies.id')
                    ->where('cu.user_id', $user->id)
                    ->where('cc.course_id', $course->id)
                    ->pluck('id')
                    ->toArray();
            }
            $lessons = Lesson::select([
                'ul.status',
                'unit_id',
                'lessons.title',
                'lessons.slug'
            ])
                ->leftJoin('user_lessons AS ul', 'ul.lesson_id', 'lessons.id')
                ->Join('units AS u', 'u.id', 'lessons.unit_id')
                ->where('u.course_id', $course->id)
                ->where('ul.user_id', $id)
                ->get();
            $countLesson = $lessons->where('status', 1)->count();
            $progress = 0;
            if ($countLesson != 0) {
                $progress = ceil(($countLesson * 100) / $courseLesson);
            }
            return view('client.modules.course_detail', compact(['courses_slide', 'course', 'units', 'user', 'access', 'class_of_user', 'progress', 'lessons', 'countLesson', 'courseLesson']));
        } else {
            return abort(404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function attach(Request $request)
    {
        if ($user = Sentinel::getUser()) {
            $user->courses()->attach($request->course_id);
            $user->lessons()->attach($request->lesson_id);
            return redirect(route('detail', $request->course_slug))
                ->with('message', "Đăng kí khóa học thành công. Hãy học ngay !")
                ->with('type_alert', "success");
        } else {
            return redirect(route('detail', $request->course_slug))
                ->with('message', "Không thể đăng kí. Hãy đăng nhập !")
                ->with('type_alert', "success");
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function detach(Request $request)
    {
        $user = Sentinel::getUser();
        $user->courses()->detach($request->course_id);
        $lessons = Lesson::leftJoin('user_lessons AS ul', 'ul.lesson_id', 'lessons.id')
            ->leftJoin('units AS u', 'u.id', 'lessons.unit_id')
            ->join('courses AS c', 'c.id', 'u.course_id')
            ->where('ul.user_id', $user->id)
            ->where('c.id', $request->course_id)
            ->pluck('ul.lesson_id')->all();

        $user->lessons()->detach($lessons);

        return redirect(route('detail', $request->course_slug))
            ->with('message', "Bạn đã hủy đăng kí khóa học này !")
            ->with('type_alert', "success");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function attachClass(Request $request)
    {
        $user = Sentinel::getUser();
        $class = ClassStudy::where('id', $request->class_id)->first();
        $class->users()->attach($user->id);
        return redirect(route('detail', $request->course_slug))
            ->with('message', "Bạn đã đăng kí lớp thành công !")
            ->with('type_alert', "success");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function detachClass(Request $request)
    {
        $user = Sentinel::getUser();
        $class = ClassStudy::where('id', $request->class_id)->first();
        $class->users()->detach($user->id);
        return redirect(route('detail', $request->course_slug))
            ->with('message', "Bạn đã hủy đăng kí lớp thành công !")
            ->with('type_alert', "success");
    }

    /**
     * showLesson
     *
     * @param  mixed $id
     * @return \Illuminate\View\View
     */
    public function showLesson($id)
    {
        $lesson = Lesson::find($id);

        if ($lesson) {
            $courseId = $lesson->unit->course_id;
            $course = Course::find($courseId);
            $nextLesson = Lesson::where('id', '>', $lesson->id)
                ->where('unit_id', $lesson->unit_id)
                ->first();
            $nextUnit = Unit::where('id', '>', $lesson->unit_id)
                ->where('course_id', $courseId)
                ->with('lessons')
                ->first();
            $files = File::where('lesson_id', $id)->get();
            return view('client.modules.learning', compact('lesson', 'files', 'course', 'nextLesson', 'nextUnit'));
        } else {
            return abort(404);
        }
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function personalLesson(Request $request, $slug)
    {
        $getUser = Sentinel::getUser();
        $lesson = Lesson::where('slug', $slug)
            ->with('unit')
            ->first();

        $userLesson = $getUser->lessons()
            ->where('lesson_id', $lesson->id)
            ->first()
            ->pivot;

        $courseId = $lesson->unit->course_id;
        $course = Course::find($courseId);
        $nextLesson = Lesson::where('id', '>', $lesson->id)
            ->where('unit_id', $lesson->unit_id)
            ->first();
        $nextUnit = Unit::where('id', '>', $lesson->unit_id)
            ->where('course_id', $courseId)
            ->with('lessons')
            ->first();
        $files = File::where('lesson_id', $lesson->id)
            ->get();

        return view('client.modules.lesson', compact('lesson', 'nextLesson', 'nextUnit', 'files', 'userLesson', 'course'));
    }

    /**
     * @param string $slug
     * @return NULL
     */
    public function lessonProgress($slug)
    {
        $getUser    = Sentinel::getUser();
        $lesson     = Lesson::where('slug', $slug)->first();
        $getUser->lessons()
            ->updateExistingPivot($lesson->id, [
                'status' => 1,
            ]);
    }
}
