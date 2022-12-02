@extends('admin.layouts.master')
@section('title', 'Giảng viên')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h2>Danh sách giảng viên</h2>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header">
                                <a href="{{ route('teacher.create') }}" class="btn btn-success float-right">+ Thêm mới giảng
                                    viên</a>
                            </div>
                            @include('admin/_alert')
                            <div class="card">
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                    id="teachers">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã giảng viên</th>
                                            <th class="text-center">Họ tên giảng viên</th>
                                            <th class="text-center">Số điện thoại</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Giới tính</th>
                                            <th class="text-center" style="width: 20%;">Tùy chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody id="load">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        var table = $('#teachers').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [1, 'asc']
            ],
            ajax: '/admin/teachers/data',
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
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'gender',
                    name: 'gender'
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

    function teacher_delete(id) {
        var teacher_id = document.getElementById('teacher_id');
        teacher_id.value = id;
    }
</script>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModalStudent" data-bs-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xóa học viên!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('teacher.delete') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="teacher_id" id="teacher_id" value="0">
                <div class="modal-body">
                    Bạn có chắc là muốn xóa học viên này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                    <button type="submit" class="btn btn-danger">Có</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
