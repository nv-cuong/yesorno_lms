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
            <div class="col-xl-4">
                <div class="site-title-right">
                    <h2>Course</h2>
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
                                            <th>Checked</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        use App\Models\Answer;
                                        @endphp
                                        @foreach ($user_test_answers as $uta)
                                        <tr>
                                            <th>
                                                {{ $loop->iteration}}
                                            </th>
                                            <th>{{$uta->content}}</th>

                                            <th>
                                                @if ($uta->category==0)
                                                Tự luận
                                                @else
                                                @if ($uta->category==1)
                                                Trắc nghiệm
                                                @else
                                                Đúng sai
                                                @endif
                                                @endif
                                            </th>
                                            <th>
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
                                            </th>
                                            <th>
                                                @if($uta->correct != '')
                                                @if ($uta->correct ==1)
                                                Đúng
                                                @else
                                                Sai
                                                @endif

                                                @endif
                                            </th>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- End Mixitup Nav-->
                    <div class="magnific-mix-gallery masonary">
                        <div id="portfolio-grid" class="portfolio-items" style="position: relative; height: 1285.32px;">

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
@section('css')
<link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }})">
<link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- DataTables & Plugins -->
@endsection
@section('scripts')
<!-- datatables -->

<script src="{{ asset('/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "oLanguage": {
               "sInfo" : "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ câu hỏi",// text you want show for info section
               "sSearch":"Tìm kiếm",
               "oPaginate":{
                "sPrevious":"Trước",
                "sNext":"Tiếp",
               }
            },
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    function student_delete(id) {
        var student_id = document.getElementById('student_id');
        student_id.value = id;
    }
</script>
@stop