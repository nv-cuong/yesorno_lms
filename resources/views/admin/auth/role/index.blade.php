@extends('admin.layouts.master')
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
                            <a href="{{ route('roles.create') }}" class="btn btn-success float-right">+ Tạo role</a>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed" id="roles-table"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên Role</th>
                                    <th>Slug</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Tùy chọn</th>
                                </tr>
                            </thead>
                            <tbody>

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
        $(function() {
            var table = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/admin/roles/data',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            table.on('draw', function() {
                $('.livicon').each(function() {
                    $(this).updateLivicon();
                });
            });
        });

        function role_delete(id) {
            var role_id = document.getElementById('role_id');
            role_id.value = id;
        }
    </script>
@stop
