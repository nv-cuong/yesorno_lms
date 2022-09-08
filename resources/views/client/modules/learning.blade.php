@extends('client.layouts.master')
@section('title', 'Chi tiết bài học')

@section('content')

    <div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }})">
        <div class="breadcrumb-circle">
            <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
        </div>
        <div class="container">
            <h2 class="breadcrumb-title">Liên hệ</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="active">Tôi</li>
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
                        <h4> Tên bài học: {{ $lesson->title }}</h4>
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
