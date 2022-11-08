<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassStudy;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\File;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class StudentCoursesController extends Controller
{
    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function personalCourse(Request $request, $slug)
    {
        $getUser = Sentinel::getUser();
        $id = $getUser->id;
        $course = Course::where('slug', $slug)->with(['classStudies', 'units' => function ($q) {
            return $q->withCount('lessons');
        }])->first();
        $courseLesson = 0;
        foreach ($course->units as $unit) {
            $courseLesson += $unit->lessons_count;
        }
        $access = $course->users()->where('user_id', $id)->first()->pivot;
        $courses = Course::inRandomOrder()
            ->paginate(3)
            ->onEachSide(1);

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

        if ($countLesson != 0) {
            $progress = ceil(($countLesson * 100) / $courseLesson);
        } else $progress = 0;

        return view(
            'client.modules.personal_course_detail',
            compact('course', 'courses', 'access', 'courseLesson', 'countLesson', 'lessons', 'progress')
        );
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function personalLesson(Request $request, $slug)
    {
        $getUser = Sentinel::getUser();
        $lesson = Lesson::where('slug', $slug)->first();
        $user_lesson = $getUser->lessons()->where('lesson_id', $lesson->id)->first()->pivot;
        $nextLesson = Lesson::where('id', '>', $lesson->id)->where('unit_id', $lesson->unit_id)->first();
        $files = File::all()
            ->where('lesson_id', $lesson->id);
        return view('client.modules.lesson', compact('lesson', 'nextLesson', 'files', 'user_lesson'));
    }

    /**
     * @param string $slug
     */
    public function lessonProgress($slug)
    {
        $getUser = Sentinel::getUser();
        $lesson = Lesson::where('slug', $slug)->first();
        $getUser->lessons()->updateExistingPivot($lesson->id, [
            'status' => 1,
        ]);
    }
}
