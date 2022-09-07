@extends('admin.layouts.master')
@section('title', 'View Question')
@section('content')
@foreach($question as $row1)
@endforeach
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                @include('Admin/_alert')
            </div>

        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <h2>Quản lí câu hỏi</h2>
                <div class="card">

                    <div class="card-header" style="">
                        Test: {{$tests->id}}
                        <a href="{{ route('test.create_question',[$row1->course->id,$tests->id,$arr_question])}}"
                            class="btn btn-success float-right">
                            <i class="nav-icon fas fa-solid fa-plus">Thêm câu hỏi</i></a>

                    </div>

                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Test</th>
                                <th>Chương</th>
                                <th>Nội dung câu hỏi</th>
                                <th>Loại câu hỏi</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($question as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$tests->id}}</td>
                                <td>{{$row->course->id}}. {{$row->course->title}}</td>
                                <td>{{$row->content}}</td>

                                <td><?php echo $a[$row->category]?></td>
                                <td>
                                    <a href="{{route('test.question.edit',[$row->id,$tests->id,$row->course->id])}}"
                                        class="btn btn-success" name="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModal" onclick="myFunction({{$row->id}})">
                                        <i class="nav-icon fas fa-solid fa-trash"></i>
                                    </button>
                                </td>

                            </tr>
                            @endforeach


                </div>
                </tbody>

                </table>

            </div>
        </div>
    </div>
    </div>
    </div>
</section>
@stop
@section('scripts')
<script type="text/javascript">
$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "oLanguage": {
               "sInfo" : "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ học viên",// text you want show for info section
               "sSearch":"Tìm kiếm",
               "oPaginate":{
                "sPrevious":"Trước",
                "sNext":"Tiếp",
               }
            },
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
</script>

@yield('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xóa câu hỏi?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có muốn xóa không?
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('test.question.delete',$tests->id) }}"
                    onsubmit="return ConfirmDelete( this )">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="question_id" id='question_id' value="0"><br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>

                    <button class="btn btn-danger" type="submit">Đồng ý</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@yield('js')
<script>
function myFunction(id) {

    document.getElementById("question_id").value = id;



}
</script>
@endsection