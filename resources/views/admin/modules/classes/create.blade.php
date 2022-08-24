@extends('admin.layouts.master')
@section('title', 'Quàn lí lớp học')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- Thông báo ngoại lệ --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-weight:bold">Tạo lớp học mới</h3>
                        </div>
                        <form action="{{ route('class.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @include('admin.modules.classes._form')
                                <button type="submit" class="btn btn-primary">Tạo lớp</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
