@extends('admin.layouts.master')
@section('title', 'Chi tiết lớp học')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <br>
            @include('admin._alert')
            <div class="row">
                <div class="col-12">
                    <div class="invoice p-3 mb-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <div class="card collapsed-card">
                                    <div class="card-header" style="font-size:1.3em">
                                        <strong><span style="color: rgb(163, 0, 0)">Tên lớp:
                                            </span>{{ $class->name }}</strong><br><br>
                                        <i class="fas fa-info" style="font-size:1.4em"></i>
                                        <span style="color: rgb(0, 85, 196)">Mô tả lớp học: </span>
                                        {!! $class->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <div class="card collapsed-card">
                                    <div class="card-header" style="font-size:1.3em">
                                        <strong><span style="color: rgb(163, 0, 0)">Các khóa học: </span></strong><br>
                                    </div>
                                    @foreach ($class->courses as $item)
                                        <div class="card collapsed-card">
                                            <div class="card-header" style="font-size:1.3em">
                                                <i class="fas fa-book" style="font-size:1.4em"></i>
                                                {{ $item['title'] }}
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <ul class="nav nav-pills flex-column">
                                                    <li class="nav-item">
                                                        <div class="p-3">
                                                            <i class="bi bi-journal-bookmark-fill"
                                                                style="font-size:1.2em">Mô tả khóa học: </i>
                                                            {!! $item->description !!}
                                                            <br>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <div class="card collapsed-card">
                                    <div class="card-header" style="font-size:1.3em">
                                        <strong><span style="color: rgb(163, 0, 0)">Học viên:</strong>
                                        <br><br>
                                        <i class="fas fa-users" style="font-size:1.4em"></i>
                                        <span style="color: rgb(0, 85, 196)">Sỹ số lớp học: </span>
                                        {{ $class->users->count() }}
                                        <br><br>
                                        <i class="fas fa-clock" style="font-size:1.4em"></i>
                                        <span style="color: rgb(0, 85, 196)">Thời gian học: </span>
                                        @if ($class->amount == 0)
                                            Sáng
                                        @elseif($class->amount == 1)
                                            Chiều
                                        @else
                                            Cả ngày
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <label for="">Danh sách sinh viên trong lớp</label>
                                    <a href="{{ route('class.add', $class->slug) }}"
                                        class="btn btn-success float-right">Thêm học viên</a>
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
                                        @forelse ($class->users as $item)
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
