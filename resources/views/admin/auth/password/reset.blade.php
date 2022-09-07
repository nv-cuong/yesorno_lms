<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Forgot Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">@include('admin._alert')</p>

      <form method="POST" action="{{ route('resetPassword.action', [request('userId'), request('code')]) }}">
                {{ csrf_field() }}

                <div class="mb-3 input-group">
                    <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="@lang('auth.form_user_password_label')">
                    @error('password')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 input-group">
                    <input type="password" name="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    placeholder="@lang('auth.form_user_password_confirm_label')">
                    @error('password_confirmation')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Reset mật khẩu</button>
          </div>
          <!-- /.col -->
        </div>
            </form>

      <p class="mt-3 mb-1">
        <a href="{{route('login.form')}}">Đăng nhập</a>
      </p>
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
