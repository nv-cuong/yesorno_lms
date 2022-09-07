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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{route('roles.create')}}" class="btn btn-success float-right">+ Tạo role</a>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed"
                                   id="roles-table" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('auth.index_name_th')</th>
                                    <th>@lang('auth.index_slug_th')</th>
                                    <th>@lang('auth.index_created_at')</th>
                                    <th>@lang('auth.index_updated_at')</th>
                                    <th>@lang('auth.index_action_th')</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @forelse($roles as $role)
                                    <tr>
                                      <td>
                                        {{ $loop->iteration + ($roles->currentPage() -1) * $roles->perPage() }}
                                      </td>
                                      <td>{{ $role->name }}</td>
                                      <td>{{ $role->slug }}</td>
                                      <td>{{ $role->created_at }}</td>
                                      <td>{{ $role->updated_at }}</td>
                                      <td style="white-space: nowrap;">
                                        <a href="{{ route('roles.edit', [$role->id]) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('roles.duplicate', $role->id) }}" title="Duplicate">
                                        <i class="fas fa-calendar-plus"></i>
                                        <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModalRole"
                                        onclick="javascript:role_delete('{{ $role->id }}')"><i class="fas fa-backspace"></i></a>
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
<div class="modal fade" id="deleteModalRole" tabindex="-1" aria-labelledby="deleteModalRole" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Xóa role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('roles.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="role_id" id="role_id" value="0">
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

  <script type="text/javascript">
    $(function () {
    $("#roles-table").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "oLanguage": {
               "sInfo" : "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ roles",// text you want show for info section
               "sSearch":"Tìm kiếm",
               "oPaginate":{
                "sPrevious":"Trước",
                "sNext":"Tiếp",
               }
            },
    }).buttons().container().appendTo('#roles-table_wrapper .col-md-6:eq(0)');
    
  });
  function role_delete (id)
  {
      var role_id = document.getElementById('role_id');
      role_id.value = id;
  }
  
</script>
@stop
