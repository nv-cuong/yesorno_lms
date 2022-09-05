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
            <!-- /.card-header -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin/_alert')
                            <div class="card">
                                <table class="table table-striped" id="example1">
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
                                        @forelse($students as $student)
                                        <tr>
                                            <td class="text-center col-1"> {{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                            <td class="text-center col-2">{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td class="text-center col-2">{{ $student->phone }}</td>
                                            <td class="text-center col-3">{{ $student->address }}</td>
                                            <td class="text-center col-2">{{ $student->birthday }}</td>
                                            <td class="text-center col-2">
                                                <a href="{{ route('student.statistic', [$student->id]) }}" class="btn btn-sm btn-primary mb-1">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="{{ route('student.edit', [$student->id]) }}" class="btn btn-sm btn-primary mb-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger mb-1" data-toggle="modal" data-target="#deleteModalStudent" onclick="javascript:student_delete({{ $student->id }})">
                                                    <i class="far fa-trash-alt"></i></a>
                                                <a href="{{ route('student.course', [$student->id]) }}" class="btn btn-sm btn-warning mb-1">
                                                    Khóa
                                                </a>
                                                <a href="{{ route('student.class', [$student->id]) }}" class="btn btn-sm btn-success mb-1">
                                                    Lớp
                                                </a>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="col-6">Không có học viên nào</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="card-footer clearfix">
                                    {!! $students->appends(Request::all())->links() !!}
                                </div>
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
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "oLanguage": {
               "sInfo" : "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ học viên",// text you want show for info section
               "sSearch":"Tìm kiếm",
               "oPaginate":{
                "sPrevious":"Trước",
                "sNext":"Tiếp",
               }
            },
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    function student_delete(id) {
        var student_id = document.getElementById('student_id');
        student_id.value = id;
    }
</script>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModalStudent" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
