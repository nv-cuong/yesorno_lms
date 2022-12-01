@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid" style="padding-top: 30px">
        <div class="animated fadeIn">
            <div class="content-header">
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="page-title d-inline mb-0" style="font-size :200%">Khóa học của giảng viên
                        {{ $teacher->last_name }} {{ $teacher->first_name }}</h3>
                </div>
                <div class="card-body">
                    @forelse ($courses as $course)
                        <div class="card collapsed-card">
                            <div class="card-header" style="font-size:1.8em">
                                <i class="bi bi-journal-bookmark-fill"></i>
                                {{ $course['title'] }}
                            </div>
                        </div>
                    @empty
                        <ul class="list-group list-group-flush"style="width : 100%">Chưa có khóa học nào</ul>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@stop
