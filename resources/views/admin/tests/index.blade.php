@extends('admin.layouts.master')
@section('title', 'Test Manager')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                @include('Admin/_alert')
            </div>

        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <h2>Quản lí bài test</h2>
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('test.create')}}" class="btn btn-success float-right"><i
                                class="nav-icon fas fa-solid fa-plus"> Tạo bài test</i></a>
                    </div>

                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th width="10">
                                    ID
                                </th>
                                <th>
                                    Loại
                                </th>
                                <th>
                                    Kháo học
                                </th>
                                <th>
                                    Số câu hỏi
                                </th>
                                <th>
                                    Tiêu đề
                                </th>
                                <th>
                                    Thời gian
                                </th>
                                <th>
                                    Mô tả
                                </th>
                                <th>
                                    Tùy chọn
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
                                @foreach($test->question as $question)
                                <td>{{ $question->course->title}}</td>
                                @break
                                @endforeach
                                <td>{{ $test->question()->get()->count()}}</td>
                                <td>{{ $test->title }}</td>
                                <td>{{$test->time}}</td>
                                <td>{{ $test->description }}</td>
                                <td>
                                    @if( request('show_deleted') == 1 )
                                    <form action="" method="POST" onsubmit="return confirm('Are you sure ?');"
                                        style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-info">Restore</button>
                                    </form>
                                    <form action="" method="POST" onsubmit="return confirm('Are you sure ?');"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            Delete</button>
                                    </form>
                                    @else
                                    <a class="btn btn-primary" href="{{route('test.view',[$test->id])}}">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a class="btn btn-success" href="{{route('test.edit',[$test->id])}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @csrf
                                    <button type="submit" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModal" onclick="myFunction({{$test->id}})">
                                        <i class="nav-icon fas fa-solid fa-trash"></i>
                                    </button>
                                    @csrf
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="12">Chưa có dữ liệu!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@stop
@section('scripts')
<script type="text/javascript">
$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "oLanguage": {
               "sInfo" : "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ bài test",// text you want show for info section
               "sSearch":"Tìm kiếm",
               "oPaginate":{
                "sPrevious":"Trước",
                "sNext":"Tiếp",
               }
            },
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
</script>

@yield('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xóa bài Test?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có muốn xóa không?
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('test.delete') }}" onsubmit="return ConfirmDelete( this )">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="test_id" id='test_id' value="0"><br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">không</button>

                    <button class="btn btn-danger" type="submit">Đồng ý</button>
                </form>
            </div>
        </div>
    </div>
</div>
@yield('js')

<script>
function myFunction(id) {

    document.getElementById("test_id").value = id;
}
</script>
@endsection