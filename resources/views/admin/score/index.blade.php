@extends('admin.layouts.master')
@section('title', 'Điểm bài test')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý điểm bài test</h1>
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
                            <a href="{{ route('score.create') }}" class="btn btn-success float-right">
                                Tạo bài test đầu vào
                            </a>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed" id="score_table">
                            <thead>
                                <tr>
                                    <th>
                                        STT
                                    </th>
                                    <th>
                                        Tên học viên
                                    </th>
                                    <th>
                                        Tên bài test
                                    </th>
                                    <th>
                                        Điểm / Điểm tối đa
                                    </th>
                                    <th>
                                        Trạng thái
                                    </th>
                                    <th>
                                        Hành động
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function() {
            var table = $('#score_table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '/admin/score/data',
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'test_id',
                        name: 'test_id'
                    },
                    {
                        data: 'score',
                        name: 'score'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
            var url = "{{ route('question.answer', ':an') }}",
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
