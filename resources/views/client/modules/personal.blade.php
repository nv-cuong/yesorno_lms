@extends('client.layouts.master')
@section('title', 'Danh sách khóa học')

@section('content')

<div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }})">
    <div class="breadcrumb-circle">
        <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
    </div>
    <div class="container">
        <h2 class="breadcrumb-title">Trang cá nhân</h2>
        <ul class="breadcrumb-menu clearfix">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="active">Tôi</li>
        </ul>
    </div>
</div>

<!-- Start Cate-3
                    ============================================= -->
<div class="cate-3-area bg-2 de-padding">
    <div class="container">
        <div class="cate-3-title">
            <div class="row align-items-center">
                <div class="col-xl-8">
                    <span class="sub-2">Find Perfect one</span>
                    <h2>Check all categories and enroll </h2>
                </div>
                <div class="col-xl-4">
                    <a href="#" class="theme-btn">View All Categories <i class="ti ti-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <span> Tiến độ các khóa học : {{$progress}}%</span>
        <div class="progress" style="height: 30px">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow={{$progress}} aria-valuemin="0" aria-valuemax="100" style="width: {{$progress}}%"></div>
        </div>
        <br>
    </div>
</div>

<div class="author-info posi-rel de-padding">
    <div class="author-shape">
        <img src="{{ asset('user/img/details-page/author-bg.png') }}" alt="thumb">
    </div>
    <div class="container">
        <div class="author-bio-wrapper grid-3">
            <div class="auhtor-pic">
                <img src="{{ asset('user/img/team/team-1.jpg') }}" alt="thumb">
            </div>
            <div class="auhtor-con">
                <span>Tên học viên:</span>
                <h5>{{ $student->first_name }}</h5>
                <ul class="author-list">
                    <li> <b>Tổng khóa học:</b> 165</li>
                    <li> <b>Số điện thoại:</b> {{ $student->phone }}</li>
                    <li> <b>E-mail:</b> {{ $student->email }}</li>
                    <li> <b>Địa chỉ:</b> </li>

                </ul>
            </div>

        </div>
    </div>
</div>


<div id="portfolio" class="portfolio-area course-2 de-pb">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8">
                <div class="site-title-left">
                    <h2>Đang học</h2>
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
                        <div class="col-xl-8">
                            <div class="mix-item-menu active-theme">
                                <button class="active" data-filter="*">All</button>
                                <button data-filter=".development" class="">Science</button>
                                <button data-filter=".design" class="">Engineering</button>
                                <button data-filter=".photography" class="">Diploma </button>
                                <button data-filter=".branding" class="">Web Design</button>
                                <button data-filter=".video" class="">Web Development</button>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="course-view-more">
                                <h6>Total Courses 6768 - <a href="#">View All</a></h6>
                            </div>
                        </div>
                    </div>
                    <!-- End Mixitup Nav-->
                    <div class="magnific-mix-gallery masonary">
                        <div id="portfolio-grid" class="portfolio-items" style="position: relative; height: 1285.32px;">
                            @foreach ($courses as $course)
                            <div class="pf-item video photography" style="position: absolute; left: 0%; top: 0px;">
                                <div class="course-2-box">
                                    <div class="course-2-pic">
                                        <img src="{{$course->image}}" class="course-img" alt="thumb">
                                        <div class="course-2-pic-content">
                                            <p><span>{{$course->classStudies()->count()}}</span> Lớp học</p>
                                        </div>
                                    </div>
                                    <div class="course-2-content">
                                        <div class="course-2-text">
                                            <h5>{{$course->title}}</h5>
                                            <div class="desciption_course">
                                                {!! $course->description !!}
                                            </div>
                                        </div>
                                        <div class="course-2-bottom">
                                            <div class="course-2-lesson">
                                                <i class="fas fa-book-open"></i>
                                                <p class="mb-0">{{$course->units()->count()}} Bài học</p>
                                            </div>
                                        </div>
                                        <div class="course-2-btn">
                                            <a href="{{ route('personal.course',[$course->slug]) }}" class="theme-btn btn-2">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="more-btn">
        <a href="#">View All Courses <i class="ti ti-arrow-right"></i></a>
    </div>
</div>


@endsection