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
           
          </div>
           <form  method="post"action="{{route('score.point')}}">
            @csrf
          <table class="table table-striped" id="example1">
            <thead>
              <tr>
                <th>STT</th>
                <th>Câu hỏi</th>
                <th>Câu trả lời</th>
                <th>Điểm</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($user_test_answers as $uta)


              <tr>
                <th>
                  
                </th>
                <th>{{$uta->content}}</th>
                <th>{{$uta->answer_essay}}</th>
                <th>
                   {{$uta->score}}
                </th>
                <th>
                <input type="radio"  style="margin-bottom: 0.8rem" name="true[{{$uta->id}}]" value="1" checked /> Đúng
                <input type="radio"  style="margin-bottom: 0.8rem" name="true[{{$uta->id}}]" value="0"/> Sai
                </th>
               
              </tr>
              @endforeach
            
            </tbody>
            <tr>
            <td colspan="5" class="text-center"> <button type="submit" class="btn btn-primary">Chấm điểm</button></td>
            <input type="hidden" value="{{$uta->user_test_id}}" name ="user_test_id">
          </tr>
          </table>
          </form>

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
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

  
</script>
@stop