<a href="{{ route('roles.edit', [$row->id]) }}" class="btn btn-sm btn-success" title="Sửa Role">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-sm btn-primary" href="{{ route('roles.duplicate', [$row->id]) }}" title="Duplicate">
    <i class="fas fa-calendar-plus"></i></a>
<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModalRole"
    onclick="javascript:role_delete('{{ $row->id }}')" title="Xóa Role"><i class="far fa-trash-alt"></i></a>
