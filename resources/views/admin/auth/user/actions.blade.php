@php
$user = Sentinel::getUser();
@endphp

@if($user->hasAccess('user.update'))
<a href="{{ route('users.edit', [$row->id]) }}" class="btn btn-sm btn-success" title="Sửa thông tin user">
    <i class="fas fa-edit"></i>
</a>
@endif
@if($user->id != $row->id && $user->hasAccess('user.delete'))
<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModalUser"
    onclick="javascript:user_delete('{{ $row->id }}')" title="Xóa user">
    <i class="fas fa-backspace"></i>
</a>
@endif
