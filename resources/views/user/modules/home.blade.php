@extends('user.layouts.master')
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
                                        <a href="#" class="theme-btn">Start <i class="ti ti-arrow-right"></i></a>
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
                <span> Tiến độ các khóa học</span>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0"
                        aria-valuemax="100">25%</div>
                </div>
                <br>
            </div>
        </div>

        <!-- Start Counter
                ============================================= -->
        <div class="counter-area counter-3 de-padding">

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
                                    <p>8:00 - 16:00 California, NY 70240</p>
                                </div>
                                <div class="event-desc">
                                    <h4>Build your dream Engineering career-2020</h4>
                                    <p>
                                        Inceptos habitant excepturi do rerum dignissim consequuntur assumenda aliqua
                                        tristique
                                        unde cursus aute torquent eros quis! Fames aliquip! Eius aspernatur, debitis error
                                        omnis
                                        iste ultrices massa
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
        <!-- End Event -->


        <!-- Start Blog
                ============================================= -->
        <div class="wh-area blog-area de-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
                        <div data-text="" class="site-title text-center">
                            <span class="sub-2">What's update now</span>
                        </div>
                    </div>
                </div>
                <div class="wh-wrapper owl-carousel owl-theme">
                    <div class="wh-box">
                        <div class="wh-pic blog-img">
                            <img src="{{ asset('/user/img/choose/ch-1.jpg') }}" alt="thumb">
                            <div class="blog-date">
                                <div class="blog-date-info">
                                    <p>23 <span>sep</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="wh-content">
                            <div class="wh-cate">
                                <span>Categories:Education,Certificate</span>
                            </div>
                            <h6>Admit us here. You know the world, you know the society</h6>
                        </div>
                    </div>
                    <div class="wh-box">
                        <div class="wh-pic blog-img">
                            <img src="{{ asset('/user/img/choose/ch-2.jpg') }}" alt="thumb">
                            <div class="blog-date">
                                <div class="blog-date-info">
                                    <p>23 <span>sep</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="wh-content">
                            <div class="wh-cate">
                                <span>Categories:Education,Certificate</span>
                            </div>
                            <h6>Admit us here. You know the world, you know the society</h6>
                        </div>
                    </div>
                    <div class="wh-box">
                        <div class="wh-pic blog-img">
                            <img src="{{ asset('/user/img/choose/ch-3.jpg') }}" alt="thumb">
                            <div class="blog-date">
                                <div class="blog-date-info">
                                    <p>23 <span>sep</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="wh-content">
                            <div class="wh-cate">
                                <span>Categories:Education,Certificate</span>
                            </div>
                            <h6>Admit us here. You know the world, you know the society</h6>
                        </div>
                    </div>
                    <div class="wh-box">
                        <div class="wh-pic blog-img">
                            <img src="{{ asset('/user/img/choose/ch-1.jpg') }}" alt="thumb">
                            <div class="blog-date">
                                <div class="blog-date-info">
                                    <p>23 <span>sep</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="wh-content">
                            <div class="wh-cate">
                                <span>Categories:Education,Certificate</span>
                            </div>
                            <h6>Admit us here. You know the world, you know the society</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Blog-->

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
                    <img src="{{ asset('/user/img/partner/brand-2.png') }}" alt="thumb">
                    <img src="{{ asset('/user/img/partner/brand-1.png') }}" alt="thumb">
                </div>
            </div>
        </div>
        <!-- End Partner-->

        <!-- Start Contact
                ============================================= -->
        <div class="cta-area cta-3  de-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
                        <div data-text="" class="site-title text-center">
                            <span class="sub-2">What's update now?</span>
                            <h2>Have any questions? Get in touch</h2>
                        </div>
                    </div>
                </div>
                <div class="cta-wrapper grid-2">
                    <div class="cta-left" style="background: url({{ asset('/user/img/footer/contact-left-bg.png') }})">
                        <h2>Get in touch for any questions?</h2>
                        <div class="cta-left-wrap">
                            <div class="cta-left-single">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="cta-left-single-txt">
                                    <h5>Head office</h5>
                                    <span>454 read, 36 Floor New York, USA</span>
                                </div>
                            </div>
                            <div class="cta-left-single">
                                <i class="fas fa-phone-volume"></i>
                                <div class="cta-left-single-txt">
                                    <h5>Call Us Direct</h5>
                                    <span>+190-96963369</span>
                                </div>
                            </div>
                            <div class="cta-left-single">
                                <i class="fas fa-envelope"></i>
                                <div class="cta-left-single-txt">
                                    <h5>Email Us</h5>
                                    <span>info@support.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-right">
                        <div class="contact-inputs">
                            <form class="contact-form" method="post"
                                action="https://siteforest.tech/templatebucket/lasson/assets/mail/contact.php">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text" class="form-control" name="name" id="name">
                                            <span class="alert alert-error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" name="email" id="email">
                                            <span class="alert alert-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comments">Write Something</label>
                                            <textarea class="form-control" id="comments" name="comments" rows="5"></textarea>
                                        </div>
                                        <button type="submit" name="submit" id="submit">
                                            Send your Message
                                        </button>
                                        <!-- Alert Message -->
                                        <div class="alert-notification">
                                            <div id="message" class="alert-msg"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact -->

    </main>
@endsection
