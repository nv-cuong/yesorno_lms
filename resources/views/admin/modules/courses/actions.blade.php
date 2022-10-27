<a href="{{ route('course.detail', [$row->id]) }}" class="btn btn-primary" title="Thông tin khóa học">
    <i class="far fa-eye"></i>
</a>
<a href="{{ route('course.edit', [$row->id]) }}" class="btn btn-success" title="Sửa thông tin khóa học">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-danger" title="Xóa khóa học" data-toggle="modal" data-target="#deleteModal"
    onclick="javascript:course_delete('{{ $row->id }}')">
    <i class="far fa-trash-alt"></i>
</a>
<a href="{{ route('course.test', [$row->id]) }}" class="btn btn-warning" title="Bài test trong khóa học">
    Test
</a>
<a href="{{ route('course.student', [$row->id]) }}" class="btn btn-success" title="Học viên trong khóa học">
    Học viên
</a>
@if ($row->users_count > 0)
    <button class='btn btn-danger' title="Số lượng học viên trong khóa học">
        {{ $row->users_count }}
    </button>
@endif
