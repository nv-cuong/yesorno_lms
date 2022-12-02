@extends('admin.layouts.master')
@section('title', 'Thêm câu hỏi trong test')
@section('content')
    @include('admin.tests.bootstrap5')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card-body">
        <h2>
            Thêm câu hỏi mới vào bài test:
        </h2>
        <form action="{{ route('test.store_question', $testId) }}" method="post">
            @csrf
            {{ csrf_field() }}
            <div class="form-group">
                <label for="confirmation_pwd">
                    {{ 'Khóa học: ' . $courses->title }} ({{ 'ID: ' . $courses->id }})
                </label>
            </div>
            <input type="hidden" name="count_question_id" id='count_question_id' value="0">
            <br>
            <div class="form-group">
                <label for="exampleFormControlSelect1">
                    Chọn câu hỏi:
                </label>
                <select class="form-select @error('question') is-invalid @enderror question"
                    id="multiple-select-clear-field" name="question[]" data-dependent="course" multiple>
                    @foreach ($questions as $row)
                        <option value="{{ $row->id }}">
                            {{ $row->id . '. ' . $row->content . ' ' }}[{{ $q_categories[$row->category] }}]
                        </option>
                    @endforeach
                </select>
                @error('question')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                Thêm câu hỏi
            </button>
        </form>
    </div>
    <script type="text/javascript">
        $('#multiple-select-clear-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
            allowClear: true,
            placeholder: ' Nhập nội dung cần tìm',
            language: {
                noResults: function(params) {
                    return "Không có câu hỏi nào.";
                },
            },
        }).on("change", function(e) {

            $('.multiple-select-clear-field li:not(.select2-search--inline)').hide();
            $('.counter').remove();
            var counter = $(".select2-selection__choice").length;
            $('.select2-selection__rendered').after(
                '<div style="line-height: 28px; padding: 5px;" class="counter"> Nhập nội dung tìm kiếm:</div>');
            $('.select2-selection__rendered').after(
                '<div style="line-height: 28px; padding: 5px;" class="counter"> Số câu hỏi đã chọn : ' +
                counter +
                '</div>');
            document.getElementById("count_question_id").value = counter;
        });
    </script>

@endsection
