<a href="{{ route('student.statistic', [$row->id]) }}"
        class="btn btn-sm btn-info mb-1" title="Thông tin học viên">
        <i class="far fa-eye"></i>
</a>
<a href="{{ route('student.edit', [$row->id]) }}"
    class="btn btn-sm btn-success mb-1" title="Sửa thông tin">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-sm btn-danger mb-1" data-toggle="modal"
    data-target="#deleteModalStudent"
    onclick="javascript:student_delete({{ $row->id }})"
    title="Xóa học viên">
        <i class="far fa-trash-alt"></i></a>
<a href="{{ route('student.course', [$row->id]) }}"
    class="btn btn-sm btn-primary mb-1" title="Khóa học">
    <i class="fas fa-book"></i>
</a>
<a href="{{ route('student.class', [$row->id]) }}"
    class="btn btn-sm btn-success mb-1" style="background-color: rgb(158, 25, 158); color: white;" title="Lớp học">
    <i class="fas fa-house-user"></i>
</a>

