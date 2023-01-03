@extends('admin.layouts.master')
@section('title', 'Create Test')
@section('content')
    @include('admin.tests.bootstrap5')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h2>
                        Tạo bài Test
                    </h2>
                    @include('admin/_alert')
                    <form action="{{ route('test.store') }}" method="post">
                        @csrf
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">
                                Tiêu đề
                            </label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Nhập tiêu đề">
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label for="exampleFormControlInput1">
                                Loại bài test
                            </label>
                            <select class="form-control @error('category') is-invalid @enderror category" id="id"
                                name="category" data-dependent="question" data-placeholder="Loại bài test:">
                                <option value="">-</option>
                                <option value="0">Bài thi cuối khoá</option>
                                <option value="1">Bài thi</option>
                                <option value="2">Khảo sát</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label for="exampleFormControlInput1">
                                Thời gian làm bài(phút):
                            </label>
                            <input type="number" class="form-control @error('time') is-invalid @enderror"
                                value="{{ old('time') }}" id="time" placeholder="Nhập thời gian làm bài"
                                name="time">
                            @error('time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">
                                Nhập mô tả:
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}"
                                name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="confirmation_pwd">
                                Chọn Khóa học:
                            </label>
                            <select class="js-example-placeholder-single js-states form-control"
                            {{-- class="form-control @error('course') is-invalid @enderror course select2_select"  --}}
                            id="course"
                                name="course" data-dependent="question">
                                <option value="">-</option>
                                @forelse($course as $key => $item)
                                    <option value="{{ $key }}">
                                        {{ $item->title }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('course')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirmation_pwd">
                                Chọn câu hỏi:
                            </label>
                            <select class="form-select  @error('question') is-invalid @enderror question"
                                id="multiple-select-clear-field" name="question[]" data-dependent="course" multiple>

                            </select>
                            @error('question')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" name="count_question_id" id='count_question_id' value="0"><br>
                        <button type="submit" class="btn btn-primary">
                            Tạo bài Test
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function matcher(term, text) {
            var has = true;
            var words = term.toUpperCase().split(" ");
            for (var i = 0; i < words.length; i++) {
                var word = words[i];
                has = has && (text.toUpperCase().indexOf(word) >= 0);
            }
            return has;
        }
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
            }
        }).on("change", function(e) {
            $('.multiple-select-clear-field li:not(.select2-search--inline)').hide();
            $('.counter').remove();
            var counter = $(".select2-selection__choice").length;
            $('.select2-selection__rendered').after(
                '<div style="line-height: 28px; padding: 5px;" class="counter">Nội dung tìm kiếm:</div>');
            $('.select2-selection__rendered').after(
                '<div style="line-height: 28px; padding: 5px;" class="counter">Số câu hỏi đã chọn : ' +
                counter +
                '</div>');
            var searchfield = $(this).parent().find('.select2-search__field');
            document.getElementById("count_question_id").value = counter;
        });
        $(document).ready(function() {
            $('.js-example-placeholder-single').select2({
                placeholder: "Chọn Khóa học:",
                allowClear: true
            });
        });
    </script>
@endsection
