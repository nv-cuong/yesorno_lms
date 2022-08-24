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
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('question.create') }}" class="btn btn-success float-right">+ Tạo lớp học mới</a>
                        </div>

                        <table class="table table-striped" id="DataList">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên lớp</th>
                                    <th>Tên khóa học</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="load">

                            </tbody>
                        </table>

                        
                    </div>
                </div>
            </div>
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
        ],
        buttons: [ 'csv', 'excel', 'pdf', 'print' ]
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
