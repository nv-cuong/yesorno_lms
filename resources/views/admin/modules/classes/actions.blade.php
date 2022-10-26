<a href="{{ route('class.edit', $class->id) }}" class="btn btn-success"
    title="Chỉnh sửa thông tin lớp học">
    <i class="fas fa-edit"></i>
</a>
<a href="#" class="btn btn-danger" data-toggle="modal"
    data-target="#modal-sm"
    onclick="javascript:class_delete({{ $class->id }})" title="Xóa lớp học">
    <i class="far fa-trash-alt"></i>
</a>
<a href="{{ route('class.show', $class->slug) }}" class="btn btn-primary"
    title="Xem chi tiết lớp học">
    <i class="far fa-eye"></i>
</a>