@extends('admin.layouts.master')
@section('title', 'Bài test')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    @include('admin/_alert')
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <h2>
                        Quản lí bài test
                    </h2>
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('test.create') }}" class="btn btn-success float-right">
                                <i class="nav-icon fas fa-solid fa-plus">
                                    Tạo bài test
                                </i>
                            </a>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed" id="testId">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Loại
                                    </th>
                                    <th>
                                        Khoá học
                                    </th>
                                    <th>
                                        Số câu hỏi
                                    </th>
                                    <th>
                                        Điểm tối đa
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
                            <tbody id="load">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('scripts')
    <script type="text/javascript">
        $(function() {
            var table = $('#testId').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '/admin/test/data',
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'questions_count',
                        name: 'questions_count',
                        searchable: false
                    },
                    {
                        data: 'total_score',
                        name: 'total_score',
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'time',
                        name: 'time'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            table.on('draw', function() {
                $('.livicon').each(function() {
                    $(this).updateLivicon();
                });
            });
            table.on('order.dt search.dt', function() {
                let i = 1;
                table.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
        });
    </script>
    <script>
        function myFunction(id) {
            document.getElementById("test_id").value = id;
        }
    </script>
@endsection

@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Xóa bài test?
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa không?
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('test.delete') }}" onsubmit="return ConfirmDelete( this )">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="test_id" id='test_id' value="0"><br>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            không
                        </button>
                        <button class="btn btn-danger" type="submit">
                            Đồng ý
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
