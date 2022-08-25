@extends('admin.layouts.master')
@section('title', 'Create Test')
@section('content')
<style>
  .multiselect {
  width: 200px;
}
 
.selectBox {
  position: relative;
}
 
.selectBox select {
  width: 100%;
  font-weight: bold;
}
 
.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}
 
#checkboxes {
  display: none;
  border: 1px #dadada solid;
}
 
#checkboxes label {
  display: block;
}
 
#checkboxes label:hover {
  background-color: #1e90ff;
}
</style>
<meta name="csrf-token" content="{{csrf_token()}}">
<h2>Create Test</h2>
<form action="{{ route('test.store') }}" method = "post" >
{{ csrf_field() }}
<div class="form-group">
    <label for="exampleFormControlSelect1">Select Category</label>
    <select class="form-control" id="exampleFormControlSelect1" name ="category_question">
        <option>Trắc nhiệm nhiều lựa chọn</option>
        <option>Trắc nhiệm đúng sai</option>
        <option>Tự luận</option>
    </select>
</div>
<div class="form-group">
<label for="exampleFormControlInput1">Tiều đề</label>
    <input type="" class="form-control" id="exampleFormControlInput1" placeholder="nhập tiêu đề" name ="title">
    <label for="exampleFormControlInput1">Amount</label>
    <input type="" class="form-control" id="exampleFormControlInput1" placeholder="nhập số câu hỏi" name ="amount">
    <label for="exampleFormControlInput1">Time</label>
    <input type="" class="form-control" id="exampleFormControlInput1" placeholder="nhập thời gian làm bài" name ="time">
</div>
<div class="form-group">
        <label for="exampleFormControlTextarea1">Nhập Description:</label>
        <textarea class="form-control"  name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    
<div class="form-group">
             <label for="confirmation_pwd">Chọn Course:</label>
            <select class="form-control course" id="id" name="course" data-dependent="question"
            >
            <option value="">-</option>
            @forelse($course as $id => $title)
            <option value="{{ $id }}">{{ $title }}</option>
            @empty
            @endforelse
            </select>
            
            </div>

<div class="form-group">
    <label for="exampleFormControlSelect1">Select Question</label>
    <div class="selectBox" onclick="showCheckboxes()">
    <select class="form-control question" id="id" name="question" data-dependent="course">
      <option value="">Selete Question</option>  <!-- 
        @forelse($question as $id => $content)
            <option value="{{ $id }}">{{ $content }}</option>
            @empty
            @endforelse -->
    </select>
    <div class="overSelect"></div>
    </div>
    <div class="check" id="checkboxes">
      <label for="one">
        <p>Selete Course first</p></label>
    </div>

</div>



<button type="submit" class="btn btn-primary">Tạo bài Test</button>
</form>

<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script>
var expanded = false;
 
function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>
 <script type="text/javascript">

// $("select[name='course_id']").change(function() {
//     var url = "{{ url('/showQuestionInCourse') }}";
//     var id = $(".course").val();
//     var token = $("input[name='_token']").val();
//     alert(url);
//     // $.post("data.php", { id: id }, function(data) {
//     //     $(".question").html(data);
//     $.ajax({
//         url: url,
//         method: 'POST',
//         data: {
//             id: id,
//             _token: token
//         },

//         success: function(data) {
//             $("select[name='question']").html('');
//             $.each(data, function(key, value) {
//                 $("select[name='question']").append(
//                     "<option value=" + value.id + ">" + value.title + "</option>"
//                 );
//             });
//         }

//     })
// });</script>
 <script src="/ajax/ajaxadd.js"type="text/javascript"></script>
@endsection


