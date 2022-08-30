@extends('user.layouts.master')
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
                    <div class="course-left-box category">
                        <a href="#">Computer science</a>
                        <a href="#">Artificial intelligence</a>
                        <a href="#">Architecture</a>
                        <a href="#">Health &amp; Fitness</a>
                        <a href="#">Analysis of Algorithms</a>
                    </div>
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
                            <ul>
                                <li>
                                    <div class="course-syl-author-wrp d-bio">
                                        <img src="{{ asset('/user/img/singlepost/post-3.png') }}" alt="thumb">
                                        <div class="course-syl-bio">
                                            <p>Author: </p>
                                            <span>MD. Malino Masker</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="course-syl-author-wrp d-bio">
                                        <div class="course-syl-bio">
                                            <p>Category: </p>
                                            <span> JavaScript development </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="course-syl-author-wrp d-bio">
                                        <div class="course-syl-bio">
                                            <p>Reviews: </p>
                                            <div class="course-syl-rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <span>(35k)</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="course-syl-price cr-mb">
                            <ul>
                                <li>
                                    <p><i class="fas fa-user"></i>Enrolled students 564</p>
                                </li>
                                <li>
                                    <p><i class="fas fa-user"></i>Enrolled students 564</p>
                                </li>
                                <li>
                                    <p class="value"> <b>Price:</b>$180.00</p>
                                </li>
                                <li><a href="#" class="theme-btn">Enroll Now </a></li>
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
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                        role="tab" aria-controls="nav-home" aria-selected="true">
                                        Description
                                    </a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                        role="tab" aria-controls="nav-profile" aria-selected="false">
                                        Syllabus
                                    </a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                        role="tab" aria-controls="nav-contact" aria-selected="false">
                                        Reviews
                                    </a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class="course-syl-con">
                                        <div class="course-syl-con-header">
                                            {!! $course->description !!}
                                        </div>
                                        <div class="course-syl-con-bottom">
                                            <ul class="course-li-1">
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteur cillum hic cum labore cenas.
                                                        Invent
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteur cillum hic cum labore cenas.
                                                        Invent
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteur cillum hic cum labore cenas.
                                                        Invent
                                                    </span>
                                                </li>
                                            </ul>
                                            <div class="course-syl-imgs mt-40 grid-2">
                                                <img src="{{ asset('/user/img/details-page/img-1.jpg') }}" alt="thumb">
                                                <img src="{{ asset('/user/img/details-page/img-2.jpg') }}"
                                                    alt="thumb">
                                            </div>
                                            <div class="course-syl-text mt-40">
                                                <p>
                                                    Perferendis lacinia non, est distinctio ut eveniet, posuere mus nostrum
                                                    eget itaque, irure illo leo. Est! Numquam autem ipsa! Dolores eiusmod,
                                                    impedit bibendum porro! Error! Magna quia. Quia officia non? Lectus
                                                    corporis laudantium cursus voluptas eveniet
                                                </p>
                                                <p class="mb-0">
                                                    Perferendis, voluptatum. Exercitation justo aliquip? Convallis ligula
                                                    aptent aute ab? Sit necessitatibus error, quaerat curae tristique
                                                    tempore velit, nascetur ullam metus molestie, etiam sapien cupiditate
                                                    magni do ut, consequuntur doloribus ea fusce recusandae eros, minim
                                                    dolore magnis
                                                </p>
                                            </div>
                                            <ul class="course-li-1 li-2 mt-30 mb-30">
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteu
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteu
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteu
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteu
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteu
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <span>
                                                        Fugiat suspendisse maxime excepteu
                                                    </span>
                                                </li>
                                            </ul>
                                            <p class="mb-0">
                                                Perferendis lacinia non, est distinctio ut eveniet, posuere mus nostrum eget
                                                itaque, irure illo leo. Est! Numquam autem ipsa! Dolores eiusmod, impedit
                                                bibendum porro! Error! Magna quia. Quia officia non? Lectus corporis
                                                laudantium cursus voluptas eveniet
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="course-accordion">
                                        <div class="course-accordion-header mb-30">
                                            <h2 class="course-content-title">Course Tutorials</h2>
                                            <p class="mb-0">
                                                lacing assured be if removed it besides on. Far shed each high read are men
                                                over day. Afraid we praise lively he suffer family estate is. Ample order up
                                                in of in ready. Timed blind had now those ought set often which. Or snug
                                                dull he show more true wish. No at many deny away miss evil. On in so indeed
                                                spirit an mother. Amounted old strictly but marianne admitted. People former
                                                is remove remain as.
                                            </p>
                                        </div>
                                        <div class="ask">
                                            <div class="panel-group" id="accordion" role="tablist"
                                                aria-multiselectable="true">
                                                <div class="panel panel-default panel-active">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse"
                                                                data-parent="#accordion" href="#collapseOne"
                                                                aria-expanded="false" aria-controls="collapseOne"
                                                                class="collapsed">
                                                                Data Science Introduction
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse in collapse"
                                                        role="tabpanel" aria-labelledby="headingOne" style="">
                                                        <div class="panel-body">
                                                            <ul class="course-video-list">
                                                                <li>
                                                                    <div class="course-video-wrp">
                                                                        <div class="course-item-name">
                                                                            <div>
                                                                                <i class="fas fa-play"></i>
                                                                                <span>Lecture 1.1</span>
                                                                            </div>
                                                                            <h5>Overview Of Course</h5>
                                                                        </div>
                                                                        <div class="course-time-preview">
                                                                            <div class="course-item-info">
                                                                                <span>Duration: 5 min</span>
                                                                                <a href="#">Preview</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="course-video-wrp">
                                                                        <div class="course-item-name">
                                                                            <div>
                                                                                <i class="fas fa-play"></i>
                                                                                <span>Lecture 1.1</span>
                                                                            </div>
                                                                            <h5>Basic Enviroment Setup</h5>
                                                                        </div>
                                                                        <div class="course-time-preview">
                                                                            <div class="course-item-info">
                                                                                <span>Duration: 1 hours 30 min</span>
                                                                                <a href="#">Preview</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse"
                                                                data-parent="#accordion" href="#collapseTwo"
                                                                aria-expanded="false" aria-controls="collapseTwo"
                                                                class="collapsed">
                                                                The Way of work
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseTwo" class="panel-collapse in collapse"
                                                        role="tabpanel" aria-labelledby="headingTwo" style="">
                                                        <div class="panel-body">
                                                            <ul class="course-video-list">
                                                                <li>
                                                                    <div class="course-video-wrp">
                                                                        <div class="course-item-name">
                                                                            <div>
                                                                                <i class="fas fa-play"></i>
                                                                                <span>Lecture 1.1</span>
                                                                            </div>
                                                                            <h5>Overview Of Course</h5>
                                                                        </div>
                                                                        <div class="course-time-preview">
                                                                            <div class="course-item-info">
                                                                                <span>Duration: 5 min</span>
                                                                                <a href="#">Preview</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="course-video-wrp">
                                                                        <div class="course-item-name">
                                                                            <div>
                                                                                <i class="fas fa-play"></i>
                                                                                <span>Lecture 1.1</span>
                                                                            </div>
                                                                            <h5>Basic Enviroment Setup</h5>
                                                                        </div>
                                                                        <div class="course-time-preview">
                                                                            <div class="course-item-info">
                                                                                <span>Duration: 1 hours 30 min</span>
                                                                                <a href="#">Preview</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="heading3">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse"
                                                                data-parent="#accordion" href="#collapse3"
                                                                aria-expanded="false" aria-controls="collapse3"
                                                                class="collapsed">
                                                                Beginning the first Project
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse3" class="panel-collapse in collapse"
                                                        role="tabpanel" aria-labelledby="heading3" style="">
                                                        <div class="panel-body">
                                                            <ul class="course-video-list">
                                                                <li>
                                                                    <div class="course-video-wrp">
                                                                        <div class="course-item-name">
                                                                            <div>
                                                                                <i class="fas fa-play"></i>
                                                                                <span>Lecture 1.1</span>
                                                                            </div>
                                                                            <h5>Overview Of Course</h5>
                                                                        </div>
                                                                        <div class="course-time-preview">
                                                                            <div class="course-item-info">
                                                                                <span>Duration: 5 min</span>
                                                                                <a href="#">Preview</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="course-video-wrp">
                                                                        <div class="course-item-name">
                                                                            <div>
                                                                                <i class="fas fa-play"></i>
                                                                                <span>Lecture 1.1</span>
                                                                            </div>
                                                                            <h5>Basic Enviroment Setup</h5>
                                                                        </div>
                                                                        <div class="course-time-preview">
                                                                            <div class="course-item-info">
                                                                                <span>Duration: 1 hours 30 min</span>
                                                                                <a href="#">Preview</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="heading4">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse"
                                                                data-parent="#accordion" href="#collapse4"
                                                                aria-expanded="false" aria-controls="collapse4"
                                                                class="collapsed">
                                                                Initial Setup of Second Project
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse4" class="panel-collapse in collapse"
                                                        role="tabpanel" aria-labelledby="heading4" style="">
                                                        <div class="panel-body">
                                                            <ul class="course-video-list">
                                                                <li>
                                                                    <div class="course-video-wrp">
                                                                        <div class="course-item-name">
                                                                            <div>
                                                                                <i class="fas fa-play"></i>
                                                                                <span>Lecture 1.1</span>
                                                                            </div>
                                                                            <h5>Overview Of Course</h5>
                                                                        </div>
                                                                        <div class="course-time-preview">
                                                                            <div class="course-item-info">
                                                                                <span>Duration: 5 min</span>
                                                                                <a href="#">Preview</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="course-video-wrp">
                                                                        <div class="course-item-name">
                                                                            <div>
                                                                                <i class="fas fa-play"></i>
                                                                                <span>Lecture 1.1</span>
                                                                            </div>
                                                                            <h5>Basic Enviroment Setup</h5>
                                                                        </div>
                                                                        <div class="course-time-preview">
                                                                            <div class="course-item-info">
                                                                                <span>Duration: 1 hours 30 min</span>
                                                                                <a href="#">Preview</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--panel-group-->
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <div class="course-ovr-wrp">
                                        <div class="course-over-fet">
                                            <div class="course-over-bio">
                                                <img src="{{ asset('/user/img/singlepost/post-1.png') }}" alt="thumb">
                                                <div class="course-over-name">
                                                    <h5>Nurani Khanom</h5>
                                                    <h6>Student</h6>
                                                    <div class="course-over-rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <span>(4.5)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-0">
                                                Scarcely on striking packages by so property in delicate. Up or well must
                                                less rent read walk so be. Easy sold at do hour sing spot. Any meant has
                                                cease too the decay. Since party burst am it match. By or blushes between
                                                besides offices noisier as. Sending do brought winding compass in.
                                            </p>
                                        </div>
                                        <div class="single-comments-section">
                                            <h2 class="single-content-title">Comments</h2>
                                            <div class="single-commentor">
                                                <ul>
                                                    <li>
                                                        <div class="single-commentor-user">
                                                            <img src="{{ asset('/user/img/singlepost/post-2.png') }}"
                                                                alt="thumb">
                                                            <div class="single-commentor-user-bio">
                                                                <div class="single-commentor-user-bio-head">
                                                                    <h6>Diego Fou
                                                                        <span class="course-over-rating">
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <b>(4.5)</b>
                                                                        </span>
                                                                    </h6>
                                                                </div>
                                                                <p>
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                    elit, sed do eiusmod tempor incididunt utx gh labore et
                                                                    dolor magna ali Ut enim ad minim veniam, quis nostrud
                                                                    exercitation .
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="single-commentor-user">
                                                            <img src="{{ asset('/user/img/singlepost/post-3.png') }}"
                                                                alt="thumb">
                                                            <div class="single-commentor-user-bio">
                                                                <div class="single-commentor-user-bio-head">
                                                                    <h6>Diego Fou
                                                                        <span class="course-over-rating">
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <b>(4.5)</b>
                                                                        </span>
                                                                    </h6>
                                                                </div>
                                                                <p>
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                    elit, sed do eiusmod tempor incididunt utx gh labore et
                                                                    dolor magna ali Ut enim ad minim veniam, quis nostrud
                                                                    exercitation .
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="single-commentor-user">
                                                            <img src="{{ asset('/user/img/singlepost/post-4.png') }}"
                                                                alt="thumb">
                                                            <div class="single-commentor-user-bio">
                                                                <div class="single-commentor-user-bio-head">
                                                                    <h6>Diego Fou
                                                                        <span class="course-over-rating">
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <i class="fas fa-star"></i>
                                                                            <b>(4.5)</b>
                                                                        </span>
                                                                    </h6>
                                                                </div>
                                                                <p>
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                    elit, sed do eiusmod tempor incididunt utx gh labore et
                                                                    dolor magna ali Ut enim ad minim veniam, quis nostrud
                                                                    exercitation .
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="single-comments-section-form">
                                                <h2 class="single-content-title">Leave a Reply</h2>
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Your Name*">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="email" class="form-control"
                                                                    placeholder="Your Email*">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" placeholder="Your Comment*"></textarea>
                                                            </div>
                                                            <button type="submit">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
