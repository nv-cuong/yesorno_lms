@extends('admin.layouts.master')
@section('title', 'Thêm câu hỏi trong test')
@section('content')
@include('admin.tests.bootstrap5')
<meta name="csrf-token" content="{{csrf_token()}}">
<div class="card-body">


    <h2>Thêm câu hỏi trong test:</h2>
    <form action="{{route('test.store_question',$id_test)}}" method="post">
        @csrf
        {{ csrf_field() }}

        <div class="form-group">
            <label for="confirmation_pwd">Khóa học:</label>
            <select class="form-control course" id="id" name="course" data-dependent="question" disabled="disabled">

                <option value="">{{$courses->id}}. {{$courses->title }}</option>


            </select>

        </div>
        <input type="hidden" name="count_question_id" id='count_question_id' value="0"><br>

        <div class="form-group">
            <label for="exampleFormControlSelect1">Chọn câu hỏi:</label>

            <select class="form-select @error('question') is-invalid @enderror question"
                id="multiple-select-clear-field" name="question[]" data-dependent="course"
                 multiple>
                <?php
       $i=1;?>
                @foreach($question as $row)
                <option value="{{ $row->id }}"><?php echo "$i. "?>{{ $row->content }}[ <?php echo $a[$row->category] ?>]
                </option>
                <?php $i++;?>
                @endforeach

            </select>
            @error('question')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>




        <button type="submit" class="btn btn-primary">Thêm câu hỏi</button>
    </form>
</div>
<script type="text/javascript">
$('#multiple-select-clear-field').select2({
    theme: "bootstrap-5",
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
    closeOnSelect: false,
    allowClear: true,
    placeholder: ' Nhập nội dung cần tìm',
    language: {
    noResults: function (params) {
      return "Không có câu hỏi nào.";
    },
  },
}).on("change", function(e) {

    $('.multiple-select-clear-field li:not(.select2-search--inline)').hide();
    $('.counter').remove();
    var counter = $(".select2-selection__choice").length;
    $('.select2-selection__rendered').after(
        '<div style="line-height: 28px; padding: 5px;" class="counter"> Nhập nội dung tìm kiếm:</div>');
    $('.select2-selection__rendered').after(
        '<div style="line-height: 28px; padding: 5px;" class="counter"> Số câu hỏi đã chọn : ' + counter +
        '</div>');
    document.getElementById("count_question_id").value = counter;
});
</script>
<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script type="text/javascript">

</script>

@endsection