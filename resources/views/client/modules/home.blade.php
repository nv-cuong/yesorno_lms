@extends('client.layouts.master')
@section('title', 'Trang chủ')

@section('content')
    <main class="main">

        <div id="home" class="hero-section header-3">
            <div class="hero-sliderr">
                <div class="hero-single" data-background="{{ asset('/user/img/727798_blog-image-wfh-compliance.png') }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="hero-content">
                                    <h5 class="hero-p1"> nơi cung cấp những khóa học chất lượng và hoàn toàn miễn phí</h5>
                                    <div class="hro-btn">
                                        <a href="{{ route('courses') }}" class="theme-btn">Bắt đầu học <i class="ti ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="right-bg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Feature
                ============================================= -->
        <div class="feature-area header-3 de-pb">
            <div class="container">
                <div class="feature-wrapper grid-4">
                    <div class="feature-box">
                        <div class="feature-header">
                            <div class="feature-icon">
                                <i class="flaticon-corporate"></i>
                            </div>
                            <h4>Free Register & Intership </h4>
                        </div>
                        <div class="feature-bottom">
                            <p>
                                Esse mauris arcu eveniet in. Qua hendrerit. Risus! Deleniti
                            </p>
                            <a href="#" class="feature-btn">Get Started <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="feature-box">
                        <div class="feature-header">
                            <div class="feature-icon">
                                <i class="flaticon-contract"></i>
                            </div>
                            <h4>Free Online Learning offer </h4>
                        </div>
                        <div class="feature-bottom">
                            <p>
                                Esse mauris arcu eveniet in. Qua hendrerit. Risus! Deleniti
                            </p>
                            <a href="#" class="feature-btn">Get Started <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="feature-box">
                        <div class="feature-header">
                            <div class="feature-icon">
                                <i class="flaticon-support-2"></i>
                            </div>
                            <h4> Get Your Dream Scholarship</h4>
                        </div>
                        <div class="feature-bottom">
                            <p>
                                Esse mauris arcu eveniet in. Qua hendrerit. Risus! Deleniti
                            </p>
                            <a href="#" class="feature-btn">Get Started <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="feature-box">
                        <div class="feature-header">
                            <div class="feature-icon">
                                <i class="flaticon-monitor"></i>
                            </div>
                            <h4> Get certificate & show yourself</h4>
                        </div>
                        <div class="feature-bottom">
                            <p>
                                Esse mauris arcu eveniet in. Qua hendrerit. Risus! Deleniti
                            </p>
                            <a href="#" class="feature-btn">Get Started <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Start Event
                ============================================= -->
        <div class="event-area de-pb">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
                        <div data-text="" class="site-title text-center">
                            <span class="sub-2">Khóa học mới</span>
                        </div>
                    </div>
                </div>
                <div class="event-area grid-2">
                    @foreach ($courses as $item)
                        <div class="event-box">
                            <div class="event-pic">
                                <img src="{{ asset('/user/img/event/event-1.jpg') }}" alt="thumb">
                                <div class="event-date">
                                    <p>27</p>
                                    <span>sep</span>
                                </div>
                            </div>
                            <div class="event-content">
                                <div class="event-meta">
                                    <p> Speaker: <span>Caron Simon</span></p>
                                    <p>{{ date('d-m-Y', strtotime($item->begin_date)); }} - {{ date('d-m-Y', strtotime($item->end_date)); }}</p>
                                </div>
                                <div class="event-desc">
                                    <h4>{{ $item->title }}</h4>
                                    <p class="desciption_course">
                                        {!! $item->description !!}
                                    </p>
                                    <div class="event-bottom">
                                        <a href="{{ route('detail', $item->slug) }}" class="event-btn">Vào khóa học</a>
                                        <div class="event-bottom-right">
                                            <i class="fas fa-ticket-alt"></i>
                                            <span>Available (179)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="more-btn">
                    <a href="{{ route('courses') }}" class="theme-btn">Xem tất cả</a>
                </div>
            </div>
        </div>




        <!-- Start Partner
                ============================================= -->
        <div class="partner-area bg-2 de-padding">
            <div class="container">
                <div class="partner-wrapper owl-carousel owl-theme">
                    <img src="{{ asset('/user/img/partner/brand-1.png') }}" alt="thumb">
                    <img src="{{ asset('/user/img/partner/brand-2.png') }}" alt="thumb">
                    <img src="{{ asset('/user/img/partner/brand-3.png') }}" alt="thumb">
                    <img src="{{ asset('/user/img/partner/brand-4.png') }}" alt="thumb">
                    <img src="{{ asset('/user/img/partner/brand-5.png') }}" alt="thumb">
                </div>
            </div>
        </div>
        <!-- End Partner-->



    </main>
@endsection
