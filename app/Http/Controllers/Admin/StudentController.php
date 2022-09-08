<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentRequest;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\ClassStudy;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $students = User::select([
            'users.id',
            'phone',
            'birthday',
            'address',
            'age',
            'gender',
            'first_name',
            'last_name'
        ])
            ->leftJoin('role_users AS ru', 'user_id', 'users.id')
            ->where('ru.role_id', 5)
            ->with('roles', 'activations')
            ->orderBy('users.id', 'asc')
            ->search()
            ->paginate(1000);
        return view('admin.students.index', compact('students'));
    }
    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function edit(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $classes = User::find($id)->classStudies()->where("user_id", $id)->get();
            return view('admin.students.edit', compact('student', 'classes'));
        }

        return redirect(route('students'))
            ->with('msg', 'Học sinh chưa tồn tại!');
    }

    /**
     * @param StudentRequest $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(StudentRequest $request, $id)
    {
        $msg = 'Học sinh chưa tồn tại!';
        $student = User::find($id);
        if ($student) {
            $student->phone = $request->input('phone');
            $student->first_name = $request->input('first_name');
            $student->gender = $request->input('gender');
            $student->last_name = $request->input('last_name');
            $student->birthday = $request->input('birthday');
            $student->age = \Carbon\Carbon::parse($request->input('birthday'))->age;
            $student->save();
            $msg = 'Thay đổi thành công!';
        }
        return redirect(route('students'))
            ->with('msg', $msg);
    }

    /**
     * @param Request $request
     * @throws ModelNotFoundException
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $student_id = $request->input('student_id', 0);
        if ($student_id) {
            User::destroy($student_id);
            return redirect(route('students'))
                ->with('msg', "Xóa sinh viên {$student_id} thành công!");
        } else {
            throw new ModelNotFoundException();
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function showClass(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $classes = User::find($id)->classStudies()->where("user_id", $id)->get();
            return view('admin.students.class', compact('student', 'classes'));
        }
        return redirect(route('students'))
            ->with('msg', 'Học sinh chưa tồn tại!');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function showCourse(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $courses = Course::select([
                'courses.id',
                'uc.user_id',
                'courses.slug',
                'title',
            ])
                ->leftJoin('user_courses AS uc', 'uc.course_id', 'courses.id')
                ->where('uc.user_id', $id)
                ->get();

            $lessons = Lesson::select([
                'lessons.id',
                'ul.user_id',
                'title',
                'unit_id',
                'status',
            ])
                ->leftJoin('user_lessons AS ul', 'ul.lesson_id', 'lessons.id')
                ->where('ul.user_id', $id)
                ->get();
            return view('admin.students.course', compact('student', 'courses', 'lessons'));
        }
        return redirect(route('students'))
            ->with('msg', 'Học sinh chưa tồn tại!');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|unknown
     */
    public function showStatistic(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            $classStudiesNumber = User::find($id)->classStudies()->where("user_id", $id)->count();
            $courseLesson = Lesson::select()
                ->leftJoin('units AS u', 'u.id', 'lessons.unit_id')
                ->join('courses AS c', 'c.id', 'u.course_id')
                ->where('c.status', 1)
                ->count();
            $lessonNumber = Lesson::select()
                ->leftJoin('user_lessons AS ul', 'ul.lesson_id', 'lessons.id')
                ->where('ul.user_id', $id)
                ->where('status', 1)
                ->count();
            if ($courseLesson != 0) {
                $coursesNumber = ceil(($lessonNumber * 100) / $courseLesson);
            } else $coursesNumber = 0;
            return view('admin.students.statistic', compact('student', 'coursesNumber', 'classStudiesNumber'));
        }
        return redirect(route('students'))
            ->with('msg', 'Học sinh chưa tồn tại!');
    }
}
