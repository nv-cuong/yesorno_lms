@extends('admin.layouts.master')
@section('title', 'Create Test')
@section('content')
<meta name="csrf-token" content="{{csrf_token()}}">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h2>Create Test</h2>
                <form action="{{ route('test.store') }}" method="post">
                    @csrf
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tiều đề</label>
                        <input type="" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="nhập tiêu đề">
                        @error('title')

                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="exampleFormControlInput1">Time</label>
                        <input type="" class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}" id="" placeholder="nhập thời gian làm bài" name="time">
                        @error('time')

                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Nhập Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                        @error('description')

                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="confirmation_pwd">Chọn Course:</label>
                        <select class="form-control @error('course') is-invalid @enderror course" id="id" name="course" data-dependent="question">
                            <option value="">-</option>
                            @forelse($course as $id => $title)-
                            <option value="{{ $id }}">{{$id}}. {{ $title }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('course')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="tab-content s2bs5-example" id="multiple-select-clear-content">
                        <div class="tab-pane fade show active" id="multiple-select-clear-ltr-content" role="tabpanel" aria-labelledby="multiple-select-clear-ltr-tab">
                            <div dir="ltr">
                                <div class="form-group">
                                    <label for="confirmation_pwd">Select Question</label>

                                    <select class="form-select question" id="multiple-select-clear-field" name="question[]" data-dependent="course" data-placeholder="Choose question" multiple>
                                        <option value="">Selete Course first</option>
                                    </select>
                                    @error('question')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="count_question_id" id='count_question_id' value="0"><br>

                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
                                <link rel="stylesheet" href="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/css/docs.css" />
                                <link rel="stylesheet" href="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/css/rtl.css" />
                                <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/anchor-js/anchor.min.js"></script>

                                <script src="https://apalfrey.github.io/select2-bootstrap-5-theme/assets/js/docs.js"></script>



                                <script src="/ajax/ajaxadd.js" type="text/javascript"></script>

                                <button type="submit" class="btn btn-primary">Tạo bài Test</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#multiple-select-clear-field').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
        allowClear: true,
    }).on("change", function(e) {

        $('.multiple-select-clear-field li:not(.select2-search--inline)').hide();
        $('.counter').remove();
        var counter = $(".select2-selection__choice").length;
        $('.select2-selection__rendered').after('<div style="line-height: 28px; padding: 5px;" class="counter"> Nhập nội dung tìm kiếm:</div>');
        $('.select2-selection__rendered').after('<div style="line-height: 28px; padding: 5px;" class="counter"> Số câu hỏi đã chọn : ' + counter + '</div>');
        document.getElementById("count_question_id").value = counter;
    });
    $('#multiple-select-clear-field1').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
        allowClear: true,
    }).on("change", function(e) {

        $('.multiple-select-clear-field1 li:not(.select2-search--inline)').hide();
        $('.counter').remove();
        var counter = $(".select2-selection__choice").length;
        $('.select2-selection__rendered1').after('<div style="line-height: 28px; padding: 5px;" class="counter"> Nhập nội dung tìm kiếm:</div>');
        $('.select2-selection__rendered1').after('<div style="line-height: 28px; padding: 5px;" class="counter"> Số câu hỏi đã chọn : ' + counter + '</div>');
        document.getElementById("count_question_id").value = counter;
    });
</script>
<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script type="text/javascript">
</script>


@endsection