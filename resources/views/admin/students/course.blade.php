@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid" style="padding-top: 30px">
        <div class="animated fadeIn">
            <div class="content-header">
            </div>
            <div class="card">

                <div class="card-header">
                    <h3 class="page-title d-inline mb-0" style="font-size :200%">Khóa học của
                        {{ $student->first_name }} {{ $student->last_name }}</h3>
                </div>
                <div class="card-body">
                    @forelse ($courses as $course)
                        <div class="card collapsed-card">
                            <div class="card-header" style="font-size:1.8em">
                                <i class="bi bi-journal-bookmark-fill"></i>
                                {{ $course['title'] }}
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body ">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        @foreach ($course->units()->get() as $unit)
                                            <div class="card collapsed-card">
                                                <div class="card-header">
                                                    <i class="bi bi-bookmark-check" style="font-size:1.5em"> {{ $unit->getOriginal('title') }}</i>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body ">
                                                    <ul class="nav nav-pills flex-column">
                                                        <li class="nav-item">
                                                            @foreach ($lessons as $lessonItem)
                                                                @if($lessonItem['unit_id']==$unit->getOriginal('id'))
                                                                    @if ($lessonItem['status']==1)
                                                                    <div class="p-3">
                                                                        <i class="fas fa-arrow-circle-right text-success"
                                                                            > {{ $lessonItem['title'] }}</i>
                                                                        <br>
                                                                    </div>
                                                                    @else
                                                                    <div class="p-3">
                                                                        <i class="fas fa-arrow-circle-right text-muted"
                                                                            > {{ $lessonItem['title'] }}</i>
                                                                        <br>
                                                                    </div>
                                                                    @endif

                                                                    @endif

                                                             @endforeach

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
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
