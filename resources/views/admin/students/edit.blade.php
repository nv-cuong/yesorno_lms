@extends('admin.layouts.master')
@section('title', 'Học viên')

@section('content')
    <div class="container-fluid" style="padding-top: 30px">
        <div class="animated fadeIn">
            <div class="content-header">
            </div>
            <form class="form-horizontal" method="POST" action="{{ route('student.update', [$student->id]) }}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="page-title d-inline">Sửa thông tin học viên</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="stu_id">Mã học viên</label>
                                    <div class="col-md-10">
                                        <input class="form-control @error('stu_id') is-invalid @enderror" type="text"
                                            name="stu_id" id="stu_id" value="{{ old('stu_id') ?: $student->stu_id }}"
                                            placeholder="Nhập mã học viên">
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
                                            value="{{ old('first_name') ?: $student->first_name }}" placeholder="Họ"
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
                                            value="{{ old('last_name') ?: $student->last_name }}" placeholder="Tên"
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
                                            name="email" id="email" value="{{ $student->email }}"
                                            placeholder="Địa chỉ email" maxlength="191" readonly="1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="gender">Giới tính</label>
                                    <div class="col-md-10  @error('gender') is-invalid @enderror">
                                        <input type="radio" name="gender" value="male"
                                            {{ (old('gender') ?: $student->gender) == 'male' ? 'checked' : '' }}> Nam
                                        <input type="radio" name="gender" value="female" style="margin-left:10px"
                                            {{ (old('gender') ?: $student->gender) == 'female' ? 'checked' : '' }}> Nữ
                                        <input type="radio" name="gender" value="Other" style="margin-left:10px"
                                            {{ (old('gender') ?: $student->gender) == 'other' ? 'checked' : '' }}> Khác
                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="phone">Số điện thoại</label>
                                    <div class="col-md-10">
                                        <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                            name="phone" id="phone" value="{{ old('phone') ?: $student->phone }}"
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
                                            name="address" id="address" value="{{ old('address') ?: $student->address }}"
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
                                            value="{{ old('birthday') ?: $student->birthday }}" placeholder="Ngày sinh"
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
                                            {{ old('age') ?: $student->age }}</p>
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
        <!--animated-->
        <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
        <script src="/ajax/ajax.student.js" type="text/javascript"></script>
    </div>
@stop
