@extends('admin.layouts.master')
@section('title', 'Quản lí khóa học')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản lý khóa học</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Loại bài kiểm tra</th>
                                <th>Tên bài kiểm tra</th>
                            </tr>
                        </thead>
                        <tbody id="load">
                            @forelse($tests as $test)
                            <tr>
                                <td>{{ $test->id }}</td>
                                <td>{{ $test->category }}</td>
                                <td>{{ $test->title}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">Không có bài test!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        {{-- {!! $tests->appends(Request::all())->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection


@section('scripts')
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection