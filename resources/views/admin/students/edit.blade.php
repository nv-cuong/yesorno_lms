@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid" style="padding-top: 30px">
        <div class="animated fadeIn">
            <div class="content-header">
            </div>
            <!--content-header-->
            <form class="form-horizontal" method="POST" action="{{ route('student.update', [$student->id]) }}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="page-title d-inline">Sửa thông tin sinh viên</h3>
                        <div class="float-right">
                            <a href="" class="btn btn-success">Tạo sinh viên</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="first_name">Họ</label>

                                    <div class="col-md-10">
                                        <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                            name="first_name" id="first_name" value="{{ $student->first_name }}"
                                            placeholder="Họ" maxlength="191" required="" autofocus="">
                                    </div>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <!--col-->
                                </div>
                                <!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="last_name">Tên</label>

                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="last_name" id="last_name"
                                            value="{{ $student->last_name }}" placeholder="Tên" maxlength="191"
                                            required="">
                                    </div>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <!--col-->
                                </div>
                                <!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="email">Địa chỉ email</label>

                                    <div class="col-md-10">
                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                            name="email" id="email" value="{{ $student->email }}"
                                            placeholder="Địa chỉ email" maxlength="191" readonly="1" required="">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <!--col-->
                                </div>
                                <!--form-group-->

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="gender">Giới tính</label>
                                    <div class="col-md-10">
                                    </label >
                                    <input type="radio" name="gender" value="Male"
                                        {{ $student->gender == 'Male' ? 'checked' : '' }}> Nam
                                        <input type="radio" name="gender" value="Female" style="margin-left:10px"
                                            {{ $student->gender == 'Female' ? 'checked' : '' }}> Nữ
                                        <input type="radio" name="gender" value="Other" style="margin-left:10px"
                                            {{ $student->gender == 'Other' ? 'checked' : '' }}> Khác
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="phone">Số điện thoại</label>

                                    <div class="col-md-10">
                                        <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                            name="phone" id="phone" value="{{ $student->phone }}"
                                            placeholder="Số điện thoại" maxlength="12" required="">
                                    </div>
                                    <!--col-->
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!--form-group-->
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="age">Tuổi</label>

                                    <div class="col-md-10">
                                        <input class="form-control @error('age') is-invalid @enderror" type="text"
                                            name="age" id="age" value="{{ $student->age }}" placeholder="Tuổi"
                                            maxlength="3" required="">
                                    </div>
                                    <!--col-->
                                </div>
                                @error('age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!--form-group-->
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="birthday">Ngày sinh</label>

                                    <div class="col-md-10">
                                        <input class="form-control @error('age') is-invalid @enderror" type="date"
                                            name="birthday" id="birthday" value="{{ $student->birthday }}"
                                            placeholder="Ngày sinh" maxlength="191" required="">
                                    </div>
                                    <!--col-->
                                </div>
                                @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!--form-group-->

                                {{-- <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="class">Lớp</label>

                                    <div class="col-md-10">
                                        @foreach ($classes as $class)
                                            <ul class="list-group" style = "margin-top:15px">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{ $class['name'] }}
                                                </div>

                                                @foreach ($class->courses()->get() as $course)
                                                @php
                                                @endphp
                                                    <li class="list-group-item d-flex justify-content align-items-center" style = "margin-top:15px">
                                                        <i class="fa-solid fa-book-open" style = "margin-right:10px"></i>
                                                        {{ $course->getOriginal('title') }}
                                                    </li>
                                                @endforeach
                                        @endforeach

                                        </ul>
                                    </div> --}}
                                    <!--col-->
                                {{-- </div> --}}
                                <div class="form-group row justify-content-center">
                                    <div class="col-4">
                                        <a class="btn btn-danger" href="">Cancel</a>
                                        <button class="btn btn-success pull-right" type="submit">Update</button>
                                    </div>
                                </div>
                                <!--col-->
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <!--animated-->
    </div>
@stop
