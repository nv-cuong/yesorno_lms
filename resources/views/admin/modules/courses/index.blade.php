@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Danh sách khóa học</h1>
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
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tên khóa học</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
              </tr>
            </thead>
            <tbody>
              @forelse($courses as $course)
              <tr>
                <td>{{ $loop->iteration + ($courses->currentPage() -1) * $courses->perPage() }}</td>
                <td>
                  <a href="{{ route('course.detail', ['slug'=>$course->slug]) }}">
                    {{ $course->title }}
                  </a>
                </td>
                <td class="text-end">{{ $course->created_at->format('d-m-Y') }}</td>
                <td class="text-end">{{ $course->updated_at->format('d-m-Y') }}</td>
                <td style="white-space: nowrap ;">
                  <a href="{{ route('course.edit', [$course->id]) }}" class="btn btn-success">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="javascript:course_delete('{{ $course->id }}')">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6">No Courses</td>
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
        <h5 class="modal-title" id="deleteModalLabel">Xóa khóa học!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="{{ route('course.delete') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="course_id" id="course_id" value="0">
        <div class="modal-body">
          Bạn có chắc muốn xóa khóa học này?
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
  function course_delete(id) {
    var course_id = document.getElementById('course_id');
    course_id.value = id;
  }
</script>
@stop