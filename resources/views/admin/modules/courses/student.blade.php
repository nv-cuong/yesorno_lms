@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Quản lý học viên trong khóa học
                    </h1>
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
                        <table class="table table-striped table-bordered table-hover table-condensed" id="student-of-course">
                            <thead>
                                <tr>
                                    <th>
                                        STT
                                    </th>
                                    <th>
                                        Mã học viên
                                    </th>
                                    <th>
                                        Tên học viên
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Trạng thái
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
    <div class="modal fade show" id="activeModal" style="display: hidden; padding-right: 12px;" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activeModalLabel">Chấp nhận học viên!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="{{ route('course.active', $course->id) }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="0">
                    <div class="modal-body">
                        <p>Bạn có đồng ý thêm học viên vào khóa học?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Đồng ý</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function() {
            var table = $('#student-of-course').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '{{ route('course.dataStudent', $course->id) }}',
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
                        data: 'status',
                        name: 'status'
                    },
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
    </script>

    <script>
        function user_active(id) {
            var user_id = document.getElementById('user_id');
            user_id.value = id;
        }
    </script>
@endsection
