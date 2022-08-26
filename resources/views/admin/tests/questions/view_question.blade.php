@extends('admin.layouts.master')
@section('title', 'View Question')
@section('content')
@foreach($question as $row1)
    @endforeach
 
<?php static $k=1?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Danh sách câu hỏi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
    <form method="POST" action="{{ route('test.create_question',[$row1->course->id,$tests->id,$arr_question])}}">
    @csrf
    <button class="w-100 btn btn-lg btn-primary" type="submit">Thêm câu hỏi</button>
    </form>
    </div>
    </div>
<div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Location">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Test</th>
       <th scope="col">Chương</th> 
      <th scope="col">Nội dung câu hỏi</th>
     
      
      <th scope="col">edit or delete</th>
    </tr>
  </thead>
  <tbody>

  @foreach($question as $row)
            <tr>
                <td>{{$row->id}}</td> 
                <td>{{$tests->id}}</td>
                <td>{{$row->course->id}}. {{$row->course->title}}</td>
                <td><?php echo"$k. "?>{{$row->content}}</td>
                <?php $k++;
                ?>
               
                <td>
                  <form action="{{route('question.edit',[$row->id,$tests->id,$row->course->id])}}", method="post" > 
                  @csrf
                    <button class="w-100 btn btn-primary" type="submit" name="Edit">Edit</button>
                    </form> 
                
                    <button type="button"  class="w-100 btn btn-danger"  data-toggle="modal" data-target="#exampleModal" 
                    onclick="myFunction({{$row->id}})">Delete</button></td>
            </tr>
            @endforeach
         
                    
            
  </tbody>
  
</table>
{{ $question->links() }}
</div>
@yield('modal')
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Test?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Bạn có muốn xóa không?
      </div>
      <div class="modal-footer">
      <form method="post"  action="{{ route('question.delete',$tests->id) }}" onsubmit="return ConfirmDelete( this )">
        @method('DELETE')
                    @csrf
                    <input type="hidden" name="question_id" id='question_id' value="0"><br>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <button  class="btn btn-danger" type="submit">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
@yield('js')
<script>
function myFunction(id) {

   document.getElementById("question_id").value=id;
      
     
  
}
</script>
@endsection

