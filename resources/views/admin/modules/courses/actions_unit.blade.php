<a href="{{ route('unit.detail', [$row->id]) }}" class="btn btn-info" title="Thông tin chương học">
    <i class="far fa-eye"></i>
</a>
<a href="{{ route('unit.edit', [$row->id]) }}" class="btn btn-success" title="Sửa thông tin chương học">
    <i class="fas fa-edit"></i>
</a>
<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
    onclick="javascript:unit_delete('{{ $row->id }}')" title="Xóa chương học">
    <i class="far fa-trash-alt"></i>
</button>
