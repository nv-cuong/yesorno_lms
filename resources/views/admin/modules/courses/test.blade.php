@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý bài test trong khóa học {{ $course->title }}</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <table class="table table-striped table-bordered table-hover table-condensed" id="test-of-course">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Loại bài kiểm tra</th>
                                    <th>Tên bài kiểm tra</th>
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


@section('scripts')
    <script type="text/javascript">
        $(function() {
            var table = $('#test-of-course').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '{{ route('course.dataTest', $course->id) }}',
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
                        data: 'title',
                        name: 'title'
                    },
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
@endsection
