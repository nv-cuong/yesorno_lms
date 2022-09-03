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
          <form method="post" action="{{ route('score.store') }}">
            @csrf

            <div class="card-body">
              <div class="form-group">
                <label>Bài test <span style="color: red">*</span></label>
                <select class="form-control select2 " style="width: 100%;" name="test_id">
                  @forelse($tests as $test )
                  @if( $test->id == old('test_id'))
                  <option selected="selected" value="{{ $test->id }}">{{ $test->title }}</option>
                  @else
                  <option value="{{ $test->id }}">{{ $test->title }}</option>
                  @endif
                  @empty
                  @endforelse
                </select>
                @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label>Lớp học <span style="color: red">*</span></label>
                <select class="form-control select2 " style="width: 100%;" name="class_id" id="class_id">
                  @forelse($classes as $class )
                  @if( $class->id == old('class'))
                  <option selected="selected" value="{{ $class->id }}">{{ $class->name }}</option>
                  @else
                  <option value="{{ $class->id }}">{{ $class->name }}</option>
                  @endif
                  @empty
                  @endforelse
                </select>
                @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="form-group">
                <label>Chọn học viên</label>
                <select class="selectpicker form-control" multiple data-selected-text-format="count" data-live-search="true" 
                style="width: 100%;" name="student_id[]" id="student_id">
                @forelse($users as $user )
                  @if( $user->id == old('student_id'))
                  <option selected="selected" value="{{ $user->id }}">{{ $user->first_name }}</option>
                  @else
                  <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                  @endif
                  @empty
                  @endforelse
                </select>
              </div>


            </div>


            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Thêm mới</button>
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
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@stop
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
<script>
  
  $(function() {
    $('select').selectpicker();
  });


  $('#class_id').change(function(event) {
            var id_class=$(this).val();
            var url = "{{ route('score.ajaxstudent', ':id_class') }}",
      url = url.replace(':id_class', id_class);
    
    $.ajax({

      type: 'GET',
      url: url,
      success: function(data) {
        $('#student_id').html(data);
        console.log(data);

      },
      error: function(data) {
        console.log(data);
      }
    });
    
           
    });
</script>


@stop