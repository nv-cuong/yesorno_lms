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
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <h2>Tạo khóa học mới</h2>
                    <div>
                        <form method="post" action="{{ route('course.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="course_title" class="form-label">Tên khóa học</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="course_title">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="begin_date" class="form-label">Ngày bắt đầu</label>
                                <input type="date" name="begin_date" class="form-control @error('begin_date') is-invalid @enderror" id="begin_date">
                                @error('begin_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Ngày kết thúc</label>
                                <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" id="end_date">
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Ảnh</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="" cols=""></textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection