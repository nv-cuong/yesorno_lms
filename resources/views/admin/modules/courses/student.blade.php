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
        @include('admin/_alert')
        <hr>
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
                                <th>Tên học viên</th>
                                <th>Email</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody id="load">
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email}}</td>
                                @if($user->status == 0)
                                <td><a href="" data-toggle="modal" data-target="#activeModal" onclick="javascript:user_active('{{ $user->id }}')">Chấp nhận</a></td>
                                @else
                                <td><a href="" data-toggle="modal" data-target="#activeModal" onclick="javascript:user_active('{{ $user->id }}')">Hủy chấp nhận</a></td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">Không có học viên!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        {{-- {!! $users->appends(Request::all())->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade show" id="activeModal" style="display: hidden; padding-right: 12px;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activeModalLabel">Chấp nhận học viên!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" action="{{ route('course.active', $course->id) }}">
                @csrf
                <input type="hidden" name="user_id" id="user_id" value="0">
                <div class="modal-body">
                    <p>Bạn có đồng ý thêm học viên vào khóa học?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Đồng ý</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

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

<script>
    function user_active(id) {
        var user_id = document.getElementById('user_id');
        user_id.value = id;
    }
</script>
@endsection