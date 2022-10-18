@extends('client.layouts.master')
@section('title', 'Chi tiết bài học')

@section('content')

    <div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }})">
        <div class="breadcrumb-circle">
            <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
        </div>
        <div class="container">
            <h2 class="breadcrumb-title">
                Liên hệ
            </h2>
            <ul class="breadcrumb-menu clearfix">
                <li>
                    <a href="{{ route('home') }}">
                        Trang chủ
                    </a>
                </li>
                <li class="active">
                    Tôi
                </li>
            </ul>
        </div>
    </div>

    <section class="content" style="margin:60px 0">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($lesson)
                                <h4>
                                    Tên bài học: {{ $lesson->title }}
                                </h4>
                                <div class="table-responsive">
                                    @forelse ($files as $file)
                                        @if ($file->type == 'link')
                                            @php
                                                $vid = explode('=', $file->path, 3);
                                                $vid_code = explode('&', $vid[1] ?? '');
                                                $vid_id = $vid_code[0];
                                            @endphp
                                            <div class="d-flex justify-content-center">
                                                <iframe src="https://youtube.com/embed/{{ $vid_id }}" width="700"
                                                    height="415" allowfullscreen>
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
                                                <a href="{{ route('lesson.download', [$file->id]) }}" download=""
                                                    style="color: white">
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
                                            <h4>Nội dung bài học</h4>
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


@endsection
