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
    <a class="btn btn-info" href="{{ route('test.view', [$row->id]) }}" title="Thông tin bài test">
        <i class="far fa-eye"></i>
    </a>
    <a class="btn btn-success" href="{{ route('test.update', [$row->id]) }}" title="Sửa thông tin bài test">
        <i class="fas fa-edit"></i>
    </a>
    @csrf
    <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal"
        onclick="myFunction({{ $row->id }})" title="Xóa bài test">
        <i class="far fa-trash-alt"></i>
    </button>
    @csrf
@endif
