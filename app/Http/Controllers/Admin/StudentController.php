<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\ClassStudy;

class StudentController extends Controller
{
    public function index(){
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
        ->paginate();
        return view('admin.students.index', compact('students'));
    }
    public function edit(Request $request, $id)
    {
        $student = User::find($id);
        $classes = User::find($id)->classStudies()->where("user_id",$id)->get();
        if ($student) {

            return view('admin.students.edit', compact('student','classes'));
        }

        return redirect(route('students'))
        ->with('msg', 'Học sinh chưa tồn tại!');
    }

    public function update(Request $request, $id)
    {
        $msg = 'Học sinh chưa tồn tại!';
        $student = User::find($id);
        if ($student) {
            $student->phone= $request->input('phone');
            $student->first_name = $request->input('first_name');
            $student->gender = $request->input('gender');
            $student->last_name = $request->input('last_name');
            $student->age = $request->input('age');
            $student->birthday = $request->input('birthday');
            $student->save();
            $msg = 'Thay đổi thành công!';
        }
        return redirect(route('students'))
        ->with('msg', $msg);
    }

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

    public function showClass(Request $request, $id)
    {
        $student = User::find($id);
        $classes = User::find($id)->classStudies()->where("user_id",$id)->get();
        if ($student) {
            return view('admin.students.class', compact('student','classes'));
        }
        return redirect(route('students'))
        ->with('msg', 'Học sinh chưa tồn tại!');
    }
}
