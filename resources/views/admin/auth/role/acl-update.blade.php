@php
$permissions = $role->permissions;
@endphp
<div class="checkbox checkbox-success">
    <input type="checkbox" name="acl_all" value="ok" class="acl" id="acl-all"
            style="margin-left: 0;" {{ old('acl_all') || array_key_exists('acl.all', $permissions) ? 'checked' : ''}}>
    <label for="acl-all">Checked All</label>
</div>

<table class="table table-bordered table-hover table-striped table-condensed" id="acl-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th class="text-center" style="vertical-align: middle">Name</th>
        <th class="text-center" width="80">Create</th>
        <th class="text-center" width="80">Update</th>
        <th class="text-center" width="80">View</th>
        <th class="text-center" width="80" style="color: red">Delete</th>
        <th class="text-center"></th>
    </tr>
    </thead>

    <tbody>
    <!-- Users -->
    <tr>
        <td>User</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl" name="user_create" {{ old('user_create') || array_key_exists('user.create', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl" name="user_update" {{ old('user_update') || array_key_exists('user.update', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl" name="user_view" {{ old('user_view') || array_key_exists('user.view', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl" name="user_delete" {{ old('user_delete') || array_key_exists('user.delete', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td>
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" id="user_status" class="styled acl" name="user_status" {{ old('user_status') || array_key_exists('user.status', $permissions) ? 'checked' : ''}}>
                <label for="user_status">Status</label>
            </div>
        </td>
    </tr>

    <!-- Roles -->
    <tr>
        <td>Role</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl" name="role_create" {{ old('role_create') || array_key_exists('role.create', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl" name="role_update" {{ old('role_update') || array_key_exists('role.update', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl" name="role_view" {{ old('role_view') || array_key_exists('role.view', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl" name="role_delete" {{ old('role_delete') || array_key_exists('role.delete', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <!-- course -->
    <tr>
        <td>Khóa học</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="course_create" {{ old('course_create') || array_key_exists('course.create', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="course_update" {{ old('course_update') || array_key_exists('course.update', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="course_view" {{ old('course_view') || array_key_exists('course.view', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="course_delete" {{ old('course_delete') || array_key_exists('course.delete', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <!-- class -->
    <tr>
        <td>Lớp học</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="class_create" {{ old('class_create') || array_key_exists('class.create', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="class_update" {{ old('class_update') || array_key_exists('class.update', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="class_view" {{ old('class_view') || array_key_exists('class.view', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="class_delete" {{ old('class_delete') || array_key_exists('class.delete', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <!-- student -->
    <tr>
        <td>Học viên</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="student_create" {{ old('student_create') || array_key_exists('student.create', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="student_update" {{ old('student_update') || array_key_exists('student.update', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="student_view" {{ old('student_view') || array_key_exists('student.view', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="student_delete" {{ old('student_delete') || array_key_exists('student.delete', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <!-- Test -->
    <tr>
        <td>Bài Test</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="test_create" {{ old('test_create') || array_key_exists('test.create', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="test_update" {{ old('test_update') || array_key_exists('test.update', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="test_view" {{ old('test_view') || array_key_exists('test.view', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="test_delete" {{ old('test_delete') || array_key_exists('test.delete', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>

    <!-- question -->
    <tr>
        <td>Câu hỏi</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="question_create" {{ old('question_create') || array_key_exists('question.create', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="question_update" {{ old('question_update') || array_key_exists('question.update', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="question_view" {{ old('question_view') || array_key_exists('question.view', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="question_delete" {{ old('question_delete') || array_key_exists('question.delete', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <!-- score -->
    <tr>
        <td>Quản lý điểm</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="score_create" {{ old('score_create') || array_key_exists('score.create', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="score_update" {{ old('score_update') || array_key_exists('score.update', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="score_view" {{ old('score_view') || array_key_exists('score.view', $permissions) ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>

        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>
