@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="animated fadeIn">
        <div class="content-header">
        </div>
        <!--content-header-->


        <div class="card">

            <div class="card-header">
                <h3 class="page-title d-inline mb-0">Thông tin lớp học của sinh viên</h3>
                <div class="float-right">
                    <a href="" class="btn btn-success">Tạo sinh viên</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>STT</th>
                                    <td>{{ $student->id }}</td>
                                </tr>
                                <tr>
                                    <th>Họ và tên</th>
                                    <td>{{ $student->fist_name }} {{ $student->last_name }}</td>
                                </tr>

                                <tr>
                                    <th>Địa chỉ email</th>
                                    <td>{{ $student->email }}</td>
                                </tr>
                                <tr>
                                    <th>Lớp học</th>
                                    <td>
                                        @foreach ($classes as $class)
                                            <div class="d-flex justify-content-between align-items-center">

                                                <ul class="list-group list-group-flush"style="width : 100%">
                                                    <li class="list-group-item">
                                                        <i class="fa-solid fa-graduation-cap"></i>
                                                        {{ $class['name'] }}
                                                    </li>
                                                    @foreach ($class->courses()->get() as $course)
                                                        <li class="list-group-item" style="margin-left : 40px">
                                                            <i class="fa-solid fa-circle-arrow-right" style="color: rgb(235, 41, 41)"></i>
                                                            {{ $course->getOriginal('title') }}
                                                        </li>
                                                    @endforeach
                                                    <br>
                                                </ul>
                                            </div>
                                        @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- Nav tabs -->
            </div>
        </div>
    </div>
@stop
