@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản lí khóa học</h1>
            </div>
            <div class="col-sm-6 ">
                <form action="" class="form-inline justify-content-end">
                    <div class="form-group">
                        <input type="text" class="form-control" name="key" placeholder="Tìm kiếm theo tiêu đề...">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên bài</th>
                                <th>Loại</th>
                                <th>Ngày xuất</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lessons as $lesson)
                            <tr>
                                <td>{{ $loop->iteration + ($lessons->currentPage() -1) * $lessons->perPage() }}</td>
                                <td>
                                    <a href="{{ route('lesson.detail', ['slug'=>$lesson->slug]) }}">
                                        {{ $lesson->title }}
                                    </a>
                                </td>
                                <td>{{ $lesson->config }}</td>
                                <td>{{ $lesson->published }}</td>
                                <td>{{ $lesson->created_at->format('d-m-Y') }}</td>
                                <td>{{ $lesson->updated_at->format('d-m-Y') }}</td>
                                <td style="white-space: nowrap ;">
                                    <a href="{{ route('lesson.edit', [$lesson->id]) }}" class="btn btn-success">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="javascript:lesson_delete('{{ $lesson->id }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No Lessons</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        {{-- {!! $listAr->appends(Request::all())->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xóa bài học!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('lesson.delete', ['unit_id'=>$unit->id]) }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="lesson_id" id="lesson_id" value="0">
                <div class="modal-body">
                    Bạn có chắc muốn xóa bài học này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function lesson_delete(id) {
        var lesson_id = document.getElementById('lesson_id');
        lesson_id.value = id;
    }
</script>
@stop
