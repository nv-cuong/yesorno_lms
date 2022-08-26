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
    
<button type="submit" class="btn btn-primary">Cập nhật bài Test</button>
</form>


@endsection


