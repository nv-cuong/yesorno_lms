<a href="{{ route('lesson.detail', [$row->id]) }}" class="btn btn-info" title="Thông tin bài học">
    <i class="far fa-eye"></i>
</a>
<a href="{{ route('lesson.edit', [$row->id]) }}" class="btn btn-success" title="Sửa thông tin bài học">
    <i class="fas fa-edit"></i>
</a>
<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
    onclick="javascript:lesson_delete('{{ $row->id }}')" title="Xóa bài học">
    <i class="far fa-trash-alt"></i>
</button>
