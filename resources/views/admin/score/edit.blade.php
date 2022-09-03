@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">

      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Thêm mới test đầu vào</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form method="post" action="{{ route('score.update', 1) }}" >
            @csrf

            <div class="card-body">
              <div class="form-group">
              @csrf
              @foreach ($questions as $question)
                <h3 for="question" style="margin-bottom: 1.2rem">
                {{ $loop->iteration }}. {{ $question->content }}
                </h3>
                @if($question->category == 2)
                <input type="radio"  style="margin-bottom: 0.8rem" name="true[{{ $question->id }}]" value="1"/> Đúng
                <input type="radio"  style="margin-bottom: 0.8rem" name="true[{{ $question->id }}]" value="0"/> Sai
                @endif
                 @if ($question->category == 0)
                     <input type="text" name="essay[{{ $question->id }}]">
                 @else
                 @foreach ($question->answers as $option)
                  <input type="checkbox" name="questions[]" value="{{ $option->id }}" style="margin-bottom: 0.8rem" /> {{ $option->content }}
                  <br />
                @endforeach
                 @endif
              @endforeach
             
              </div>
              

            </div>
      

        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-6">

    </div>
    <!--/.col (right) -->
  </div>
  <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@stop

