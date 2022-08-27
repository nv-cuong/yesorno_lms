@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="animated fadeIn">
        <div class="content-header">
        </div>
        <!--content-header-->


        <div class="card">

            <div class="card-header">
                <h3 class="page-title d-inline mb-0">Thông tin lớp học của học viên</h3>
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
                                        @forelse ($classes as $class)
                                            <div class="d-flex justify-content-between align-items-center">
                                                <ul class="list-group list-group-flush"style="width : 100%">
                                                    <li class="list-group-item">
                                                        <i class="fas fa-chalkboard-teacher fa-2x"> {{ $class['name'] }}</i>
                                                    </li>
                                                    @foreach ($class->courses()->get() as $course)
                                                        <li class="list-group-item" style="margin-left : 40px">
                                                            <i class="fas fa-book fa-lg" style="color: rgb(35, 35, 248)"></i>
                                                            {{ $course->getOriginal('title') }}
                                                        </li>
                                                    @endforeach
                                                    <br>
                                                </ul>
                                            </div>

                                        @empty
                                            <ul class="list-group list-group-flush"style="width : 100%">
                                                <li class="list-group-item">
                                                    <i class="fa-solid fa-graduation-cap"></i>
                                                    Học viên chưa đăng kí lớp nào
                                                </li>
                                        @endforelse

                                        </ul>
                    </div>
                    </tr>
                    </tbody>
                    </table>
                </div>
            </div><!-- Nav tabs -->
        </div>
    </div>
    </div>
@stop
