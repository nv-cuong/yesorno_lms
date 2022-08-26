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
        @include('admin/_alert')
        <hr>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Sửa khóa học</h2>
                <div>
                    <form method="post" action="{{ route('course.update', [$course->id]) }}" enctype="multipart/form-data">
                        @include('admin.modules.courses._course_form')
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
</section>
@endsection