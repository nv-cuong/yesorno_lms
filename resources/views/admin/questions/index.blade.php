@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Quản lý Câu hỏi</h1>
      </div>
      <div class="col-sm-12">
        @include('Admin/_alert')
      </div><!-- /.col -->

    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('question.create') }}" class="btn btn-success float-right">+ Tạo câu hỏi</a>
          </div>

          <table class="table table-striped" id="table_question">
            <thead>
              <tr>
                <th>STT</th>
                <th>Tên câu hỏi</th>
                <th>Tên khóa học</th>
                <th>Loại câu hỏi</th>
                <th>Câu trả lời</th>
                <th>Điểm</th>


                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)


              <tr>
                <th>
                  {{ $loop->iteration  }}
                </th>
                <th>{{$question->content}}</th>
                <th>{{$question->course->title}}</th>
                <th>
                  @if ($question->category==0)
                  Tự luận
                  @else
                  @if ($question->category==1)
                  Trắc nghiệm
                  @else
                  Đúng sai
                  @endif
                  @endif
                </th>
                <th>
                  @if ($question->category==1)
                  <a onclick="event.preventDefault();answer_qu('{{$question->id}}')" href="" class="btn btn-primary btn-sm "><i class="fa fa-plus-circle"></i> Xem </a>
                  @else
                  @if($question->answer==1 && $question->category==2)
                  Đúng
                  @else
                  @if($question->answer==0 && $question->category==2)
                  Sai
                  @else

                  @endif
                  @endif
                  @endif

                </th>
                <th>{{$question->score}}</th>

                <th>
                  <a href="{{ route('question.edit',$question->id) }} " class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                  <a class="btn btn-sm btn-danger delete_question" data-toggle="modal" data-target="#deleteModalQuestion" value="{{$question->id}}" onclick="javascript:question_delete('{{$question->id}}')"><i class="fas fa-backspace"></i></a>
                </th>
              </tr>
              @endforeach



            </tbody>
          </table>
        </div>
      </div>
    </div>
</section>
@stop
@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModalQuestion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Xóa câu hỏi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('question.delete') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="question_id" id="question_id" value="0">
        <div class="modal-body">
          Bạn có muốn xóa không ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
          <button type="submit" class="btn btn-primary">Có</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- xem câu trả lời -->
<div class="modal fade" id="modal_answer">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header text-center">
        <h2>Danh sách Câu trả lời</h2>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped" id="show_answer">
            <thead>
              <tr>
                <th class="th-sortable text-center" data-toggle="class">Câu trả lời
                </th>
                <th class="th-sortable text-center" data-toggle="class">Check
                </th>

              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>


        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('scripts')


<script type="text/javascript">
  $(function() {
    $("#table_question").DataTable({
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
    }).buttons().container().appendTo('#table_question_wrapper .col-md-6:eq(0)');
  });

  function question_delete(id) {
    var question_id = document.getElementById('question_id');
    question_id.value = id;
  }

  function answer_qu(an) {
    var url = "{{ route('question.answer', ':an') }}",
      url = url.replace(':an', an);
    $.ajax({

      type: 'GET',
      url: url,
      success: function(data) {
        $('#show_answer tbody').html(data);
        $('#modal_answer').modal('show');

      },
      error: function(data) {
        console.log(data);
      }
    });
  }
</script>
@stop