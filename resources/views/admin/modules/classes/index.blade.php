@extends('admin.layouts.master')
@section('title', 'Class Manager')

@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Danh sách lớp học</h2>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm kiếm...">

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
                <th>Tên lớp</th>
                <th>Mô tả khóa học</th>
                <th>Số lượng học viên</th>
                <th>Ngày tao</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>183</td>
                <td>PHP cơ bản</td>
                <td>Khóa học php cho người bắt đầu</td>
                <td><span class="tag tag-success">50</span></td>
                <td>20-02-2022</td>
              </tr>

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
