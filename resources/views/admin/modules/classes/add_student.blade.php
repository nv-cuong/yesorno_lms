@extends('admin.layouts.master')
@section('title', 'Quản lí lớp học')

@section('content')
<br>
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
                            <table class="table table-striped" id="example1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ</th>
                                        <th>Tên</th>
                                        <th>E-mail</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th>-</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stds as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->last_name }}</td>
                                        <td>{{ $item->first_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->birthday }}</td>
                                        <td>{{ __('userlabel.' . $item->gender) }}</td>
                                        <td>
                                            <input class="form-check-input" type="checkbox" id="student" 
                                                name="std_id[]" value="{{ $item->id }}" 
                                                @foreach ($std as $item2) 
                                                @if ($item->id == $item2->id) checked @endif @endforeach>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">Chưa có sinh viên</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Thêm</button>
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