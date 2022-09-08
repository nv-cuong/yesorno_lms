@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản lí khóa học</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('course.index') }}">Khóa học</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit.detail', $lesson->unit_id) }}">Chương</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $lesson->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        @if ($lesson)
                        <h2>{{ $lesson->title }}</h2>
                        <div class="table-responsive">
                            @forelse ($files as $file)
                            @if ($file->type == 'link')
                            @php
                            $vid = explode('=', $file->path, 3);
                            $vid_code = explode('&', $vid[1]);
                            $vid_id = $vid_code[0];
                            @endphp
                            <div class="d-flex justify-content-center">
                                <iframe src="@php echo'https://youtube.com/embed/'. $vid_id .'' @endphp" width="700" height="415" allowfullscreen></iframe>
                            </div>
                            @else
                            <div class="d-inline-flex p-2 bd-highlight">
                                <a href="{{ route('lesson.download', [$file->id]) }}" download="">Tải tài liệu</a>
                            </div>
                            @endif
                            @empty
                            <p>Không có file nào</p>
                            @endforelse
                        </div>
                        <div class="table-responsive">
                            <strong>
                                <span style="color: black">
                                    <h6>Nội dung bài học</h6>
                                </span>
                                {!! $lesson->content !!}
                            </strong>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
