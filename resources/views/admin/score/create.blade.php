@extends('admin.layouts.master')
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
          <form method="post" action="{{ route('score.store') }}" id="gg">
           
          {{ csrf_field() }}
            <div class="card-body">
              <div class="form-group">
                <label>Bài test <span style="color: red">*</span></label>
                <select class="form-control select2 " style="width: 100%;" name="test_id" id="test_id">
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
                <select class="form-control select2 " style="width: 100%;" 
                name="class_id" id="class_id" data-dependent="student_id">
                <option value="">---</option>
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
                <select class="form-select @error('student_id') is-invalid @enderror student_id"
                            id="multiple-select-clear-field" name="student_id[]" data-dependent="class_id"
                            data-placeholder="Choose student_id" multiple >
                           
                </select>
                @error('student_id')
                        <div class="text-danger">{{ $message }}</div>
                @enderror
                
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

@stop
@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
 <link rel="stylesheet" href="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/css/docs.css" />
 <link rel="stylesheet" href="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/css/rtl.css" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/anchor-js/anchor.min.js"></script>
<script src="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/js/docs.js"></script>
<script src="/ajax/ajax.js" type="text/javascript"></script> 
  
  


  
</script>


<script type="text/javascript">
$('#multiple-select-clear-field').select2({
    theme: "bootstrap-5",
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
    closeOnSelect: false,
    allowClear: true,
}).on("change", function(e) {

    $('.multiple-select-clear-field li:not(.select2-search--inline)').hide();
    $('.counter').remove();
    var counter = $(".select2-selection__choice").length;
    $('.select2-selection__rendered').after(
        '<div style="line-height: 28px; padding: 5px;" class="counter"> Nhập nội dung tìm kiếm:</div>');
    $('.select2-selection__rendered').after(
        '<div style="line-height: 28px; padding: 5px;" class="counter"> Số câu hỏi đã chọn : ' + counter +
        '</div>');
    //document.getElementById("count_question_id").value = counter;
});
</script>
<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {



$("#class_id").change(function () {
   
    if ($(this.val != '')) {
        
        var id = $("#class_id").val();
        var url = "{{ route('score.getStudent', ':id') }}",
        url = url.replace(':id', id);
      $.ajax({
        type: 'GET',
        url: url,
        success: function(data) {
            console.log(data);
            $(".student_id").html(data);
  
        },
        error: function(data) {
          console.log(data);
        }
      });
     
    }
})
})

   
</script>

@stop