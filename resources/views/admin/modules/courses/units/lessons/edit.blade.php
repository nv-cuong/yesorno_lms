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
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title" style="font-weight:bold">Chỉnh sửa bài học</h2>
                    </div>
                    <form method="post" action="{{ route('lesson.update', [$lesson->id]) }}" enctype="multipart/form-data">
                        <div class="card-body">
                            @include('admin.modules.courses.units.lessons._lesson_form')
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
@endsection