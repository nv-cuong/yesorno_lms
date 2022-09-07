@extends('client.layouts.master')
@section('title', 'Gửi liên hệ')

@section('content')

    <div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }})">
        <div class="breadcrumb-circle">
            <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
        </div>
        <div class="container">
            <h2 class="breadcrumb-title">Liên hệ</h2>
            <ul class="breadcrumb-menu clearfix">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="active">Tôi</li>
            </ul>
        </div>
    </div>
                <div class="cta-area cta-3  de-padding" id="contact">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 offset-xl-2">
                                <div data-text="" class="site-title text-center">
                                    <span class="sub-2">Có gì mới</span>
                                    <h2>Bạn có câu hỏi? Hãy liên lạc với chúng tôi</h2>
                                </div>
                            </div>
                        </div>
                        <div class="cta-wrapper grid-2">
                            <div class="cta-left" style="background: url({{ asset('/user/img/footer/contact-left-bg.png') }})">
                                <h2>Giải đáp mọi thắc mắc</h2>
                                <div class="cta-left-wrap">
                                    <div class="cta-left-single">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <div class="cta-left-single-txt">
                                            <h5>Trụ sở chính</h5>
                                            <span>Tòa nhà 3D, Số 3 Duy Tân, Quận Cầu Giấy, Hà Nội</span>
                                        </div>
                                    </div>
                                    <div class="cta-left-single">
                                        <i class="fas fa-phone-volume"></i>
                                        <div class="cta-left-single-txt">
                                            <h5>Số điện thoại</h5>
                                            <span>(+84) 24 6297 3538</span>
                                        </div>
                                    </div>
                                    <div class="cta-left-single">
                                        <i class="fas fa-envelope"></i>
                                        <div class="cta-left-single-txt">
                                            <h5>Email</h5>
                                            <span>info@co-well.vn</span>
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
                                                    <label for="name">Họ và tên</label>
                                                    <input type="text" class="form-control" name="name" id="name">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Địa chỉ email</label>
                                                    <input type="email" class="form-control" name="email" id="email">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="comments">Khác</label>
                                                    <textarea class="form-control" id="comments" name="comments" rows="5"></textarea>
                                                </div>
                                                <button type="submit" name="submit" id="submit">
                                                    Gửi tin nhắn
                                                </button>
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
@endsection
