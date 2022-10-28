@if (request('show_deleted') == 1)
    <form action="" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
        @csrf
        <button type="submit" class="btn btn-xs btn-info">
            Restore
        </button>
    </form>
    <form action="" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-xs btn-danger">
            Delete
        </button>
    </form>
@else
    <a class="btn btn-primary" href="{{ route('test.view', [$row->id]) }}">
        <i class="far fa-eye"></i>
    </a>
    <a class="btn btn-success" href="{{ route('test.edit', [$row->id]) }}">
        <i class="fas fa-edit"></i>
    </a>
    @csrf
    <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal"
        onclick="myFunction({{ $row->id }})">
        <i class="nav-icon fas fa-solid fa-trash"></i>
    </button>
    @csrf
@endif
