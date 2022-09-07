<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Team 5 | Đăng kí thành viên</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">

    <body class="register-page" style="min-height: 570.8px;">
        <div class="register-box">
            <div class="register-logo">
                <img class="mb-4" src="https://co-well.vn/wp-content/themes/cowell/assets/img/logo-1.png" alt="" width="auto" height="60">
            </div>
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Đăng ký thành viên mới </p>
                    <p class="login-box-msg">@include('admin._alert')</p>
                    <form action="{{ route('register.action') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                            placeholder="Tên" name="first_name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                            placeholder="Họ" name="last_name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="E-mail" name="email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Mật khẩu" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="Xác nhận mật khẩu" name="password_confirmation">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="agreeTerms">
                                    <label for="agreeTerms">
                                        Tôi đồng ý <a href="#"> điều khoản</a>
                                    </label>
                                </div>
                            </div>

                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Đăng kí</button>
                            </div>

                        </div>
                    </form>
                    <div class="social-auth-links text-center">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i>
                            Đăng nhập với Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i>
                            Đăng nhập với Google+
                        </a>
                    </div>
                    <a href="{{ route('login.form') }}" class="text-center">Tôi đã có tài khoản</a>
                </div>

            </div>
        </div>



        <!-- jQuery -->
        <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
    </body>

</html>
