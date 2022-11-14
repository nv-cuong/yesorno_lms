<div class="checkbox checkbox-success">
    <input type="checkbox" name="acl_all" value="ok" class="acl" id="acl-all"
            style="margin-left: 0;" {{ old('acl_all') ? 'checked' : ''}}>
    <label for="acl-all">Checked All</label>
</div>

<table class="table table-bordered table-hover table-striped table-condensed" id="acl-table" cellspacing="0"
        width="100%">
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

    <!-- User -->
    <tr>
        <td>User</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="user_create" {{ old('user_create') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="user_edit" {{ old('user_edit') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="user_view" {{ old('user_view') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="user_destroy" {{ old('user_destroy') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td>
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" id="user_status" class="styled acl"
                        name="user_status" {{ old('user_status') ? 'checked' : ''}}>
                <label for="user_status">Status</label>
            </div>
        </td>
    </tr>

    <!-- Roles -->
    <tr>
        <td>Role</td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="role_create" {{ old('role_create') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="role_edit" {{ old('role_edit') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="role_view" {{ old('role_view') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="role_destroy" {{ old('role_destroy') ? 'checked' : ''}}>
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
                        name="course_create" {{ old('course_create') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="course_edit" {{ old('course_edit') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="course_view" {{ old('course_view') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="course_destroy" {{ old('course_destroy') ? 'checked' : ''}}>
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
                        name="class_create" {{ old('class_create') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="class_edit" {{ old('class_edit') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="class_view" {{ old('class_view') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="class_destroy" {{ old('class_destroy') ? 'checked' : ''}}>
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
                        name="student_create" {{ old('student_create') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="student_edit" {{ old('student_edit') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="student_view" {{ old('student_view') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="student_destroy" {{ old('student_destroy') ? 'checked' : ''}}>
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
                        name="test_create" {{ old('test_create') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="test_edit" {{ old('test_edit') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="test_view" {{ old('test_view') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="test_destroy" {{ old('test_destroy') ? 'checked' : ''}}>
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
                        name="question_create" {{ old('question_create') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="question_edit" {{ old('question_edit') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="question_view" {{ old('question_view') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="question_destroy" {{ old('question_destroy') ? 'checked' : ''}}>
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
                        name="score_create" {{ old('score_create') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="score_point" {{ old('score_point') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        <td class="text-center">
            <div class="checkbox checkbox-success">
                <input type="checkbox" value="ok" class="styled acl"
                        name="score_view" {{ old('score_view') ? 'checked' : ''}}>
                <label></label>
            </div>
        </td>
        
        <td>&nbsp;</td>
    </tr>


    </tbody>
</table>
