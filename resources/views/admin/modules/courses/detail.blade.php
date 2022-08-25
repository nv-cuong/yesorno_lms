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
                @if ($course)
                <h2>{{ $course->title }}</h2>
                <div class="mb-3">
                    <img src="{{ ($course->image) }}" class="img-thumbnail">
                </div>
                <h4>Mô tả khóa học</h4>
                <div class="table-responsive">
                    {{ $course->description }}
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
                            <td class="text-end">{{ $course->begin_date }}</td>
                            <td class="text-end">{{ $course->end_date }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
                <h4>Danh sách chương</h4>
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('course.create') }}" class="btn btn-success float-right">+ Thêm chương mới</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên chương</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($units as $unit)
                            <tr>
                                <td>{{ $loop->iteration + ($units->currentPage() -1) * $units->perPage() }}</td>
                                <td>
                                    <a href="{{ route('unit.detail', ['slug'=>$unit->slug]) }}">
                                        {{ $unit->title }}
                                    </a>
                                </td>
                                <td class="text-end">{{ $unit->created_at->format('d-m-Y') }}</td>
                                <td class="text-end">{{ $unit->updated_at->format('d-m-Y') }}</td>
                                <td style="white-space: nowrap ;">
                                    <a href="#" class="btn btn-success">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="javascript:course_delete('{{ $unit->id }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No Units</td>
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