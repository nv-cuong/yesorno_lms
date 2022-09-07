@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="page-title d-inline mb-0">Chi tiết học viên</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Ảnh đại diện</th>
                                @if ($student->gender === 'male')
                                    <td><img height="100px"
                                            src="https://www.clipartmax.com/png/middle/176-1763433_user-account-profile-avatar-person-male-icon-icon-user-account.png"
                                            class="user-profile-image"></td>
                                @else
                                    <td><img height="100px"
                                            src="https://www.clipartmax.com/png/middle/293-2931307_account-avatar-male-man-person-profile-icon-profile-icons.png"
                                            class="user-profile-image"></td>
                                @endif
                            </tr>

                            <tr>
                                <th>Họ và tên</th>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            </tr>

                            <tr>
                                <th>Ngày sinh</th>
                                <td>{{ $student->birthday }}</td>
                            </tr>

                            <tr>
                                <th>Số điện thoại</th>
                                <td>{{ $student->phone }}</td>
                            </tr>

                            <tr>
                                <th>Địa chỉ</th>
                                <td>{{ $student->address }}</td>
                            </tr>

                            <tr>
                                <th>Ngày sinh</th>
                                <td>{{ $student->birthday }}</td>
                            </tr>

                            <tr>
                                <th>Tuổi</th>
                                <td>{{ $student->age }}</td>
                            </tr>

                            <tr>
                                <th>Giới tính</th>
                                <td>{{ $student->gender }}</td>
                            </tr>

                            <tr>
                                <th>Lần cuối đăng nhập</th>
                                <td>{{ $student->last_login }}</td>
                            </tr>
                            <tr>
                                <th>Số lớp học đang tham gia</th>
                                <td>{{ $classStudiesNumber }}</td>
                            </tr>
                            <tr>
                                <th>Tiến độ</th>
                                <td>
                                    <div class="progress" style="width: 50%">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow={{ $coursesNumber }} aria-valuemin="0" aria-valuemax="100"
                                            style="width: {{ $coursesNumber }}%">{{ $coursesNumber }}%</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- Nav tabs -->
        </div>
    </div>
@stop
