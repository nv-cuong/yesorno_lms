<a href="{{ route('student.statistic', [$row->id]) }}"
        class="btn btn-sm btn-info mb-1" title="Thông tin">
        <i class="far fa-eye"></i>
</a>
<a href="{{ route('student.edit', [$row->id]) }}"
    class="btn btn-sm btn-primary mb-1" title="Sửa">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-sm btn-danger mb-1" data-toggle="modal"
    data-target="#deleteModalStudent"
    onclick="javascript:student_delete({{ $row->id }})"
    title="Xóa">
        <i class="far fa-trash-alt"></i></a><br>
<a href="{{ route('student.course', [$row->id]) }}"
    class="btn btn-sm btn-warning mb-1" title="Khóa học">
    Khóa học
</a>
<a href="{{ route('student.class', [$row->id]) }}"
    class="btn btn-sm btn-success mb-1" title="Lớp học">
    Lớp học
</a>

