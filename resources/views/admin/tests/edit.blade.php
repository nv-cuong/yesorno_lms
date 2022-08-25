@extends('admin.layouts.master')
@section('title', 'Update Test')
@section('content')
<meta name="csrf-token" content="{{csrf_token()}}">
<h2>Update Test</h2>
<form action="{{ route('test.update',[$tests->id]) }}" method = "post" >
{{ csrf_field() }}
<div class="form-group">
    <label for="exampleFormControlSelect1">Select Category</label>
    <select class="form-control" id="exampleFormControlSelect1" name ="category_question" >
        <option>{{$tests->category}}</option>
        <option>Trắc nhiệm nhiều lựa chọn</option>
        <option>Trắc nhiệm đúng sai</option>
        <option>Tự luận</option>
    </select>
</div>
<div class="form-group">
<label for="exampleFormControlInput1">Tiều đề</label>
    <input type="" class="form-control" id="exampleFormControlInput1" placeholder="nhập tiêu đề" name ="title" value="{{$tests->title}}">
    <label for="exampleFormControlInput1">Amount</label>
    <input type="" class="form-control" id="exampleFormControlInput1" placeholder="nhập số câu hỏi" name ="amount" value="{{$tests->amount}}">
    <label for="exampleFormControlInput1">Time</label>
    <input type="" class="form-control" id="exampleFormControlInput1" placeholder="nhập thời gian làm bài" name ="time" value="{{$tests->time}}">
</div>
<div class="form-group">
        <label for="exampleFormControlTextarea1" >Description:</label>
        <textarea class="form-control"  name="description" id="exampleFormControlTextarea1" rows="3" >{{$tests->description}}</textarea>
    </div>
    
<div class="form-group">
             <label for="confirmation_pwd">Sửa Course:</label>
            <select class="form-control course" id="id" name="course" data-dependent="question"
            >
            <option value="">{{$course1->title}}</option>
            @forelse($course as $id => $title)
            <option value="{{ $id }}">{{ $title }}</option>
            @empty
            @endforelse
            </select>
        
            </div>

<div class="form-group">
    <label for="exampleFormControlSelect1">Sửa Question</label>
    <select class="form-control question" id="id" name="question" data-dependent="course">
      <option value="">{{$question1->content}}</option>  <!-- 
        @forelse($question as $id => $content)
            <option value="{{ $id }}">{{ $content }}</option>
            @empty
            @endforelse -->
    </select>
</div>
<button type="submit" class="btn btn-primary">Cập nhật bài Test</button>
</form>

<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>

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
 <script src="/ajax/ajax.js"type="text/javascript"></script>
@endsection


