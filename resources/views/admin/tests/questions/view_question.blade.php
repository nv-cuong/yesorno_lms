@extends('admin.layouts.master')
@section('title', 'View Question')
@section('content')
@foreach($question as $row1)
    @endforeach
 
<?php static $k=1?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Danh sách câu hỏi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
    
    @csrf
    <a href ="{{ route('test.create_question',[$row1->course->id,$tests->id,$arr_question])}}" class="btn btn-success">
      <i class="nav-icon fas fa-solid fa-plus"></i>
    Thêm câu hỏi</a>
    
    </div>
    </div>
<div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Location">
  <thead>
    <tr>
      <th >ID</th>
      <th>Test</th>
       <th>Chương</th> 
      <th >Nội dung câu hỏi</th>
      <th >edit or delete</th>
    </tr>
  </thead>
  <tbody>

  @foreach($question as $row)
            <tr>
                <td>{{$row->id}}</td> 
                <td>{{$tests->id}}</td>
                
                <td><?php echo"$k. "?>{{$row->content}}</td>
                <?php $k++;
                ?>
               <td>{{$row->course->id}}. {{$row->course->title}}</td>
                <td>
                 
                  <a href ="{{route('question.edit',[$row->id,$tests->id,$row->course->id])}}" class="btn btn-xs btn-info" name="Edit">
                    <i class="nav-icon fas fa-solid fa-pen"></i>    
                            Edit</a>
                    <button type="button"  class="btn btn-xs btn-danger"  data-toggle="modal" data-target="#exampleModal" 
                    onclick="myFunction({{$row->id}})">
                    <i class="nav-icon fas fa-solid fa-trash"></i> 
                    Delete</button>
                  </td>
                  
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

