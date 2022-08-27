@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid" style="padding-top: 30px">
        <div class="animated fadeIn">
            <div class="content-header">
            </div>
            <div class="card">

                <div class="card-header">
                    <h3 class="page-title d-inline mb-0" style="font-weight:bold; font-size :200%">Khóa học của {{$student->first_name}} {{$student->last_name}}</h3>
                </div>
                <div class="card-body">
                    @forelse ($courses as $course)
                    <div class="d-flex justify-content-between align-items-center">

                        <ul class="list-group list-group-flush"style="width : 100%">
                            <li class="list-group-item">
                                <i class="fas fa-book fa-2x"> {{ $course['title'] }}</i>
                            </li>
                                <li class="list-group-item" style="margin-left : 40px">
                                    @foreach ($course->units()->get() as $unit)
                                    <i class="fas fa-arrow-circle-right fa-lg" style="color: rgb(37, 236, 37)"></i>
                                    {{$unit->getOriginal('title')}}
                                    <br>
                                    @endforeach
                                </li>
                            <br>
                        </ul>
                    </div>
                    @empty
                    <ul class="list-group list-group-flush"style="width : 100%">Chưa có khóa học nào</ul>
                    @endforelse


                </div>
            </div>
        </div>
        <!--animated-->
    </div>
@stop
