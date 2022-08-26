@extends('layouts.app')
@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{route('login')}}"><b>Login</b></a>
        </div>

        <div class="register-box-body">

            @include('_alert')

            <p class="login-box-msg">Register a new membership</p>

            <form method="post" action="{{route('register.action')}}">
                {{csrf_field()}}

                <div class="mb-3">
                    <input type="text" name="first_name"
                    class="form-control @error('first_name') is-invalid @enderror"
                     placeholder="@lang('auth.form_user_fname_label')" value="{{old('first_name')}}">
                    @error('first_name')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="last_name"
                    class="form-control @error('last_name') is-invalid @enderror"
                    placeholder="@lang('auth.form_user_lname_label')" value="{{old('last_name')}}">
                    @error('last_name')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="@lang('auth.form_user_email_label')" value="{{old('email')}}">
                    @error('email')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    placeholder="Phone" value="{{old('phone')}}">
                    @error('phone')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="@lang('auth.form_user_password_label')">
                    @error('password')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="password" name="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    placeholder="@lang('auth.form_user_password_confirm_label')">
                    @error('password_confirmation')
                     <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-xs-8">&nbsp;</div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('auth.account_creation_register')</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div>

@stop
