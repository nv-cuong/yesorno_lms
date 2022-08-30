<header class="header header-3">
    <div class="main-navigation">
        <div class="navbar navbar-expand-lg bsnav bsnav-sticky bsnav-transparent bsnav-sticky-slide bsnav-scrollspy">
            <div class="header-top">
                <div class="container">
                    <div class="header-logo">
                        <a class="navbar-brand" href="index-2.html">
                            <img src="{{ asset('/user/img/logo/logo-3.png') }}" class="logo-display" alt="thumb">
                        </a>
                        <div class="f">
                            @if ($user = Sentinel::getUser())
                            <a href="{{ route('personal', $user->id) }}" class="d-inline bg-primary text-white" style="border-radius: 10px; padding: 6px 15px">Hello: {{ $user->first_name }}</a>
                            <a href="{{ route('logout') }}" class="d-inline p-3 bg-dark text-white" style="border-radius: 15px"><i class="fas fa-power-off"></i></a>
                            @else
                            <a href="{{ route('login') }}" class="d-inline p-2 bg-primary text-white">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="d-inline p-2 bg-dark text-white">Đăng ký</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="menu-bg hd">
                    <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse justify-content-sm-end">
                        <ul class="navbar-nav navbar-mobile mr-auto">
                            <li class="nav-item {{  url()->current() == route('home')  ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                            </li>
                            <li class="nav-item {{  url()->current() == route('courses')  ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('courses') }}">Khóa học</i></a>
                            </li>
                            <li class="nav-item"> <a class="nav-link" href="contact.html">Liên hệ</a></li>
                            <li class="nav-item"> <a class="nav-link" href="contact.html"><i class="far fa-bell"></i>
                                    Thông báo(0) </a></li>

                            <form class="form-inline" style="padding-left: 100px">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" class="form-control" id="" placeholder="" style="width: 200px">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2"><i
                                        class="fas fa-search"></i></button>
                            </form>
                        </ul>

                    </div>
                    <div class="header-3-bt">
                        @if ($user = Sentinel::getUser())
                        <a href="{{ route('personal', $user->id) }}" class="header-3-btn">Khóa học của tôi</a>
                        @else
                        <a class="header-3-btn">Khóa học của tôi</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="bsnav-mobile">
            <div class="bsnav-mobile-overlay"></div>
            <div class="navbar"></div>
        </div>
    </div>
</header>
