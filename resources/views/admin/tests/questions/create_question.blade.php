@extends('admin.layouts.master')
@section('title', 'Create Question')
@section('content')

<meta name="csrf-token" content="{{csrf_token()}}">
<div class="card-body">
    

<h2>Add Question</h2>
<form action="{{route('test.store_question',$id_test)}}" method = "post" >
@csrf
{{ csrf_field() }}

<div class="form-group">
             <label for="confirmation_pwd">Course:</label>
            <select class="form-control course" id="id" name="course" data-dependent="question"  disabled="disabled">
           
            <option value="">{{$courses->id}}. {{$courses->title }}</option>
          
           
            </select>
            
            </div>
            <input type="hidden" name="count_question_id" id='count_question_id' value="0"><br>
<div class="tab-content s2bs5-example" id="multiple-select-clear-content">
    <div class="tab-pane fade show active" id="multiple-select-clear-ltr-content" role="tabpanel" aria-labelledby="multiple-select-clear-ltr-tab">
        <div dir="ltr">
<div class="form-group">
    <label for="exampleFormControlSelect1">Select Question</label>
    
    <select class="form-select question" id="multiple-select-clear-field" name="question[]" data-dependent="course"data-placeholder="Choose question" multiple>
       <?php
       $i=1;?>
      @foreach($question as $row)
            <option value="{{ $row->id }}"><?php echo "$i. "?>{{ $row->content }}</option>
            <?php $i++;?>
        @endforeach 
        
    </select>
    @error('question')
<div class="text-danger">{{ $message }}</div>
@enderror
</div>
</div>
    
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/css/docs.css" />
<link rel="stylesheet" href="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/css/rtl.css" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/anchor-js/anchor.min.js"></script>

<script src="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/js/docs.js"></script>

        <script>
            
$( '#multiple-select-clear-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
    allowClear: true,
} );

        </script>
    </div>



<button type="submit" class="btn btn-primary">Thêm câu hỏi</button>
</form>
<script type="text/javascript">
        $('#multiple-select-clear-field').select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
    allowClear: true,}).on("change", function(e) {
            
  $('.multiple-select-clear-field li:not(.select2-search--inline)').hide();
  $('.counter').remove();
  var counter = $(".select2-selection__choice").length;
 $('.select2-selection__rendered').after('<div style="line-height: 28px; padding: 5px;" class="counter"> Nhập nội dung tìm kiếm:</div>');
  $('.select2-selection__rendered').after('<div style="line-height: 28px; padding: 5px;" class="counter"> Số câu hỏi đã chọn : '+counter+'</div>');
  document.getElementById("count_question_id").value=counter;
});
    </script>
<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
 <script type="text/javascript">

</script>
 
@endsection


