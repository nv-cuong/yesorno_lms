@extends('admin.layouts.master')
@section('title', 'Update Question')
@section('content')
<meta name="csrf-token" content="{{csrf_token()}}">
<h2>Edit Question</h2>
<form action="{{ route('question.update',[$tests->id,$question->id]) }}" method = "post" >
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
             <label for="confirmation_pwd">Question:</label>
            <select class="form-control course" id="id" name="question" data-dependent="question"
            >
           
            <option value="{{$question->id}}">{{$question->id}}. {{$question->content}}</option>
            <?php
       $i=2;?>
      @foreach($question_old as $row)
            <option value="{{ $row->id }}"><?php echo "$i. "?>{{ $row->content }}</option>
            <?php $i++;?>
        @endforeach 
           
            </select>
            
            </div>
    
<button type="submit" class="btn btn-primary">Cập nhật Question</button>
</form>


@endsection


