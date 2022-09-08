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
        @include('admin/_alert')
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
          <form method="post" action="{{route('score.point')}}">
            @csrf
<<<<<<< HEAD
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
                <th>{{$uta->answer}}</th>
                <th>
                   {{$uta->score}}
                   <input type="hidden" value="{{$uta->user_test_id}}" name ="user_test_id">
                </th>
                <th>
                <input type="number"  min="0" required name="true[{{$uta->id}}]" /> 
                @error('true'.'['.$uta->id.']')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </th>
               
              </tr>
              @endforeach
            
            </tbody>
            <tr>
            <td colspan="5" class="text-center"> <button type="submit" class="btn btn-primary">Chấm điểm</button></td>
            
          </tr>
          </table>
=======
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
                  <th>{{$uta->answer}}</th>
                  <th>
                    {{$uta->score}}
                  </th>
                  <th>
                    <input type="number" min="0" required name="true[{{$uta->id}}]" />
                    @error('true'.'['.$uta->id.']')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input type="hidden" value="{{$uta->user_test_id}}" name="user_test_id">
                  </th>
                </tr>
                @endforeach
              </tbody>
              <tr>
                <td colspan="5" class="text-center"> <button type="submit" class="btn btn-primary">Chấm điểm</button></td>
              </tr>
            </table>
>>>>>>> eb298b0a6ea60e2c967036deebf6706cc05c2eb3
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