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
            <h3 class="box-title">Quản lý người dùng</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('users.create') }}" class="btn btn-success float-right">+ Tạo user</a>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed" id="users-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã người dùng</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>Role - chức năng</th>
                                    <th>Lần cuối đăng nhập</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%;">Tùy chọn</th>
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
    <div class="modal fade" id="deleteModalUser" tabindex="-1" aria-labelledby="deleteModalUser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa người dùng</h5>
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

    <script type="text/javascript">
        $(function() {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '/admin/users/data',
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'stu_id',
                        name: 'stu_id'
                    },
                    {
                        data: 'fullname',
                        name: 'fullname'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'last_login',
                        name: 'last_login'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
            table.on('order.dt search.dt', function() {
                let i = 1;
                table.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
        });

        function user_delete(id) {
            var user_id = document.getElementById('user_id');
            user_id.value = id;
        }
    </script>
@stop
