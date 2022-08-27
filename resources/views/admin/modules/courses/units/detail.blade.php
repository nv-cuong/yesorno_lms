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
                        <a href="{{ route('course.create') }}" class="btn btn-success float-right">+ Thêm chương mới</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên bài</th>
                                <th>Loại</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lessons as $lesson)
                            <tr>
                                <td>{{ $loop->iteration + ($lessons->currentPage() -1) * $lessons->perPage() }}</td>
                                <td>
                                    <a href="{{ route('unit.detail', ['slug'=>$unit->slug]) }}">
                                        {{ $lesson->title }}
                                    </a>
                                </td>
                                <td >{{ $lesson->config }}</td>
                                <td >{{ $lesson->created_at->format('d-m-Y') }}</td>
                                <td >{{ $lesson->updated_at->format('d-m-Y') }}</td>
                                <td style="white-space: nowrap ;">
                                    <a href="#" class="btn btn-success">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="javascript:course_delete('{{ $lesson->id }}')">
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