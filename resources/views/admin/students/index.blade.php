@extends('admin.layouts.master')
@section('title', 'Class Manager')
@section('content')
@include('admin/_alert');
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Danh sách học viên</h2>
                <form action="">
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="key" class="form-control float-right" placeholder="Tìm kiếm...">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
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
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td> {{ $loop->iteration + ($students->currentPage() -1) * $students->perPage() }}</td>
                            <td class="text-center col-1">{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td class="text-center col-2">{{ $student->phone }}</td>
                            <td class="text-center col-5">{{ $student->address }}</td>
                            <td class="text-center col-2">{{ $student->birthday }}</td>
                            <td class="text-center col-2">
                                <a href="{{ route('student.statistic', [$student->id]) }}" class="btn btn-sm btn-primary mb-1">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('student.edit', [$student->id]) }}" class="btn btn-sm btn-primary mb-1">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="javascript:student_delete({{ $student->id }})">
                                    <i class="fa-solid fa-trash"></i></a>
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
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<div class="card-footer clearfix">
    <ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item"><a class="page-link" href="#">«</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">»</a></li>
    </ul>
</div>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xóa học viên!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('student.delete') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="student_id" id="student_id" value="0">
                <div class="modal-body">
                    Bạn có chắc là muốn xóa học viên này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                    <button type="submit" class="btn btn-danger">Có</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')

<script>
    function student_delete(id) {
        var student_id = document.getElementById('student_id');
        student_id.value = id;
    }
</script>
@stop