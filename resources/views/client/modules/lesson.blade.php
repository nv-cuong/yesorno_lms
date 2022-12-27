@extends('client.layouts.master')
@section('title', 'Chi tiết khóa học')
@section('content')
<div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }})">
    <div class="breadcrumb-circle">
        <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
    </div>
    <div class="container">
        <h2 class="breadcrumb-title">
            Danh sách khóa học
        </h2>
        <ul class="breadcrumb-menu clearfix">
            <li>
                <a href="{{ route('home') }}">
                    Trang chủ
                </a>
            </li>
            <li>
                <a href="{{ route('personal.lesson', $course->slug) }}">
                    {!! $course->title !!}
                </a>
            </li>
            <li class="active">
                {!! $lesson->title !!}
            </li>
        </ul>
    </div>
</div>
<div id="portfolio" class="portfolio-area course-2 de-padding">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid">
        <div class="row mb-2">
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="container-fluid col-md-12">
                        @if ($lesson)
                        <h2 style="text-align: center">
                            Tên bài học : {{ $lesson->title }}
                        </h2>
                        <div class="table-responsive">
                            @forelse ($files as $file)
                            @if ($file->type == 'link' && $file->path != null)
                            @php
                            $vid = preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $file->path, $matches);
                            $vid_id = $matches[1];
                            @endphp
                            <div style="text-align: center; margin : 50px">
                                <iframe id="existing-iframe-example" width="1280" height="720" 
                                    src="https://www.youtube.com/embed/{{ $vid_id }}?enablejsapi=1" 
                                    frameborder="0" style="border: solid 4px rgb(247, 174, 38)" method="POST">
                                    csrf_token()
                                </iframe>
                            </div>
                            @elseif($file->type != 'link')
                                @php
                                    $path = explode('/', $file->path);
                                    $file_name = $path[count($path) - 1];
                                @endphp
                                <strong>
                                    Tài liệu bài học:
                                </strong>
                                <br><br>
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
                            <p>
                                Không có file nào
                            </p>
                            @endforelse
                            <h4>
                                Nội dung bài học:
                            </h4>
                            <div class="table-responsive" style="margin-bottom: 50px">
                                {!! $lesson->content !!}
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-around">
                                <div></div>
                                <button class="" id="btnDone" @if($userLesson->status == 1) disabled @endif>
                                    <span>
                                        HOÀN THÀNH
                                    </span>
                                </button>
                                @if ($nextLesson)
                                <button class="" id="btnNext">
                                    <a href="{{ route('personal.lesson', [$nextLesson->slug]) }}">
                                        <i class="fa fa-arrow-right">
                                            <span>
                                                BÀI TIẾP THEO
                                            </span>
                                        </i>
                                    </a>
                                </button>
                                @elseif($nextUnit)
                                <button class="" id="btnNext">
                                    <a href="{{ route('personal.lesson', [$nextUnit->lessons[0]->slug]) }}">
                                        <i class="fa fa-arrow-right">
                                            <span>
                                                CHƯƠNG TIẾP THEO
                                            </span>
                                        </i>
                                    </a>
                                </button>
                                @else
                                <h5>
                                    KẾT THÚC KHÓA HỌC
                                </h5>
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
        var status = '{{ $userLesson->status }}';
        var previousAction;
        var previousTime = 0;

        // alert("Bạn không được phép tua!\nNếu tua sẽ xem lại từ đầu!");
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
        }

        function onPlayerStateChange({
            target,
            data
        }) {

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
            } else if (previousAction == 1 && data == 3) {
                if (status == 0) {
                    return player.seekTo(previousTime);
                }
            } else if (!previousAction || previousAction != 2) {
                previousAction = data;
                return data;
            } else if (Math.abs(previousTime - currentTime) > 1 && data == 3) {
                if (status == 0) {
                    return player.seekTo(previousTime);
                }
            }
            previousTime = currentTime;
            previousAction = data;
        }
    </script>
</div>
@endsection
@section('scripts')

<script language="javascript">
    $("#btnDone").click(function(e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "{!! route('lessonProgress', [$lesson->slug]) !!}",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(result) {
                Swal.fire({
                    title: 'Chúc mừng bạn đã hoàn thành bài học!',
                    icon: 'success',
                    showCloseButton: true,
                    showConfirmButton: false,
                })
                $("#btnDone").prop('disabled', true);
            },
            error: function(result) {
                alert('error');
            }
        });
    });
</script>
@endsection