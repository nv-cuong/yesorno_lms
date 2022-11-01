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
        $course = Course::where('slug', $slug)->with(['units' => function ($q) {
            return $q->withCount('lessons');
        }])->first();
        $courseLesson = 0;
        foreach($course->units as $unit) {
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
            ->join('courses AS c', 'c.id', 'u.course_id')
            ->where('c.id', $course->id)
            ->where('ul.user_id', $id)
            ->get();
        $countLesson = $lessons->where('status', 1)->count();

        if($countLesson != 0){
            $progress = ceil(($countLesson*100)/$courseLesson);
        }
        else $progress = 0;

        return view('client.modules.personal_course_detail', 
        compact('course', 'courses', 'access', 'courseLesson', 'countLesson', 'lessons', 'progress'));
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function personalLesson(Request $request, $slug)
    {
        $getUser = Sentinel::getUser();
        $id = $getUser->id;
        $lesson = Lesson::where('slug', $slug)->first();
        $nextLesson = Lesson::where('id', $lesson->id + 1)->first();
        $slCount = Lesson::select()
            ->leftJoin('user_lessons AS ul', 'ul.lesson_id', 'lessons.id')
            ->where('ul.user_id', $id)
            ->where('status', 1)
            ->count();
        $unitCount = Lesson::select()
            ->where('unit_id', $lesson->unit_id)
            ->count();
        $status = $slCount == $unitCount;
        $files = File::all()
            ->where('lesson_id', $lesson->id);
        return view('client.modules.lesson', compact('lesson', 'nextLesson', 'files', 'id', 'slug', 'status'));
    }

    /**
     * @param Request $request
     * @param string $slug
     */
    public function lessonProgress(Request $request, $slug)
    {
        $getUser = Sentinel::getUser();
        $lesson = Lesson::where('slug', $slug)->first();
        $getUser->lessons()->updateExistingPivot($lesson->id, [
            'status' => 1,
        ]);
    }
}
