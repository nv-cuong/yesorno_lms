@extends('admin.layouts.master')
@section('title', 'Test Manager')
@section('content')
<link href='https://cdn.jsdelivr.net/gh/startinhit/font-awesome/css/all.css' rel='stylesheet'/>
    <div class="title d-flex justify-content-between">
        <h3 class="page-title">Test</h3>
        <p >
            <a href="{{route('test.create')}}" class="btn btn-success">
            <i class="fa-solid fa-plus"></i>Add New</a>
            
        </p>
   </div>

    <p class="m-0">
        <ul class="d-flex list-unstyled" style="column-gap: 1rem">
            <li><a href="" style="font-weight: 700">All</a></li> |
            <li><a href="" style="font-weight: 700">Trash</a></li>
        </ul>
    </p>

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
                        Amount
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
                        Result
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
                        <td>{{ $test->amount}}</td>
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
                            <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                        </form>
                        @else
                            <a class="btn btn-xs btn-info" href="{{route('test.edit',[$test->id])}}">
                            
                                Edit
                            </a>
                            @csrf
                                <button type="submit" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#exampleModal" 
                    onclick="myFunction({{$test->id}})" >Delete</button>
                       
                        <a class="btn btn-xs btn-success" href="{{route('test.view',[$test->id])}}">
                            
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
            {{ $tests->links() }}
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



