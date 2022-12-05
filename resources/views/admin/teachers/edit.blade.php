@extends('admin.layouts.master')
@section('title', 'Giảng viên')

@section('content')
<div class="container-fluid" style="padding-top: 30px">
    <div class="animated fadeIn">
        <div class="content-header">
        </div>
        <form class="form-horizontal" method="POST" action="{{ route('teacher.update', [$teacher->id]) }}">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="page-title d-inline">Sửa thông tin giảng viên</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="stu_id">Mã giảng viên</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('stu_id') is-invalid @enderror" type="text"
                                        name="stu_id" id="stu_id" value="{{ old('stu_id') ?: $teacher->stu_id }}"
                                        placeholder="Nhập mã giảng viên">
                                    @error('stu_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="first_name">Họ và tên đệm</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                        name="first_name" id="first_name"
                                        value="{{ old('first_name') ?: $teacher->first_name }}" placeholder="Họ"
                                        maxlength="191" autofocus="">
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="last_name">Tên học viên</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('last_name') is-invalid @enderror" type="text"
                                        name="last_name" id="last_name"
                                        value="{{ old('last_name') ?: $teacher->last_name }}" placeholder="Tên"
                                        maxlength="191">
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="email">Email</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" id="email" value="{{ $teacher->email }}"
                                        placeholder="Địa chỉ email" maxlength="191" readonly="1">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="gender">Giới tính</label>
                                <div class="col-md-10  @error('gender') is-invalid @enderror">
                                    <input type="radio" name="gender" value="male"
                                        {{ (old('gender') ?: $teacher->gender) == 'male' ? 'checked' : '' }}> Nam
                                    <input type="radio" name="gender" value="female" style="margin-left:10px"
                                        {{ (old('gender') ?: $teacher->gender) == 'female' ? 'checked' : '' }}> Nữ
                                    <input type="radio" name="gender" value="Other" style="margin-left:10px"
                                        {{ (old('gender') ?: $teacher->gender) == 'other' ? 'checked' : '' }}> Khác
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="phone">Số điện thoại</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                        name="phone" id="phone" value="{{ old('phone') ?: $teacher->phone }}"
                                        placeholder="Số điện thoại" maxlength="12">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="address">Địa chỉ</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('address') is-invalid @enderror" type="text"
                                        name="address" id="address" value="{{ old('address') ?: $teacher->address }}"
                                        placeholder="Địa chỉ" maxlength="12">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="birthday">Ngày sinh</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('birthday') is-invalid @enderror" type="date"
                                        name="birthday" id="birthday"
                                        value="{{ old('birthday') ?: $teacher->birthday }}" placeholder="Ngày sinh"
                                        maxlength="191">
                                    @error('birthday')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="age">Tuổi</label>
                                <div class="col-md-10">
                                    <p class="form-control" type="age" name="age" id="age"
                                        placeholder="Tuổi" maxlength="3" readonly="1">
                                        {{ old('age') ?: $teacher->age }}</p>
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-4">
                                    <a class="btn btn-danger" href="">Quay lại</a>
                                    <button class="btn btn-success pull-right" type="submit">Cập nhật</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop