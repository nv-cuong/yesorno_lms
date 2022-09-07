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
                        <a href="{{ route('class.create') }}" class="btn btn-success float-right" title="Thêm một lớp học mới">Tạo lớp học mới</a>
                    </div>
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên lớp</th>
                                <th>Tên khóa học</th>
                                <th>Thời gian học</th>
                                <th>Học viên</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="load">
                            @forelse ($classes as $class)
                            <tr>
                                <td>
                                    {{ $loop->iteration + ($classes->currentPage() - 1) * $classes->perPage() }}
                                </td>
                                <td>{{ $class->name }}</td>
                                <td>
                                    @php
                                    $course = $class->courses()->get();
                                    @endphp
                                    @foreach ($course as $item)
                                    {{ $item->title }} <br>
                                    @endforeach
                                </td>
                                <td class="text">
                                    @if ($class->schedule == 0)
                                    Sáng
                                    @elseif ($class->schedule == 1)
                                    Chiều
                                    @else
                                    Cả ngày
                                    @endif
                                </td>
                                <td class="text-end">{{ $class->users->count() }}</td>
                                <td>
                                    <a href="{{ route('class.edit', $class->id) }}" class="btn btn-success" title="Chỉnh sửa thông tin lớp học">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modal-sm" onclick="javascript:class_delete({{ $class->id }})" title="Xóa lớp học">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                    <a href="{{ route('class.show', $class->slug) }}" class="btn btn-primary" title="Xem chi tiết lớp học">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">Không có dữ liệu</td>
                            </tr>
                            @endforelse
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
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    function class_delete(id) {
        var class_id = document.getElementById('class_id');
        class_id.value = id;
    }
</script>
@endsection
@section('scripts')
<script>
    $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  });
</script>
@endsection

@section('modal')
<div class="modal fade show" id="modal-sm" style="display: hidden; padding-right: 12px;" aria-modal="true" role="dialog">
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
