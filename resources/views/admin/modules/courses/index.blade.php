@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý khóa học</h1>
                </div>
            </div>
            @include('admin/_alert')
            <hr>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('course.create') }}" class="btn btn-success float-right">
                                Tạo khóa học mới
                            </a>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-condensed" id="course">
                            <thead>
                                <tr>
                                    <th>
                                        STT
                                    </th>
                                    <th>
                                        Tên khóa học
                                    </th>
                                    <th>
                                        Giảng viên
                                    </th>
                                    <th>
                                        Loại
                                    </th>
                                    <th>
                                        Ngày bắt đầu
                                    </th>
                                    <th>
                                        Ngày kết thúc
                                    </th>
                                    <th style="width: 25%;">
                                        Tùy chọn
                                    </th>
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

@section('modal')
    <!-- Modal -->
    <div class="modal fade show" id="deleteModal" style="display: hidden; padding-right: 12px;" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xóa khóa học!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="{{ route('course.delete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="course_id" id="course_id" value="0">
                    <div class="modal-body">
                        <p>
                            Bạn có chắc muốn xóa khóa học này?
                        </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Đóng
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Đồng ý
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            var table = $('#course').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '/admin/courses/course/data',
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'teacher_id',
                        name: 'teacher_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
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

        function course_delete(id) {
            var course_id = document.getElementById('course_id');
            course_id.value = id;
        }
    </script>
@endsection
