@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Thêm học người dùng</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        @include('admin/_alert')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thêm mới người dùng</h3>
                        </div>

                        <form action="{{ route('users.store') }}" method="post">
                            <div class="card-body">
                                {!! csrf_field() !!}

                                <div class="col-md-12">
                                    <div class="form-group @if ($errors->has('stu_id')) has-error @endif">
                                        <label for="name" class="control-label">Mã người dùng<span
                                                style="color: red">*</span></label>
                                        <input type="text" name="stu_id" class="form-control input-sm"
                                            placeholder="Nhập mã người dùng" value="{{ old('stu_id') }}" tabindex="1">
                                        {!! $errors->first('stu_id', '<em for="stu_id" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                                        <label for="name" class="control-label">Tên người dùng<span
                                                style="color: red">*</span></label>
                                        <input type="text" name="first_name" class="form-control input-sm"
                                            placeholder="Nhập tên" value="{{ old('first_name') }}" tabindex="1">
                                        {!! $errors->first('first_name', '<em for="first_name" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('last_name')) has-error @endif">
                                        <label for="name" class="control-label">Họ và tên đệm <span
                                                style="color: red">*</span></label>
                                        <input type="text" name="last_name" class="form-control input-sm"
                                            placeholder="Nhập họ và tên đệm" value="{{ old('last_name') }}" tabindex="1">
                                        {!! $errors->first('last_name', '<em for="last_name" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                                        <label for="email" class="control-label">Email <span
                                                style="color: red">*</span></label>
                                        <input type="text" name="email" class="form-control input-sm"
                                            placeholder="user@gmail.com" value="{{ old('email') }}" tabindex="3">
                                        {!! $errors->first('email', '<em for="email" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                                        <label for="password" class="control-label">Mật khẩu <span
                                                style="color: red">*</span></label>
                                        <input type="password" name="password" class="form-control input-sm"
                                            placeholder="Mật khẩu phải từ 8 ký tự trở lên" value="{{ old('password') }}"
                                            tabindex="5">
                                        {!! $errors->first('password', '<em for="password" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                                        <label for="password_confirmation" class="control-label">Xác nhận lại mật khẩu <span
                                                style="color: red">*</span></label>
                                        <input type="password" name="password_confirmation" class="form-control input-sm"
                                            placeholder="..." value="{{ old('password_confirmation') }}" tabindex="6">
                                        {!! $errors->first('password', '<em for="password" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('phone')) has-error @endif">
                                        <label for="name" class="control-label">Số điện thoại <span
                                                style="color: red">*</span></label>
                                        <input type="number" name="phone" class="form-control input-sm"
                                            placeholder="Nhập số điện thoại" value="{{ old('phone') }}" tabindex="1">
                                        {!! $errors->first('phone', '<em for="phone" class="help-block " style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('role')) has-error @endif">
                                        <label for="role" class="control-label">Phân quyền<span
                                                style="color: red">*</span></label>
                                        @foreach ($roleDb as $role)
                                        <div class="form-check">
                                            <input class="form-check-input @error('role') is-invalid @enderror" type="checkbox" id="vehicle1"
                                                name="role[]" value="{{ $role->id }}"
                                                @if (old('role') == $role->id)
                                                        checked
                                                    @endif>
                                            <label class="form-check-label">{{ $role->name }}</label>
                                        </div>
                                        @endforeach

                                        {!! $errors->first('role', '<em for="role" class="help-block" style="color: red">:message</em>') !!}
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-flat ladda-button btn-success btn-sm"
                                            data-style="zoom-in">
                                            <span class="ladda-label"><i class="fa fa-save"></i> Lưu</span>
                                            <span class="ladda-spinner">
                                                <div class="ladda-progress" style="width: 0px;"></div>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>


                </div>

            </div>
        </div>
    </section>
@stop
