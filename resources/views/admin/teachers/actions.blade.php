<a href="{{ route('teacher.detail', [$row->id]) }}" class="btn btn-sm btn-info mb-1" title="Thông tin giảng viên">
    <i class="far fa-eye"></i>
</a>
<a href="{{ route('teacher.edit', [$row->id]) }}" class="btn btn-sm btn-success mb-1" title="Sửa thông tin">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-sm btn-danger mb-1" data-toggle="modal" data-target="#deleteModalStudent"
    onclick="javascript:teacher_delete({{ $row->id }})" title="Xóa giảng viên">
    <i class="far fa-trash-alt"></i>
</a>
<a href="{{ route('teacher.course', [$row->id]) }}"
    class="btn btn-sm btn-primary mb-1" title="Khóa học của giảng viên">
    <i class="fas fa-book"></i>
</a>