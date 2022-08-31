@extends('client.layouts.master')
@section('title', 'Gửi liên hệ')

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
     <!-- Start Contact
                ============================================= -->
                <div class="cta-area cta-3  de-padding" id="contact">
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

@endsection
