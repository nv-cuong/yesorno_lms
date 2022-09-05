@extends('admin.layouts.master')
@section('title', 'Quàn lí lớp học')

@section('content')
    <br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-weight:bold">Tạo lớp học mới</h3>
                        </div>
                        <form action="{{ route('class.store') }}" method="POST">
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
