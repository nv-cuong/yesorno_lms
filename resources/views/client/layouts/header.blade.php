<header class="header header-3">
    <div class="main-navigation">
        <div class="navbar navbar-expand-lg bsnav bsnav-sticky bsnav-transparent bsnav-sticky-slide bsnav-scrollspy">
            <div class="header-top">
                <div class="container">
                    <div class="header-logo">
                        <a class="navbar-brand" href="{{ route('home')}}">
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
                            <li class="nav-item {{  url()->current() == route('contact')  ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('contact') }}">Liên hệ</a></li>
                            <li class="nav-item"> <a class="nav-link" href="#"><i class="far fa-bell"></i>
                                    Thông báo(0) </a></li>

                            <form class="form-inline" style="padding-left: 100px" action="{{ route('search')}}" method="GET">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" class="form-control input_search" name="keyword" style="width: 200px; font-size: 13px" placeholder="Tên khóa học">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i></button>
                                <div class="search_results" id="search_results">

                                </div>
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
@push('scripts')
<script>
    $('.input_search').keyup(function() {
        var _text = $(this).val();

        if (_text != '') {
            $.ajax({
                url: "{{ route('live.search') }}?key=" + _text
                , type: 'GET'
                , success: function(data) {
                    var _html = '';
                    _html += '<div class="search_main">';
                    _html += '<ul>';
                    for (var course of data) {
                        _html += '<li>';
                        _html += '<a href="{{route('detail', '')}}/'+course.slug+'"><img src="http://127.0.0.1:8000/'+ course.image +'"> ' + course.title + '</a>';
                        _html += '<hr>';
                        _html += '</li>';
                    }
                    _html += '</ul>';
                    _html += '</div>';
                    $('.search_results').html(_html)
                }
            });
        }else{
            $('.search_results').html('')
        }
    })
</script>
@endpush
