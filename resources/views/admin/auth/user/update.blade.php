@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sửa user</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('users.update', $data->id) }}" method="post">
                            <input name="_method" type="hidden" value="PUT">
                            <div class="card-body">
                                {!! csrf_field() !!}
                                <div class="col-md-12">
                                    <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                                        <label for="first_name" class="control-label">Tên chính <span
                                                style="color: red">*</span></label>
                                        <input type="text" name="first_name" class="form-control input-sm"
                                            placeholder="Nhập tên..." value="{{ old('first_name') ?? $data->first_name }}"
                                            tabindex="1">
                                        {!! $errors->first('first_name', '<em for="first_name" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('last_name')) has-error @endif">
                                        <label for="last_name" class="control-label">Họ và tên đệm</label>
                                        <input type="text" name="last_name" class="form-control input-sm"
                                            placeholder="Nhập họ và tên đệm ..."
                                            value="{{ old('last_name') ?? $data->last_name }}" tabindex="2">
                                        {!! $errors->first('last_name', '<em for="last_name" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                                        <label for="email" class="control-label">Email <span
                                                style="color: red">*</span></label>
                                        <input type="text" name="email" class="form-control input-sm"
                                            placeholder="user@risetproduk.com" value="{{ old('email') ?? $data->email }}"
                                            tabindex="3">
                                        {!! $errors->first('email', '<em for="email" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                                        <label for="password" class="control-label">Mật khẩu </label>
                                        <input type="password" name="password" class="form-control input-sm" placeholder=""
                                            value="{{ $data->password }}" tabindex="5" disabled>
                                        {!! $errors->first('password', '<em for="password" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                                        <label for="password_confirmation" class="control-label">Nhập lại mật khẩu </label>
                                        <input type="password" name="password_confirmation" class="form-control input-sm"
                                            placeholder="Nhập lại mật khẩu..." value="{{ $data->password }}" disabled
                                            tabindex="6">
                                        {!! $errors->first('password', '<em for="password" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('phone')) has-error @endif">
                                        <label for="last_name" class="control-label">Phone</label>
                                        <input type="number" name="phone" class="form-control input-sm"
                                            placeholder="phone" value="{{ old('phone') ?? $data->phone }}" tabindex="2">
                                        {!! $errors->first('phone', '<em for="phone" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('role')) has-error @endif">
                                        <label for="role" class="control-label">Role - Phân quyền <span
                                                style="color: red">*</span></label>

                                        <select name="role" class="form-control" data-placeholder="Role - Phân quyền"
                                            tabindex="4">

                                            <option value="" {{ old('role') ? 'selected="selected"' : '' }}></option>
                                            @foreach ($roleDb as $role)
                                                @if (old('role') == $role->id || $userRole == $role->id)
                                                    <option value="{{ $role->id }}" selected="selected">
                                                        {{ $role->name }}</option>
                                                @else
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        {!! $errors->first('role', '<em for="ro,e" class="help-block" style="color: red">:message</em>') !!}

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="pull-right">
                                    <button type="submit" class="btn ladda-button btn-success btn-flat btn-sm"
                                        data-style="zoom-in">
                                        <span class="ladda-label"><i class="fa fa-save"></i> Cập nhật</span>
                                        <span class="ladda-spinner">
                                            <div class="ladda-progress" style="width: 0px;"></div>
                                        </span></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop
