@extends('admin.layouts.master')
@section('title', 'Class Manager')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Danh sách học viên</h2>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right"
                                placeholder="Tìm kiếm...">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sinh viên</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Ngày sinh</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)

                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td class="text-end col-1">{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td class="text-end col-2">{{ $user->phone }}</td>
                                    <td class="text-end col-5">{{ $user->address }}</td>
                                    <td class="text-end col-2">{{ $user->birthday }}</td>
                                    <td class="text-end col-2">
                                        <a href="" class="btn btn-xs btn-info mb-1">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('user.edit', [$user->id]) }}" class="btn btn-xs btn-info mb-1">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="" class="btn btn-xs btn-danger mb-1">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a href="" class="btn btn-xs btn-warning mb-1">
                                            Khóa
                                        </a>
                                        <a href="" class="btn btn-xs btn-success mb-1">
                                            Lớp
                                        </a>
                                </tr>
                            @empty
                                <tr>
                                    <td class="col-6">Không có học sinh nào</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">«</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">»</a></li>
        </ul>
    </div>
@endsection
