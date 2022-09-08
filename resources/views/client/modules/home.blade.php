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
                                        <a href="{{ route('courses') }}" class="theme-btn">Bắt đầu học<i class="ti ti-arrow-right"></i></a>
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
                                <img src="{{ asset($item->image) }}" alt="thumb">
                            </div>
                            <div class="event-content">
                                <div class="event-meta">
                                    <p></p>
                                    <p>{{ date('d-m-Y', strtotime($item->begin_date)) }} - {{ date('d-m-Y', strtotime($item->end_date)) }}</p>
                                </div>
                                <div class="event-desc">
                                    <h4>{{ $item->title }}</h4>
                                    <div class="desciption_course">
                                        {!! $item->description !!}
                                    </div>
                                    <div class="event-bottom">
                                        <a href="{{ route('detail', $item->slug) }}" class="event-btn">Vào khóa học</a>
                                        <div class="event-bottom-right">
                                            <i class="fas fa-users"></i>
                                            <span>Học viên ({{ $item->users()->count() }})</span>
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
    </main>
@endsection
