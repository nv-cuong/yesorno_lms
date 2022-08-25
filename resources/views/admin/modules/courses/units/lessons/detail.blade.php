@extends('admin.layouts.master')
@section('title', 'Course Manager')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Quản lý khóa học</h2>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm kiếm...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                @include('admin/_alert')
                @if ($unit)
                <h2>{{ $unit->title }}</h2>
                @endif
                <h4>Danh sách bài học</h4>
                <table class="table table-hover text-nowrap">
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

                {{ $lessons->links() }}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection