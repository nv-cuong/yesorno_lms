<a href="{{ route('class.edit', [$row->id]) }}" class="btn btn-success btn-sm" title="Chỉnh sửa thông tin lớp học">
    <i class="fas fa-edit"></i>
</a>
<a href="{{ route('class.show', [$row->id]) }}" class="btn btn-info btn-sm" title="Xem chi tiết lớp học">
    <i class="far fa-eye"></i>
</a>
<a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-sm"
    onclick="javascript:class_delete({{ $row->id }})" title="Xóa lớp học">
    <i class="far fa-trash-alt"></i>
</a>
