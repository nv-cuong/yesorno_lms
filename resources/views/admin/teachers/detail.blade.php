@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline mb-0">Thông tin chi tiết giảng viên</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Ảnh đại diện</th>
                            @if ($teacher->gender === 'male')
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
                            <th>Mã học viên</th>
                            <td>{{ $teacher->stu_id }}</td>
                        </tr>

                        <tr>
                            <th>Họ và tên học viên</th>
                            <td>{{ $teacher->last_name }} {{ $teacher->first_name }}</td>
                        </tr>

                        <tr>
                            <th>Ngày sinh</th>
                            <td>{{ $teacher->birthday }}</td>
                        </tr>

                        <tr>
                            <th>Số điện thoại</th>
                            <td>{{ $teacher->phone }}</td>
                        </tr>

                        <tr>
                            <th>Địa chỉ</th>
                            <td>{{ $teacher->address }}</td>
                        </tr>

                        <tr>
                            <th>Ngày sinh</th>
                            <td>{{ $teacher->birthday }}</td>
                        </tr>

                        <tr>
                            <th>Tuổi</th>
                            <td>{{ $teacher->age }}</td>
                        </tr>

                        <tr>
                            <th>Giới tính</th>
                            <td>
                                @if ($teacher->gender == 'male')
                                    Nam
                                @elseif ($teacher->gender == 'female')
                                    Nữ
                                @else
                                    Khác
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Lần cuối đăng nhập</th>
                            <td>{{ $teacher->last_login }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
