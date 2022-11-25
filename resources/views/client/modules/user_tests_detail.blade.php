@extends('client.layouts.master')
@section('title', 'Danh sách khóa học')

@section('content')

<div class="site-breadcrumb" style="background: url({{ asset('/user/img/breadcrumb/breadcrumb.jpg') }})">
    <div class="breadcrumb-circle">
        <img src="{{ asset('/user/img/header/header-shape-2.png') }}" class="hero-circle-1" alt="thumb">
    </div>
    <div class="container">
        <h2 class="breadcrumb-title">Danh sách khóa học</h2>
        <ul class="breadcrumb-menu clearfix">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="active">Khóa học</li>
        </ul>
    </div>
</div>

<div id="portfolio" class="portfolio-area course-2 de-padding">
    <div class="wavesshape">
        <img src="{{ asset('/user/img/course/course-bg-2.png') }}" alt="thumb">
    </div>
    <div class="container">
        <div class="row csf align-items-center">
            <div class="col-xl-8">
                <div class="site-title-left">
                    <h2>Chi tiết bài test</h2>
                </div>
            </div>
        </div>
        <div class="portfolio-items-area">
            <div class="row">
                <div class="col-xl-12 portfolio-content">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <div class="mix-item-menu active-theme">
                                <table class="table table-striped" id="example1">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên câu hỏi</th>
                                            <th>Loại câu hỏi</th>
                                            <th>Câu trả lời</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        use App\Models\Answer;
                                        @endphp
                                        @foreach ($user_test_answers as $uta)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration}}
                                            </td>
                                            <td>{{$uta->content}}</td>

                                            <td>
                                                @if ($uta->category==0)
                                                Tự luận
                                                @elseif ($uta->category==1)
                                                Trắc nghiệm
                                                @else
                                                Đúng sai
                                                @endif
                                            </td>
                                            <td>
                                                @php

                                                if($uta->category==1)
                                                {
                                                $answer= explode(",",$uta->answer);

                                                for( $i=0 ; $i<count($answer);$i++ ) { $answer_content=Answer::find($answer[$i]); echo ($answer_content->content);
                                                    echo "<br>";
                                                    }
                                                }
                                                if($uta->category==0)
                                                {
                                                echo $uta->answer;
                                                }
                                                if($uta->category==2)
                                                {
                                                    if($uta->answer==1)
                                                    {
                                                    echo 'Đúng';
                                                    }else{
                                                    echo 'Sai';
                                                    }
                                                }
                                                @endphp
                                            </td>
                                            <td>
                                                @if($uta->correct != '')
                                                @if ($uta->correct ==1)
                                                <i class="fas fa-check" style="color:green ;"></i>
                                                @else
                                                <i class='fas fa-times' style='color:red'></i>
                                                @endif

                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">

    </div>
</div>

@endsection