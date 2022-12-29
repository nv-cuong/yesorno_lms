@extends('admin.layouts.master')
@section('title', 'Quản lí lớp học')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách lớp học</h1>
                </div>
            </div>
            @include('admin._alert')
            <hr>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('class.create') }}" class="btn btn-success float-right"
                                title="Thêm một lớp học mới">Tạo lớp học mới</a>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-condensed" id="class">
                            <thead>
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>Tên lớp</th>
                                    <th>Khóa học</th>
                                    <th>Học viên</th>
                                    <th>Bắt đầu</th>
                                    <th>Kết thúc</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 15%;">Tùy chọn</th>
                                </tr>
                            </thead>
                            <tbody id="load">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function() {
            var table = $('#class').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '/admin/class/data',
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'course',
                        name: 'course'
                    },
                    {
                        data: 'users_count',
                        name: 'users_count',
                        searchable: false
                    },
                    {
                        data: 'begin_date',
                        name: 'begin_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'schedule',
                        name: 'schedule',
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

        function class_delete(id) {
            var class_id = document.getElementById('class_id');
            class_id.value = id;
        }
    </script>
@endsection

@section('modal')
    <div class="modal fade show" id="modal-sm" style="display: hidden; padding-right: 12px;" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: red">Xóa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('class.delete') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="class_id" id="class_id" value="0">
                    <div class="modal-body">
                        <p>Bạn chắc chắn xóa lớp học này ?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
