@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
            @include('Admin/_alert')
            </div><!-- /.col -->
            
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
        <div class="container-fluid">
        <h3 class="box-title">Quản lý user</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{route('users.create')}}" class="btn btn-success float-right">+ Tạo user</a>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed" id="users-table" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('auth.index_fname_th')</th>
                                    <th>@lang('auth.index_lname_th')</th>
                                    <th>@lang('auth.index_email_th')</th>
                                    <th>@lang('auth.index_roles')</th>
                                    <th>@lang('auth.index_last_login')</th>
                                    <th>@lang('auth.index_status_th')</th>
                                    
                                    <th>action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() -1) * $users->perPage() }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                    @if ($user->roles->isNotEmpty())
                                    {{ implode(', ', collect($user->roles)->pluck('name')->all()) }}
                                    @endif
                                    </td>
                                    <td>{{ $user->last_login }}</td>
                                    <td>
                                      @if ($user->activations->isNotEmpty())
                                            @if ($user->activations[0]->completed == 1)
                                                <a href="#" data-message="{{ __('auth.deactivate_subheading', ['name' => $user->email]) }}"
                                                data-href="{{ route('users.status', $user->id) }}" id="tooltip"
                                                data-method="PUT" data-title="{{ __('auth.deactivate_this_user') }}"
                                                data-title-modal="{{ __('auth.deactivate_heading') }}"
                                                data-toggle="modal" data-target="#delete" title="{{ __('auth.deactivate_this_user') }}">
                                                <span class="label label-success label-sm">{{ __('auth.index_active_link') }}</span></a>
                                            @endif
                                      @else
                                          <a href="#" data-message="{{ __('auth.activate_subheading', ['name' => $user->email]) }}"
                                          data-href="{{ route('users.status', $user->id) }}"
                                          id="tooltip" data-method="PUT" data-title="{{ __('auth.activate_this_user') }}"
                                          data-title-modal="{{ __('auth.deactivate_heading') }}"
                                          data-toggle="modal" data-target="#delete" title="{{ __('auth.activate_this_user') }}">
                                          <span class="label label-danger label-sm">{{ __('auth.index_inactive_link') }}</span></a>
                                      @endif
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        @if($user->roles[0]->name != "Admin")
                                        <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModalUser" onclick="javascript:user_delete('{{ $user->id }}')"><i class="fas fa-backspace"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>

                        
                    </div>
                </div>
            </div>
    </section>
@stop
@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModalUser" tabindex="-1" aria-labelledby="deleteModalUser" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Xóa user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('users.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="user_id" id="user_id" value="0">
      <div class="modal-body">
       Bạn có muốn xóa không ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
        <button type="submit" class="btn btn-primary">Có</button>
      </div>
      </form>
    </div>
  </div>
</div>

 
@stop
@section('scripts')

  <script>
    $(function () {
    $("#users-table").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "oLanguage": {
               "sInfo" : "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ user",// text you want show for info section
               "sSearch":"Tìm kiếm",
               "oPaginate":{
                "sPrevious":"Trước",
                "sNext":"Tiếp",
               }
            },
    }).buttons().container().appendTo('#users-table_wrapper .col-md-6:eq(0)');
  });
  function user_delete (id)
  {
      var user_id = document.getElementById('user_id');
      user_id.value = id;
  }
  
</script>
@stop
