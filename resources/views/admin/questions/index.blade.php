@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
            @include('Admin/_alert')
            </div><!-- /.col -->
            
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <h2>Laravel DataTables Tutorial Example</h2>
        <div class="card-header">
        <a  href="{{ route('question.create') }}" class="btn btn-success justify-content-end " > <span>Thêm mới </span></a>
        </div>
  
</a>
        <div class="table-responsive">
       
            <table class="table table-bordered" id="DataList">
               <thead>
                  <tr>
                     <th>Id</th>
                     <th>Name</th>
                     <th>Action</th>
                  </tr>
                 
               </thead>
            </table>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@stop
@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModalQuestion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('question.delete') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="question_id" id="question_id" value="0">
      <div class="modal-body">
        Are you Delete ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-primary">Yes</button>
      </div>
      </form>
    </div>
  </div>
</div>
@stop
@section('scripts')

<script type="text/javascript">
$(function() {
    $('#DataList').DataTable({
        processing: true,
        serverSide: true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        ajax: "{!! route('question.getData') !!}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'content', name: 'content' },
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
});

    </script>
    
  <script type="text/javascript">
    
function question_delete (id)
  {
      var question_id = document.getElementById('question_id');
      question_id.value = id;
  }
</script>
@stop
