@extends('admin.layouts.master')
@section('title', 'Quản lí lớp học')

@section('content')
<br>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-weight:bold">Thêm học viên mới</h3>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ</th>
                                        <th>Tên</th>
                                        <th>E-mail</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th></th>
                                        <th>Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stds as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->last_name }}</td>
                                        <td>{{ $item->first_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->birthday }}</td>
                                        <td>{{ $item->gender }}</td>
                                        <td>
                                            <input type="checkbox" id="" name="" value=""
                                            @foreach ($std as $item2) @if ($item->id == $item2->id) checked
                                            @endif @endforeach >
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">Chưa có sinh viên</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Thêm hết</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection