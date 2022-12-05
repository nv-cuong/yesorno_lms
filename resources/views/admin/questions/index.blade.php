@extends('admin.layouts.master')
@section('title', 'Question')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ngân hàng câu hỏi</h1>
                </div>
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
                            <a href="{{ route('question.create') }}" class="btn btn-success float-right">
                                Tạo câu hỏi
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('question.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="form-control @error('import') is-invalid @enderror " name="import">
                                <br>
                                <button type="submit" class="btn btn-success" >Import Question Data</button>
                                    <a class="btn btn-warning" href="{{ route('question.export') }}">Export Question Data</a>
                                    <a class='btn btn-warning' href="{{ route('question.importform') }}">Download Import Form</a>
                            @error('import')
                                        <div style="font-size:20px;" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </form>
                        </div>   
                        <table class="table table-striped table-bordered table-hover table-condensed" id="question">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên câu hỏi</th>
                                    <th>Tên khóa học</th>
                                    <th>Loại câu hỏi</th>
                                    <th>Câu trả lời</th>
                                    <th>Điểm</th>
                                    <th>Hành động</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">
                        Xóa câu hỏi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <form method="post" action="{{ route('question.delete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="question_id" id="question_id" value="0">
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xoá không?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Không
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Có
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- xem câu trả lời -->
    <div class="modal fade" id="modal_answer">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2>
                        Danh sách Câu trả lời
                    </h2>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-condensed" id="show_answer">
                            <thead>
                                <tr>
                                    <th class="th-sortable text-center" data-toggle="class">
                                        Câu trả lời
                                    </th>
                                    <th class="th-sortable text-center" data-toggle="class">
                                        Check
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script type="text/javascript">
        $(function() {
            var table = $('#question').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '/admin/questions/data',
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'content',
                        name: 'content'
                    },
                    {
                        data: 'course_id',
                        name: 'course_id'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'answers',
                        name: 'answers'
                    },
                    {
                        data: 'score',
                        name: 'score'
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

        function question_delete(id) {
            var question_id = document.getElementById('question_id');
            question_id.value = id;
        }

        function answer_qu(an) {
            var url = "{!! route('question.answer', ':an') !!}",
                url = url.replace(':an', an);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $('#show_answer tbody').html(data);
                    $('#modal_answer').modal('show');

                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@stop
