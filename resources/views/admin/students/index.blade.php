@extends('admin.layouts.master')
@section('title', 'Class Manager')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h2>Danh sách học viên</h2>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header">
                                <a href="{{ route('student.create') }}" class="btn btn-success float-right">+ Thêm học
                                    viên</a>
                            </div>
                            @include('admin/_alert')
                            <div class="card">
                                <table class="table table-striped" id="students">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Tên học viên</th>
                                            <th class="text-center">Số điện thoại</th>
                                            <th class="text-center">Địa chỉ</th>
                                            <th class="text-center">Ngày sinh</th>
                                            <th class="text-center">Tùy chọn</th>
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
    $(function () {
        var table = $('#students').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/students/data',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'fullname', name: 'fullname'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'birthday', name: 'birthday'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ]
        });
        table.on('draw', function () {
            $('.livicon').each(function () {
                $(this).updateLivicon();
            });
        });
    });

    function student_delete(id) {
        var student_id = document.getElementById('student_id');
        student_id.value = id;
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
            <form method="post" action="{{ route('student.delete') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="student_id" id="student_id" value="0">
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
