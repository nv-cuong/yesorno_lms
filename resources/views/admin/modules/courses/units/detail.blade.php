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
                @if ($unit)
                <h2>{{ $unit->title }}</h2>
                @endif
                <h4>Danh sách bài học</h4>
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('lesson.create', ['unit_id'=>$unit->id]) }}" class="btn btn-success float-right">+ Thêm bài học mới</a>
                    </div>
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên bài</th>
                                <th>Ngày xuất</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody id="load">
                            @forelse($lessons as $lesson)
                            <tr>
                                <td>{{ $loop->iteration + ($lessons->currentPage() -1) * $lessons->perPage() }}</td>
                                <td>{{ $lesson->title }}</td>
                                <td>{{ $lesson->published }}</td>
                                <td>
                                    <a href="{{ route('lesson.detail', ['id'=>$lesson->id]) }}" class="btn btn-primary">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('lesson.edit', [$lesson->id]) }}" class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="javascript:lesson_delete('{{ $lesson->id }}')">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">Chương chưa có bài!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        {{-- {!! $lessons->appends(Request::all())->links() !!} --}}
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
                <h5 class="modal-title" id="deleteModalLabel">Xóa bài học!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" action="{{ route('lesson.delete', ['unit_id'=>$unit->id]) }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="lesson_id" id="lesson_id" value="0">
                <div class="modal-body">
                    Bạn có chắc muốn xóa bài học này?
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
    function lesson_delete(id) {
        var lesson_id = document.getElementById('lesson_id');
        lesson_id.value = id;
    }
</script>
@endsection