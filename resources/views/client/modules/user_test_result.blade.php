@extends('client.layouts.master')
@section('title', 'Danh sách khóa học')

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
    <div class="wavesshape">
        <img src="{{ asset('/user/img/course/course-bg-2.png') }}" alt="thumb">
    </div>
    <div class="container">
        <div class="row csf align-items-center">
            <div class="col-xl-8">
                <div class="site-title-left">
                    <h2>Cảm ơn bạn đã tham gia bài test</h2>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="site-title-right">
                    <h2>Course</h2>
                </div>
            </div>
        </div>
        <div class="portfolio-items-area">
            <div class="row">
                <div class="col-xl-12 portfolio-content">
                    <div class="row align-items-center">

                        <div class="col-xl-12">
                            <div class="course-view-more">
                                @if($test_users->score != Null)
                                <h4>Điểm của bạn là : {{$test_users->score}} </h4>
                                <a href="{{ route('user_tests_detail',$test_users->id)}}" class ="btn btn-primary" >Xem lại bài làm</a>
                                @else
                                <h4>Vui lòng đợi giáo viên chấm điểm: ! </h4>
                                <a href="{{ route('user_tests_detail',$test_users->id)}}" class ="btn btn-primary" >Xem lại bài làm</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End Mixitup Nav-->

                </div>
            </div>
        </div>
    </div>
    <div class="text-center">

    </div>
</div>

@endsection
