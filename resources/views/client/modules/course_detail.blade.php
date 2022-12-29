@extends('client.layouts.master')
@section('title', 'Chi tiết khóa học')

@section('content')

    <div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }}">
        <div class="breadcrumb-circle">
            <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
        </div>
        <div class="container">
            <h2 class="breadcrumb-title">Chi tiết khóa học</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="active">Khóa học</li>
            </ul>
        </div>
    </div>
    <div class="course-info de-padding">
        <div class="container">
            <div class="course-info-wrapper">
                <div class="course-left-sidebar">

                    <div class="course-left-box crs-post">
                        <h5 class="course-left-title">Những khóa học khác</h5>
                        <div class="course-post">
                            @foreach ($courses_slide as $item)
                                <div class="course-post-wrp">
                                    <img src="{{ asset($item->image) }}" style="width: 80px" alt="thumb">
                                    <div class="course-post-text">
                                        <a href="{{ route('detail', $item->slug) }}">{{ $item->title }}</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="course-right-content">
                    <div class="course-syl-header">
                        <h2 class="course-syl-title">
                            {{ $course->title }}
                        </h2>
                        <div class="course-syl-author cr-mb">
                            @if (session('message'))
                                <div class="alert alert-{{ session('type_alert') }} alert-dismissible fade show"
                                    role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <span style="color:brown"> Bắt đầu từ: </span>{{ $course->begin_date }} <span style="color:brown">
                            đến: </span> {{ $course->end_date }} <br>
                        @if ($course->status == 0)
                            <h5>( Khóa học miễn phí )</h5>
                        @endif
                        <div class="course-syl-price cr-mb">
                            <ul>
                                <li>
                                    <p title="Số lượng học sinh đã đang kí học"><i
                                            class="fas fa-user"></i>{{ $course->users()->get()->count() }} Đang học</p>
                                </li>
                                <li>
                                    @if ($user && $access)
                                        <form action="{{ route('post.detach') }}" method="get">
                                            Bạn đã đăng kí khóa học này
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <input type="hidden" name="course_slug" value="{{ $course->slug }}">
                                            <button type="submit" class="btn btn-danger"
                                                title="Đăng kí vào khóa học">Hủy</button>
                                        </form>
                                    @elseif($user)
                                        <form action="{{ route('post.attach') }}" method="get">
                                            @foreach ($units as $unit)
                                                @php
                                                    $lessons = App\Models\Lesson::where('unit_id', $unit->id)->get();
                                                @endphp
                                                @foreach ($lessons as $item)
                                                    <input type="hidden" name="lesson_id[]" value="{{ $item->id }}">
                                                @endforeach
                                            @endforeach
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <input type="hidden" name="course_slug" value="{{ $course->slug }}">
                                            <button type="submit" class="theme-btn" title="Đăng kí vào khóa học">Ghi danh
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('post.attach') }}" method="get">
                                            <input type="hidden" name="course_slug" value="{{ $course->slug }}">
                                            <button type="submit" class="theme-btn" title="Đăng kí vào khóa học">Ghi danh
                                            </button>
                                        </form>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        @if ($access)
                            <span>
                                Tiến độ khóa học: {{ $progress }}%
                            </span>
                            <div class="progress" style="height: 30px">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuenow={{ $progress }} aria-valuemin="0" aria-valuemax="100"
                                    style="width: {{ $progress }}%">
                                </div>
                            </div>
                            <br>
                        @endif

                        <div class="course-course-pic cr-mb">
                            <img src="{{ asset($course->image) }}" style="width: 100%; height: 410px" alt="thumb">
                        </div>
                    </div>
                    <div class="course-syl-bottom">
                        <div class="course-syl-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                        role="tab" aria-controls="nav-home" aria-selected="true">
                                        Mô tả
                                    </a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                        role="tab" aria-controls="nav-profile" aria-selected="false">
                                        Nội dung
                                    </a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class="course-syl-con">
                                        <div class="course-syl-con-header" style="text-align: justify;">
                                            {!! $course->description !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="course-accordion">
                                        <div class="course-accordion-header mb-30">
                                            <h2 class="course-content-title">
                                                Nội dung khóa học
                                            </h2>
                                        </div>
                                        <div class="ask">
                                            @php
                                                $sttUnit = 0;
                                            @endphp
                                            <div class="panel-group" id="accordion" role="tablist"
                                                aria-multiselectable="true" style="margin-bottom : 50px">
                                                @forelse ($course->units as $unit)
                                                    @php
                                                        $sttUnit++;
                                                        $stt = 0;
                                                    @endphp
                                                    <div class="panel-heading" role="tab"
                                                        id="heading{{ $unit->id }}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse"
                                                                data-parent="#accordion"
                                                                href="#collapse{{ $unit->id }}" aria-expanded="false"
                                                                aria-controls="collapse{{ $unit->id }}"
                                                                class="collapsed">
                                                                Chương {{ $sttUnit }}: {{ $unit->title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    @foreach ($lessons as $lessonItem)
                                                        @if ($lessonItem['unit_id'] == $unit->id)
                                                            @php
                                                                $stt++;
                                                            @endphp
                                                            <div id="collapse{{ $unit->id }}"
                                                                class="panel-collapse in collapse" role="tabpanel"
                                                                aria-labelledby="heading{{ $unit->id }}">
                                                                <div class="panel-body">
                                                                    <ul class="course-video-list">
                                                                        <li>
                                                                            <div class="course-video-wrp">
                                                                                <div class="course-item-name">
                                                                                    <div>
                                                                                        @if ($lessonItem->status == 1)
                                                                                            <i class="fas fa-play"></i>
                                                                                        @else
                                                                                            <i
                                                                                                class="fas fa-play text-muted"></i>
                                                                                        @endif
                                                                                        <span>
                                                                                            bài {{ $stt }}:
                                                                                        </span>
                                                                                    </div>
                                                                                    <h5>
                                                                                        {{ $lessonItem->title }}
                                                                                    </h5>
                                                                                </div>
                                                                                @if ($access)
                                                                                    <div class="course-time-preview">
                                                                                        <div class="course-item-info">
                                                                                            <a
                                                                                                href="{{ route('personal.lesson', [$lessonItem->slug]) }}">
                                                                                                Xem
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    Hãy đăng ký khóa học
                                                                                @endif
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @empty
                                                    Chưa có chương học!
                                                @endforelse
                                            </div>
                                            @if ($countLesson == $courseLesson)
                                                <div class="ask">
                                                    <div class="panel-group" id="accordion">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                                <a role="button"
                                                                    href="{{ route('finalTest', [$course->id]) }}">
                                                                    Làm bài kiểm tra cuối khóa
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
