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
                        <a href="{{ route('course.create') }}" class="btn btn-success float-right">+ Tạo khóa học mới</a>
                    </div>
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên khóa học</th>
                                <th>Loại</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody id="load">
                            @forelse($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration + ($courses->currentPage() -1) * $courses->perPage() }}</td>
                                <td>{{ $course->title }}</td>
                                @if($course->status == 0)
                                <td>Miễn phí</td>
                                @else
                                <td>Tính phí</td>
                                @endif
                                <td>{{ $course->begin_date }}</td>
                                <td>{{ $course->end_date }}</td>
                                <td>
                                    <a href="{{ route('course.detail', ['id'=>$course->id]) }}" class="btn btn-primary">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('course.edit', [$course->id]) }}" class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="javascript:course_delete('{{ $course->id }}')">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                    <a href="{{ route('course.test', [$course->id]) }}" class="btn btn-warning">
                                        Test
                                    </a>
                                    <a href="{{ route('course.student', [$course->id]) }}" class="btn btn-success">
                                        Học viên
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">Không có khóa học</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        {{-- {!! $courses->appends(Request::all())->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade show" id="deleteModal" style="display: hidden; padding-right: 12px;" aria-modal="true" role="dialog">
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
                    <p>Bạn có chắc muốn xóa khóa học này?</p>
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
    function course_delete(id) {
        var course_id = document.getElementById('course_id');
        course_id.value = id;
    }
</script>
@endsection