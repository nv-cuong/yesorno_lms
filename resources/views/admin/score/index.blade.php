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

          <table class="table table-striped" id="score_table">
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
                {{ $loop->iteration  }}
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
                
                @if($test_user->score == '' && $test_user->status == 1)
                <a href="{{ route('score.dots',$test_user->id) }} " class=" btn btn-primary btn-sm">Chấm điểm</a>
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

@section('scripts')



<script type="text/javascript">
  $(function() {
    $("#score_table").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "oLanguage": {
               "sInfo" : "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ bài",// text you want show for info section
               "sSearch":"Tìm kiếm",
               "oPaginate":{
                "sPrevious":"Trước",
                "sNext":"Tiếp",
               }
            },
    }).buttons().container().appendTo('#score_table_wrapper .col-md-6:eq(0)');
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