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
                @if ($lesson)
                <h2>{{ $lesson->title }}</h2>
                <h4>Nội dung bài học</h4>
                <div class="table-responsive">
                    {{ $lesson->content }}
                </div>
                <div class="table-responsive">
                    <a href="{{ $lesson->path}}" target="_blank">{{ $lesson->path }}</a>
                </div>
                @endif
            </div>
        </div>
</section>
@endsection