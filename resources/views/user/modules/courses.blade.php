@extends('user.layouts.master')
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
                        <h2>Các khóa học tuyệt vời của chúng tôi</h2>
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
                                                <img src="{{ asset('/user/img/course/course-1.jpg') }}" class="course-img"
                                                    alt="thumb">
                                                <div class="course-2-pic-content">
                                                    <p><span>356</span> người đã học</p>
                                                </div>
                                            </div>
                                            <div class="course-2-content">
                                                <div class="course-author">
                                                    <img src="{{ asset('/user/img/course/user-1.jpg') }}" alt="thumb">
                                                    <h6>Samrun Whatson</h6>
                                                </div>
                                                <div class="course-2-text">
                                                    <h5>{{ $course->title }}</h5>
                                                    <p
                                                        style="">
                                                        {!! $course->description !!}
                                                    </p>
                                                </div>
                                                <div class="course-2-bottom">
                                                    <div class="course-2-lesson">
                                                        <i class="fas fa-book-open"></i>
                                                        <p class="mb-0">26 lesson</p>
                                                    </div>
                                                    <div class="course-2-price">
                                                        Price:<span>$15.00</span>
                                                    </div>
                                                </div>
                                                <div class="course-2-btn">
                                                    <a href="{{ route('detail', $course->slug) }}"
                                                        class="theme-btn btn-2">Ghi danh ngay</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            {{ $courses->links() }}
        </div>
    </div>

@endsection
