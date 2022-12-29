@extends('admin.layouts.master')
@section('title', 'Quản lí lớp học')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-weight:bold">Thêm học viên mới</h3>
                        </div>
                        <form action="{{ route('class.join', $class->id) }}" method="POST">
                            <div class="card-body">
                                @csrf
                                <table class="table table-striped table-bordered table-hover table-condensed text-center"
                                    id="example1">
                                    <thead>
                                        <tr>
                                            <th>Mã học viên</th>
                                            <th>Họ và tên</th>
                                            <th>E-mail</th>
                                            <th>Ngày sinh</th>
                                            <th>Giới tính</th>
                                            <th>Tùy chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($students as $item)
                                            <tr>
                                                <td>{{ $item->stu_id }}</td>
                                                <td>{{ $item->last_name }} {{ $item->first_name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->birthday }}</td>
                                                <td>
                                                    @if ($item->gender == 'male')
                                                        Nam
                                                    @elseif ($item->gender == 'female')
                                                        Nữ
                                                    @else
                                                        Khác
                                                    @endif
                                                </td>
                                                <td>
                                                    <input class="form-check-input" type="checkbox" id="student"
                                                        name="std_id[]" value="{{ $item->id }}"
                                                        @foreach ($students_in_class as $item2) 
                                                @if ($item->id == $item2->id) checked @endif @endforeach>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">Chưa có sinh viên được thêm vào khóa học</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary">Thêm học viên</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
