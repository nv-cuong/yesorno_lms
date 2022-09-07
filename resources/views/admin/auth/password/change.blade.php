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
    <a href=""><b>Admin</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">@include('admin._alert')</p>

      <form method="POST" action="{{ route('changePassword.action') }}">
                    <div class="card-body">
                        {{ csrf_field() }}

                        
                        <div class="form-group">
                    <label for="exampleInputEmail1">Mật khẩu cũ<span style="color: red">*</span></label>
                    <input type="password" name="old_password" id="old_password"
                                 
                    class="form-control @error('old_password') is-invalid @enderror" 
                    value="{{old('old_password')}}" placeholder="old_password">
                    @error('old_password')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mật khẩu mới<span style="color: red">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                     value="{{ old('password') }}" placeholder="password">
                    @error('password')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Xác nhận mật khẩu<span style="color: red">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                    id="exampleInputEmail1" placeholder="password_confirmation" value="{{ old('password_confirmation') }}">
                    @error('password_confirmation')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                            

                        
                    </div>

                    <div class="card-footer">
                        

                        <div class="pull-right">
                            <button type="submit" class="btn ladda-button btn-success btn-sm" data-style="zoom-in">
                                <span class="ladda-label"><i class="fa fa-save"></i> @lang('auth.change_password_submit_btn')</span>
                                <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span>
                            </button>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                </form>

    
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
