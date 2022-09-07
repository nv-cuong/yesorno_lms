@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản lí khóa học</h1>
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
                @if ($course)
                <h2>{{ $course->title }}</h2>
                <div class="mb-3">
                    <img src="{{ asset($course->image) }}" class="img-thumbnail">
                </div>
                <h4>Mô tả khóa học</h4>
                <div class="table-responsive">
                    {!! $course->description !!}
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $course->begin_date }}</td>
                            <td>{{ $course->end_date }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
                <h4>Danh sách chương</h4>
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('unit.create', ['course_id'=>$course->id]) }}" class="btn btn-success float-right">+ Thêm chương mới</a>
                    </div>
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên chương</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody id="load">
                            @forelse($units as $unit)
                            <tr>
                                <td>{{ $loop->iteration + ($units->currentPage() -1) * $units->perPage() }}</td>
                                <td>{{ $unit->title }}</td>
                                <td>
                                    <a href="{{ route('unit.detail', ['id'=>$unit->id]) }}" class="btn btn-primary">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('unit.edit', [$unit->id]) }}" class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="javascript:unit_delete('{{ $unit->id }}')">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">Khóa học chưa có chương!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        {{-- {!! $units->appends(Request::all())->links() !!} --}}
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
                <h5 class="modal-title" id="deleteModalLabel">Xóa chương!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" action="{{ route('unit.delete', ['course_id'=>$course->id]) }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="unit_id" id="unit_id" value="0">
                <div class="modal-body">
                    Bạn có chắc muốn xóa chương này?
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
    function unit_delete(id) {
        var unit_id = document.getElementById('unit_id');
        unit_id.value = id;
    }
</script>
@endsection