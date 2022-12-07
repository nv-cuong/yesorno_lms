@extends('client.layouts.master')
@section('title', 'Danh sách khóa học')

@section('content')

    <div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }})">
        <div class="breadcrumb-circle">
            <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
        </div>
        <div class="container">
            <h2 class="breadcrumb-title">
                Trang cá nhân
            </h2>
            <ul class="breadcrumb-menu clearfix">
                <li>
                    <a href="{{ route('home') }}">
                        Trang chủ
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}">
                        Trang cá nhân
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('profile.update') }}">
                        Chỉnh sửa
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- profile user ============================================= -->
    <div class="cate-3-area bg-2 de-padding">
        <div class="container">
            <div class="cate-3-title">
                <div class="row align-items-center">
                    <div class="col-xl-8">
                        <span class="sub-2">Thông tin cá nhân</span>
                        <h2>Chỉnh sửa thông tin các nhân</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="author-info posi-rel de-padding">
        <div class="author-shape">
            <img src="{{ asset('user/img/details-page/author-bg.png') }}" alt="thumb">
        </div>
        <div class="container">
            <form class="form-horizontal" method="POST" action="{{ route('profile.saveUpdate', [$user->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class=" grid-2">
                    <div class="auhtor-pic">
                        @if (empty($user->name_img))
                            <img src="{{ asset('user/img/team/team-1.jpg') }}" alt="Chưa có ảnh" class="mb-3">
                        @else
                            <img src="{{ asset($user->path) }}" alt="Ảnh cá nhân" class="mb-3"
                                style="width: 400px;">
                        @endif
                        <input type="hidden" name="student_id" value="{{ $user->id }}">
                        <input type="file" name="name_img" class="@error('name_img') is-invalid @enderror">
                        @error('name_img')
                            <div class="invalid-feedback invalid-font-size">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="first_name">
                                Tên
                            </label>
                            <div class="col-md-9">
                                <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                    name="first_name" id="first_name"
                                    value="{{ old('first_name') ?: $user->first_name }}" placeholder="Tên"
                                    maxlength="191">
                                @error('first_name')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="last_name">
                                Họ và tên đệm
                            </label>
                            <div class="col-md-9">
                                <input class="form-control @error('last_name') is-invalid @enderror" type="text"
                                    name="last_name" id="last_name" value="{{ old('last_name') ?: $user->last_name }}"
                                    placeholder="Tên" maxlength="191">
                                @error('last_name')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="phone">Số điện thoại</label>
                            <div class="col-md-9">
                                <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                    name="phone" id="phone" value="{{ old('phone') ?: $user->phone }}"
                                    placeholder="Tên" maxlength="191">
                                @error('phone')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="address">Địa chỉ</label>
                            <div class="col-md-9">
                                <input class="form-control @error('address') is-invalid @enderror" type="text"
                                    name="address" id="address" value="{{ old('address') ?: $user->address }}"
                                    placeholder="Tên" maxlength="191">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="gender">Giới tính</label>
                            <div class="col-md-9">
                                </label>
                                <input type="radio" name="gender" value="male"
                                    {{ (old('gender') ?: $user->gender) == 'male' ? 'checked' : '' }}> Nam
                                <input type="radio" name="gender" value="female" style="margin-left:10px"
                                    {{ (old('gender') ?: $user->gender) == 'female' ? 'checked' : '' }}> Nữ
                                <input type="radio" name="gender" value="Other" style="margin-left:10px"
                                    {{ (old('gender') ?: $user->gender) == 'other' ? 'checked' : '' }}> Khác
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="birthday">Ngày sinh</label>
                            <div class="col-md-10">
                                <input class="form-control @error('birthday') is-invalid @enderror" type="date"
                                    name="birthday" id="birthday" value="{{ old('birthday') ?: $user->birthday }}"
                                    placeholder="Ngày sinh" maxlength="191">
                                @error('birthday')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="form-group row justify-content-center">
                            <div class="col-4">
                                <button class="btn btn-success pull-right btn-lg mr-3" type="submit">Cập nhật</button>
                                <a class="btn btn-danger btn-lg" href="{{ route('profile') }}">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection