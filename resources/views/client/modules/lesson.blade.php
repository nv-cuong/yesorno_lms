@extends('client.layouts.master')
@section('title', 'Chi tiết khóa học')
@section('content')
<div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }})">
    <div class="breadcrumb-circle">
        <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
    </div>
    <div class="container">
        <h2 class="breadcrumb-title">Danh sách khóa học</h2>
        <ul class="breadcrumb-menu clearfix">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="active">Khóa học</li>
        </ul>
    </div>
</div>
<div id="portfolio" class="portfolio-area course-2 de-padding">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid">
        <div class="row mb-2">
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="container-fluid col-md-12">
                            @if ($lesson)
                            <h2 style="text-align: center">Tên bài học : {{ $lesson->title }}</h2>
                            <div class="table-responsive">
                                @forelse ($files as $file)
                                @if ($file->type == 'link')
                                @php
                                $vid = explode('=', $file->path, 3);
                                $vid_code = explode('&', $vid[1]);
                                $vid_id = $vid_code[0];
                                @endphp
                                <div style="text-align: center; margin : 50px">
                                    <iframe id="existing-iframe-example" width="1280" height="720" 
                                        src="https://www.youtube.com/embed/{{ $vid_id }}?enablejsapi=1" 
                                        frameborder="0" style="border: solid 4px rgb(247, 174, 38)" method="POST">
                                        csrf_token()</iframe>
                                </div>
                                @else
                                <div class="d-inline-flex p-2 bd-highlight">
                                    <a href="{{ route('lesson.download', [$file->id]) }}" download="">Tải tài liệu</a>
                                </div>
                                @endif
                                @empty
                                <p>Không có file nào</p>
                                @endforelse
                                <h4>Nội dung bài học :</h4>
                                <div class="table-responsive" style="margin-bottom: 50px">
                                    {!! $lesson->content !!}
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-center">
                                    @if($nextLesson)
                                    <button class="">
                                        <a href="{{ route('personal.lesson', [$nextLesson->slug]) }}">
                                            <i class="fa fa-arrow-right">
                                                <span>BÀI TIẾP THEO</span>
                                            </i>
                                        </a>
                                    </button>
                                    @else
                                    <h5>KẾT THÚC CHƯƠNG</h5>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var tag = document.createElement('script');
            tag.id = 'iframe-demo';
            tag.src = 'https://www.youtube.com/iframe_api';
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            var player;
            var status = '{{ $user_lesson->status }}';
            var previousAction;
            var previousTime = 0;

            function onYouTubeIframeAPIReady() {
                player = new YT.Player('existing-iframe-example', {
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            function onPlayerReady(event) {
                document.getElementById('existing-iframe-example').style.borderColor = '#FF6D00';
                alert("Bạn không được phép tua!\nNếu tua sẽ xem lại từ đầu!");
            }

            function onPlayerStateChange({target, data}) {

                const currentTime = target.getCurrentTime();
                if (data == 0) {
                    $(document).ready(function() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }
                        });
                        $.ajax({
                            url: "{!! route('lessonProgress', [$lesson->slug]) !!}",
                            method: "POST",
                            data: {},
                        })
                    });
                } 
                else if (previousAction == 1 && data == 3) {
                    if (status == 0) {
                        return player.seekTo(previousTime);
                    }
                }
                else if (!previousAction || previousAction != 2) {
                    previousAction = data;
                    return data;
                } 
                else if (Math.abs(previousTime - currentTime) > 1 && data == 3) {
                    if (status == 0) {
                        return player.seekTo(previousTime);
                    }
                }
                previousTime = currentTime;
                previousAction = data;
            }
        </script>
    </section>
    @endsection
</div>