@extends('admin.layouts.master')
@section('title', 'Quàn lí lớp học')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách lớp học</h1>
                </div>
                <div class="col-sm-6 ">
                    <form action="" class="form-inline justify-content-end">
                        <div class="form-group">
                            <input type="text" class="form-control" name="key" placeholder="Tìm kiếm theo tiêu đề...">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
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
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('class.create') }}" class="btn btn-success float-right">+ Tạo lớp học mới</a>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên lớp</th>
                                    <th>Tên khóa học</th>
                                    <th>Mô tả</th>
                                    <th>Học viên</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="load">

                            </tbody>
                        </table>

                        <div class="card-footer clearfix">
                            {{-- {!! $listAr->appends(Request::all())->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
