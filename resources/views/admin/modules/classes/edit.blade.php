@extends('admin.layouts.master')
@section('title', 'Cập nhật lớp học')

@section('content')

<br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-weight:bold">Chỉnh sửa lớp học</h3>
                        </div>
                        <form action="{{ route('class.update', $class->id) }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @method("PUT")
                                @include('admin.modules.classes._form')
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
