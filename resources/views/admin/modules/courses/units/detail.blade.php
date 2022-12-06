@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lí khóa học</h1>
                </div>
            </div>
            @include('admin._alert')
            <hr>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if ($unit)
                        <h3>Tên khóa học: <strong>{{ $unit->title }}</strong></h3>
                    @endif
                    <h4>Danh sách bài học</h4>
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('lesson.create', ['unit_id' => $unit->id]) }}"
                                class="btn btn-success float-right">Thêm bài học mới</a>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-condensed" id="lesson_table">
                            <thead>
                                <tr>
                                    <th>
                                        STT
                                    </th>
                                    <th>
                                        Tên bài học
                                    </th>
                                    <th>
                                        Nội dung
                                    </th>
                                    <th style="width: 20%;">
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
    </section>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade show" id="deleteModal" style="display: hidden; padding-right: 12px;" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xóa bài học!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="{{ route('lesson.delete', ['unit_id' => $unit->id]) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="lesson_id" id="lesson_id" value="0">
                    <div class="modal-body">
                        Bạn có chắc muốn xóa bài học này?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Đồng ý</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            var table = $('#lesson_table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: "{!! route('lesson.data', [$unit->id]) !!}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'content',
                        name: 'content'
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

        function lesson_delete(id) {
            var lesson_id = document.getElementById('lesson_id');
            lesson_id.value = id;
        }
    </script>
@endsection
