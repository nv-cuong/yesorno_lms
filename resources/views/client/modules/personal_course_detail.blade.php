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
                    @foreach ($courses as $courseItem)
                    <div class="course-post-wrp">
                        <img style="width : 80px; height : 80px" src="{{ $courseItem->image }}" alt="thumb">
                        <div class="course-post-text">
                            <h6>{{ $courseItem->title }}</h6>
                            <span>Begindate: {{ $course->begin_date }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="course-right-content">
                <div class="course-syl-header">
                    <h2 class="course-syl-title">
                        {{ $course->title }}
                    </h2>
                    <div class="course-syl-price cr-mb">
                        <ul>
                            <li>
                                <p><i class="fas fa-user"></i>Ngày bắt đầu : {{ $course->begin_date }}</p>
                            </li>
                            <li>
                                <p><i class="fas fa-user"></i>Ngày kết thúc : {{ $course->begin_date }}</p>
                            </li>
                            <li>
                                <form action="{{ route('post.detach') }}" method="get">
                                    Bạn đã đăng kí khóa học này
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <input type="hidden" name="course_slug" value="{{ $course->slug }}">
                                    <button type="submit" class="btn btn-danger" title="Đăng kí vào khóa học">Hủy</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="course-course-pic cr-mb">
                        <img src="{{ asset('/user/img/details-page/imagesss.jpg') }}" alt="thumb">
                    </div>
                </div>
                <div class="course-syl-bottom">
                    <div class="course-syl-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                    Mô tả
                                </a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    Nội dung
                                </a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                                    Danh sách lớp
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="course-syl-con">
                                    <div class="course-syl-con-header" style="text-align: justify;">
                                        {!! $course->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                @foreach ($course->classStudies()->get() as $class)
                                <div class="course-ovr-wrp">
                                    <div class="course-over-fet">
                                        <div class="course-over-bio">
                                            <div class="course-over-name">
                                                <h5> <span style="color: violet">Tên lớp: </span>
                                                    {{ $class->name }}
                                                </h5>
                                                <h6><span style="color: violet">Thời gian học: </span>
                                                    @if ($class->schedule == 0)
                                                    Sáng
                                                    @elseif ($class->schedule == 1)
                                                    Chiều
                                                    @else
                                                    Cả ngày
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                        <p class="mb-0">
                                            {!! $class->description !!}
                                        </p>
                                        <a href="#" class="theme-btn">Đăng kí lớp</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                @if ($access->status == 1)
                                <div class="course-accordion">
                                    <div class="course-accordion-header mb-30">
                                        <h2 class="course-content-title">Nội dung khóa học</h2>
                                    </div>
                                    <div class="ask">
                                        @php
                                        $countCourse = 0
                                        @endphp
                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom : 50px">
                                        @forelse ($course->units()->get() as $unit )

                                            <div class="panel-heading" role="tab" id="heading{{ $unit->id }}">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $unit->id }}" aria-expanded="false" aria-controls="collapse{{ $unit->id }}" class="collapsed">
                                                        {{ $unit->title }}
                                                    </a>
                                                </h4>
                                            </div>
                                            @php
                                            $stt = 0;
                                            $countLesson = 0;
                                            @endphp
                                            @foreach ($lessons as $lessonItem)
                                            @if ($lessonItem['unit_id'] == $unit->getOriginal('id'))
                                            @if ($lessonItem['status'] == 1)
                                            @php
                                            $stt ++;
                                            $countLesson ++;
                                            $countCourse ++;
                                            @endphp
                                            <div id="collapse{{ $unit->id }}" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="heading{{ $unit->id }}">
                                                <div class="panel-body">
                                                    <ul class="course-video-list">
                                                        <li>
                                                            <div class="course-video-wrp">
                                                                <div class="course-item-name">
                                                                    <div>
                                                                        <i class="fas fa-play"></i>
                                                                        <span>bài {{ $stt }}:</span>
                                                                    </div>
                                                                    <h5>{{ $lessonItem['title'] }}</h5>
                                                                </div>
                                                                <div class="course-time-preview">
                                                                    <div class="course-item-info">
                                                                        <a href="{{ route('personal.lesson', [$lessonItem->slug]) }}">Xem</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @else
                                            @php
                                                $stt ++;
                                            @endphp
                                            <div id="collapse{{ $unit->id }}" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="heading{{ $unit->id }}">
                                                <div class="panel-body">
                                                    <ul class="course-video-list">
                                                        <li>
                                                            <div class="course-video-wrp">
                                                                <div class="course-item-name">
                                                                    <div>
                                                                        <i class="fas fa-play text-muted"></i>
                                                                        <span>bài:
                                                                            {{ $stt }}</span>
                                                                    </div>
                                                                    <h5>{{ $lessonItem['title'] }}</h5>
                                                                </div>
                                                                <div class="course-time-preview">
                                                                    <div class="course-item-info">
                                                                        <a href="{{ route('personal.lesson', [$lessonItem->slug]) }}">Xem</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                            @endforeach
                                            @empty
                                            <div class="panel-heading" role="tab" id="heading{{ $unit->id }}" style="margin-bottom : 20px">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $unit->id }}" aria-expanded="false" aria-controls="collapse{{ $unit->id }}" class="collapsed">
                                                        Không có chương nào
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                        @endforelse
                                            @if($countCourse == $courseLesson)
                                            <div class="ask">
                                                <div class="panel-group" id="accordion">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" href="{{route('random_test',[$course->id])}}">
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
                            @else
                            <div class="ask">
                                <div class="panel-group" id="accordion">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" href="{{ route('home') }}">
                                                Hãy đợi được tham gia khóa học
                                            </a>
                                        </h4>
                                    </div>
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

@stop
