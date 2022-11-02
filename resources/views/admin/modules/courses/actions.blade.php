<a href="{{ route('course.detail', [$row->id]) }}" class="btn btn-info" title="Thông tin khóa học">
    <i class="far fa-eye"></i>
</a>
<a href="{{ route('course.edit', [$row->id]) }}" class="btn btn-success" title="Sửa thông tin khóa học">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-danger" title="Xóa khóa học" data-toggle="modal" data-target="#deleteModal"
    onclick="javascript:course_delete('{{ $row->id }}')">
    <i class="far fa-trash-alt"></i>
</a>
<a href="{{ route('course.test', [$row->id]) }}" class="btn btn-primary" title="Bài test trong khóa học">
    <i class="far fa-file-alt"></i>
</a>
<a href="{{ route('course.student', [$row->id]) }}" class="btn"
    style="background-color: rgb(155, 42, 155);  color: white;" title="Học viên trong khóa học">
    <i class="fas fa-users"></i>
</a>
@if ($row->users_count > 0)
    <button class='btn' style="background-color: orange; color: white;" title="Học viên đang chờ phê duyệt">
        {{ $row->users_count }}
    </button>
@endif
