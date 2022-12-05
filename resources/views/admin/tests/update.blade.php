@extends('admin.layouts.master')
@section('title', 'Update Test')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card-body">
        <h2>
            Update Test
        </h2>
        <form action="{{ route('test.saveUpdates', [$test->id]) }}" method="post">
            @csrf
            <div class="form-group">
                <strong>
                    Loại bài test:
                </strong>
                @php
                    if ($test->category == 0) {
                        echo 'Bài test cuối khoá';
                    } elseif ($test->category == 1) {
                        echo 'Bài test';
                    } else {
                        echo 'Bài khảo sát';
                    }
                @endphp
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">
                    Tiêu đề:
                </label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleFormControlInput1"
                    placeholder="nhập tiêu đề" name="title" value="{{ old('title') ?: $test->title }}">
                @error('title')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
                <label for="exampleFormControlInput1">
                    Thời gian làm bài (phút):
                </label>
                <input type="" class="form-control @error('time') is-invalid @enderror" id="exampleFormControlInput1"
                    placeholder="nhập thời gian làm bài" name="time" value="{{ old('time') ?: $test->time }}">
                @error('time')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">
                    Mô tả:
                </label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                    id="exampleFormControlTextarea1" rows="3">{{ $test->description }}</textarea>
                @error('description')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                Cập nhật
            </button>
        </form>
    </div>
@endsection
