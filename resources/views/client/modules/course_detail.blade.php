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
                    <h5 class="course-left-title">More course for you</h5>
                    <div class="course-post">
                        <div class="course-post-wrp">
                            <img src="{{ asset('/user/img/singlepost/post-2.png') }}" alt="thumb">
                            <div class="course-post-text">
                                <h6>Complete education learning course 2020</h6>
                                <span>$90.00</span>
                            </div>
                        </div>
                        <div class="course-post-wrp">
                            <img src="{{ asset('/user/img/singlepost/post-2.png') }}" alt="thumb">
                            <div class="course-post-text">
                                <h6>Complete education learning course 2020</h6>
                                <span>$90.00</span>
                            </div>
                        </div>
                        <div class="course-post-wrp">
                            <img src="{{ asset('/user/img/singlepost/post-2.png') }}" alt="thumb">
                            <div class="course-post-text">
                                <h6>Complete education learning course 2020</h6>
                                <span>$90.00</span>
                            </div>
                        </div>
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
                        <div class="alert alert-{{ session('type_alert') }} alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="course-syl-price cr-mb">

                        <ul>
                            <li>
                                <p title="Số lượng học sinh đã đang kí học"><i class="fas fa-user"></i>{{ $course->users()->get()->count() }} Đang học</p>
                            </li>
                            <li>
                                @if($user && $ok == 1)
                                <form action="{{ route('post.detach') }}" method="get">
                                    Bạn đã đăng kí khóa học này
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <input type="hidden" name="course_slug" value="{{ $course->slug }}">
                                    <button type="submit" class="btn btn-danger" title="Đăng kí vào khóa học">Hủy</button>
                                </form>
                                @elseif($user)
                                <form action="{{ route('post.attach') }}" method="get">
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <input type="hidden" name="course_slug" value="{{ $course->slug }}">
                                    <button type="submit" class="theme-btn" title="Đăng kí vào khóa học">Ghi danh </button>
                                </form>
                                @else
                                <form action="{{ route('post.attach') }}" method="get">
                                    <input type="hidden" name="course_slug" value="{{ $course->slug }}">
                                    <button type="submit" class="theme-btn" title="Đăng kí vào khóa học">Ghi danh </button>
                                </form>
                                @endif
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

                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="course-accordion">
                                    <div class="course-accordion-header mb-30">
                                        <h2 class="course-content-title">Nội dung khóa học</h2>
                                        <p class="mb-0">
                                            <i class="fas fa-check"></i>
                                            <span>
                                                Học lập trình để đi làm
                                            </span>

                                        </p>
                                    </div>
                                    <div class="ask">
                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                            @php $n = 0; @endphp

                                            @foreach ($units as $unit)

                                            @php $n = $n + 1; @endphp

                                            <div class="panel panel-default panel-active">
                                                <div class="panel-heading" role="tab" id="@if ($n == 1){{'headingOne'}}@elseif($n == 2){{'headingTwo'}}@else{{'heading'.$n}}@endif">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="@if ($n == 1){{'#collapseOne'}}@elseif($n == 2){{'#collapseTwo'}}@else{{'#collapse'.$n}}@endif" aria-expanded="false" aria-controls="@if ($n == 1){{'collapseOne'}}@elseif($n == 2){{'collapseTwo'}}@else{{'collapse'.$n}}@endif" class="collapsed">
                                                            Chương {{$n}}: {{$unit->title}}
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="@if ($n == 1){{'collapseOne'}}@elseif($n == 2){{'collapseTwo'}}@else{{'collapse'.$n}}@endif" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="@if ($n == 1){{'headingOne'}}@elseif($n == 2){{'headingTwo'}}@else{{'heading'.$n}}@endif" style="">
                                                    <div class="panel-body">
                                                        <ul class="course-video-list">

                                                            @php
                                                            $lessons = App\Models\Lesson::where('unit_id', $unit->id)->get();
                                                            $stt = 0;
                                                            @endphp

                                                            @foreach ($lessons as $lesson)

                                                            @php
                                                            $stt = $stt + 1;
                                                            @endphp
                                                            <li>
                                                                <div class="course-video-wrp">
                                                                    <div class="course-item-name">
                                                                        <div>
                                                                            <i class="fas fa-play"></i>
                                                                            <span>Bài {{$stt}}</span>
                                                                        </div>
                                                                        <h5>{{$lesson->title}}</h5>
                                                                    </div>
                                                                    <div class="course-time-preview">
                                                                        <div class="course-item-info">
                                                                            <span>Duration: 5 min</span>
                                                                            <a href="{{route('home')}}">Xem</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                @foreach ($course->classStudies()->get() as $class)
                                <div class="course-ovr-wrp">
                                    <div class="course-over-fet">
                                        <div class="course-over-bio">
                                            <div class="course-over-name">
                                                <h5> <span style="color: violet">Tên lớp: </span> {{ $class->name }}</h5>
                                                <h6><span style="color: violet">Thời gian học: </span> @if ($class->schedule == 0)
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
