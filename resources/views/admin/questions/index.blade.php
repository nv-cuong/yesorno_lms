@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                @include('admin/_alert')
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <h2>Laravel DataTables Tutorial Example</h2>
            <a href="{{ route('question.create') }}" class="btn btn-success pull-right themhocvien "> <span>Thêm mới </span></a>
            <div class="table-responsive">
                <table class="table table-bordered" id="DataList">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                </table>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
</section>
@stop
@section('scripts')

<script type="text/javascript">
    $(function() {
        $('#DataList').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('question.getData') !!}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'content',
                    name: 'content'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });
    });
</script>
@stop