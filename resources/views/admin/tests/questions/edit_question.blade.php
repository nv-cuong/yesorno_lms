@extends('admin.layouts.master')
@section('title', 'Cập nhật câu hỏi')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card-body">
        <h2>Đổi câu hỏi</h2>
        <form action="{{ route('test.question.update', [$test->id, $question->id]) }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="confirmation_pwd">Câu hỏi:</label>
                <select class="form-control course" id="id" name="question" data-dependent="question">
                    <option value="{{ $question->id }}">
                        {{ $question->id . '. ' . $question->content . ' [' . $categories[$question->category] . ']' }}
                    </option>
                    @foreach ($question_old as $row)
                        <option value="{{ $row->id }}">
                            {{ $row->id . '. ' . $row->content . ' [' . $categories[$question->category] . ']' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                Cập nhật câu hỏi
            </button>
        </form>
    </div>
@endsection
