@extends('admin.layouts.master')
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
                            @method('PUT')
                            <div class="card-body">
                                {!! csrf_field() !!}
                                <div class="col-md-12">
                                    <div class="form-group @if ($errors->has('stu_id')) has-error @endif">
                                        <label for="stu_id" class="control-label">Mã người dùng <span
                                                style="color: red">*</span></label>
                                        <input type="text" name="stu_id" class="form-control input-sm"
                                            placeholder="Nhập mã người dùng" value="{{ old('stu_id') ?? $data->stu_id }}"
                                            tabindex="1">
                                        {!! $errors->first('stu_id', '<em for="stu_id" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

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

                                    <div class="form-group @if ($errors->has('phone')) has-error @endif">
                                        <label for="last_name" class="control-label">Phone</label>
                                        <input type="number" name="phone" class="form-control input-sm"
                                            placeholder="phone" value="{{ old('phone') ?? $data->phone }}" tabindex="2">
                                        {!! $errors->first('phone', '<em for="phone" class="help-block" style="color: red">:message</em>') !!}
                                    </div>

                                    <div class="form-group @if ($errors->has('role')) has-error @endif">
                                        <label for="role" class="control-label">Phân quyền <span
                                                style="color: red">*</span></label>
                                        @foreach ($roleDb as $role)
                                        <div class="form-check">
                                            <input class="form-check-input @error('role') is-invalid @enderror" type="checkbox" id="vehicle1"
                                                name="role[]" value="{{ $role->id }}"
                                                @foreach($userRoles as $userRole)
                                                @if (old('role') == $role->id || $userRole->id == $role->id)
                                                    checked
                                                @endif @endforeach>
                                            <label class="form-check-label">{{ $role->name }}</label>
                                        </div>
                                        @endforeach

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
