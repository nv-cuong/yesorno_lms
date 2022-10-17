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
                                <h2>
                                    {{ $lesson->title }}
                                </h2>
                                <div class="table-responsive">
                                    @forelse ($files as $file)
                                        @if ($file->type == 'link')
                                            @php
                                                $vid = explode('=', $file->path, 3);
                                                $vid_code = explode('&', $vid[1] ?? '');
                                                $vid_id = $vid_code[0];
                                            @endphp
                                            <div class="d-flex justify-content-center">
                                                <iframe src="@php echo'https://youtube.com/embed/'. $vid_id .'' @endphp"
                                                    width="700" height="415" allowfullscreen>
                                                </iframe>
                                            </div>
                                            <span>
                                                Tài liệu bài học:
                                            </span>
                                            <br>
                                        @else
                                            @php
                                                $path = explode('/', $file->path);
                                                $file_name = $path[count($path) - 1];
                                            @endphp
                                            <button type="button" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                                </svg>
                                                <a href="{{ route('lesson.download', [$file->id]) }}" download="" style="color: white">
                                                    @php echo " " . $file_name @endphp
                                                </a>
                                            </button>
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
