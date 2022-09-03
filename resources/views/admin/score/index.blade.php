@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Quản lý điểm bài test</h1>
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
            <a href="{{ route('score.create') }}" class="btn btn-success float-right">+ Tạo bài test đầu vào</a>
          </div>

          <table class="table table-striped" id="example1">
            <thead>
              <tr>
                <th>STT</th>
                <th>User</th>
                <th>Tên bài test</th>
                <th>Điểm</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($test_users as $test_user)


              <tr>
                <th>
                  
                </th>
                <th>{{$test_user->first_name}}</th>
                <th>{{$test_user->title}}</th>
                <th>
                   {{$test_user->score}}
                </th>
                <th>
                  @if($test_user->status == 1)
                   Đã làm
                   @else
                   Chưa làm
                   @endif
                </th>
               

                <th>
                <a href="{{ route('score.edit',$test_user->test_id) }} " class="edit btn btn-success btn-sm">Làm bài test</a>
                @if($test_user->score == '' && $test_user->status == 1)
                <a href="{{ route('score.dots',$test_user->id) }} " class="edit btn btn primary btn-sm">Chấm điểm</a>
                @endif
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
        <h2 class="modal-title ">Danh sách Câu trả lời</h2>
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
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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