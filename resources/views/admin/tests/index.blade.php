@extends('admin.layouts.master')
@section('title', 'Test Manager')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Test</h1>
            </div>
            
            <div class="col-sm-6">
            <form method="post" action="{{route('test.search')}}">
            @csrf
            <div class="input-group">
  <div class="form-outline">
    <input type="search" id="form1" name ="search"class="form-control"placeholder="Search...." />
  </div>
  <button type="submit" class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button>
</div>
            </form>
             <ol class="breadcrumb float-sm-right">
            <a href="{{route('test.create')}}" class="btn btn-success">
            <i class="nav-icon fas fa-solid fa-plus"></i>
             Add New</a>
</ol>
</div>
   </div>
</div>
</div>

<div class="card">
    <div class="card-header">
    Test
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                <thead>
                    <tr>
                        <th width="10">
                            ID
                        </th>
                        <th>
                        Category
                        </th>
                        <th>
                        Số câu hỏi
                        </th>
                        <th>
                        Title
                        </th>
                        <th>
                        Time
                        </th>
                        <th>
                        Description
                        </th>
                        <th>
                        
                        </th>
                    </tr>
                </thead>
                <tbody>

                @forelse($tests as $test)
                    <tr data-entry-id="{{ $test->id }}">
                        <td>
                        {{ $test->id}} 
                        </td>
                        <td>{{ $test->category}}</td>
                        <td>{{ $test->question()->get()->count()}}</td>
                        <td>{{ $test->title }}</td>
                        <td>{{$test->time}}</td>
                        <td>{{ $test->description }}</td>
                        <td>
                        @if( request('show_deleted') == 1 )
                        <form action="" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-info" >Restore</button>
                        </form>
                        <form action="" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-xs btn-danger" >  
                            Delete</button>
                        </form>
                        @else
                            <a class="btn btn-xs btn-info" href="{{route('test.edit',[$test->id])}}">
                            <i class="nav-icon fas fa-solid fa-pen"></i>    
                            Edit
                            </a>
                            @csrf
                                <button type="submit" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#exampleModal" 
                    onclick="myFunction({{$test->id}})" >
                    <i class="nav-icon fas fa-solid fa-trash"></i>  
                    Delete
                </button>
                       
                        <a class="btn btn-xs btn-success" href="{{route('test.view',[$test->id])}}">
                        <i class=" nav-icon fas fa-solid fa-eye"></i>
                                View
                            </a>
                            @csrf 
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="12">Data Not Found!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
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
      <form method="post"  action="{{ route('test.delete') }}" onsubmit="return ConfirmDelete( this )">
        @method('DELETE')
                    @csrf
                    <input type="hidden" name="test_id" id='test_id' value="0"><br>
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

   document.getElementById("test_id").value=id;  
}
</script>

@endsection



