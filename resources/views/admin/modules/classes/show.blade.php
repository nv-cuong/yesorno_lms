@extends('admin.layouts.master')
@section('title', 'Chi tiết lớp học')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <br>

                    <div class="invoice p-3 mb-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <address>
                                    <strong><span style="color: rgb(163, 0, 0)">Tên lớp: </span>{{ $class->name }}</strong><br>
                                    <span style="color: rgb(0, 85, 196)">Mô tả lớp học: </span>
                                    {!! $class->description !!}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                @foreach ($course as $item)
                                <address>
                                    <strong><span style="color: rgb(163, 0, 0)">Tên khóa học: </span>{{ $item->title }}</strong><br>
                                    <span style="color: rgb(0, 85, 196)">Mô tả khóa học: </span>
                                    {!! $item->description !!}
                                </address>
                                @endforeach
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b><span style="color: rgb(163, 0, 0)">Học viên: </span></b><br>
                                <br>
                                <span style="color: rgb(0, 85, 196)">Sỹ số lớp học: </span>
                                {{ $std->count() }}
                                <br>
                                <span style="color: rgb(0, 85, 196)">Thời gian học: </span>
                                @if ($class->amount == 0)
                                    Sáng
                                @elseif($class->amount == 1)
                                    Chiều
                                @else
                                    Cả ngày
                                @endif
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <label for="">Danh sách sinh viên trong lớp</label>
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Họ</th>
                                            <th>Tên</th>
                                            <th>E-mail</th>
                                            <th>Số điện thoại</th>
                                            <th>Giới tính</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($std as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->last_name }}</td>
                                            <td>{{ $item->first_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->gender }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6">Chưa có sinh viên đăng kí lớp học</td>
                                        </tr>
                                        @endforelse



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
