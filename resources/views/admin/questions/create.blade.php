@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thêm mới câu hỏi</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="{{ route('question.store') }}">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên câu hỏi<span style="color: red">*</span></label>
                                    <input type="text" name="content"
                                        class="form-control @error('content') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="tên" value="{{ old('content') }}">
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Khóa học <span style="color: red">*</span></label>
                                    <select class="form-control select2 " style="width: 100%;" name="course_id">
                                        @forelse($course as $cr)
                                            @if ($cr->id == old('course_id'))
                                                <option selected="selected" value="{{ $cr->id }}">{{ $cr->title }}
                                                </option>
                                            @else
                                                <option value="{{ $cr->id }}">{{ $cr->title }}</option>
                                            @endif
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('course_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Loại câu hỏi <span style="color: red">*</span></label>
                                    <select class="form-control select2 @error('category') is-invalid @enderror"
                                        style="width: 100%;" name="category" id="category">

                                        <option selected="selected" value="0">Câu hỏi tự luận</option>
                                        <option value="1" {{ old('category') == 1 ? 'selected' : '' }}>Câu hỏi nhiều lựa chọn
                                        </option>
                                        <option value="2" {{ old('category') == 2 ? 'selected' : '' }}>Câu hỏi Đúng sai
                                        </option>
                                        <option value="3" {{ old('category') == 3 ? 'selected' : '' }}>Câu hỏi trắc nghiệm
                                        </option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group" id="multiple_choice" style="display: none">
                                    <label for="exampleInputEmail1">Đáp án <span style="color: red">*</span></label>
                                    <button type="button" name="add" id="add" class="btn btn-success" title="Thêm đáp án">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                    <br><br>
                                    <input type="hidden" name="multiple_choice">
                                    @error('multiple_choice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="row" id="answer_field">
                                        @for ($idx = 0; $idx < 4; $idx++)
                                            <div class="col-md-6 form-group">
                                                <input type="text" name="answer1[{{ $idx }}]"
                                                    class="form-control @error('answer1.' . $idx) is-invalid @enderror"
                                                    id="exampleInputEmail1" placeholder="Đáp án {{ $idx + 1 }}"
                                                    value="{{ old('answer1.' . $idx) }}">
                                                @error('answer1.' . $idx)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <input type="checkbox" name="is_correct[{{ $idx }}]"
                                                    class="@error('is_correct') is-invalid @enderror" value="1"
                                                    {{ old('is_correct.' . $idx) ? 'checked' : '' }}>
                                                @error('is_correct')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div class="form-group" id="check_question" style="display: none">
                                    <label for="exampleInputEmail1">Đáp án <span style="color: red">*</span></label>
                                    <input type="hidden" name="check_question">
                                    @error('check_question')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="row">
                                        @for ($idx = 0; $idx < 4; $idx++)
                                            <div class="col-md-6 form-group">
                                                <input type="text" name="answer3[{{ $idx }}]"
                                                    class="form-control @error('answer3.' . $idx) is-invalid @enderror"
                                                    id="exampleInputEmail1" placeholder="Đáp án {{ $idx + 1 }}"
                                                    value="{{ old('answer3.' . $idx) }}">
                                                @error('answer3.' . $idx)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <input type="radio" name="is_correct"
                                                    class="@error('is_correct') is-invalid @enderror" value="{{ $idx }}"
                                                    {{ old('is_correct') ? 'checked' : '' }}>
                                                @error('is_correct')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div class="form-group clearfix" id="check_true" style="display: none">
                                    <div class="icheck-danger d-inline">
                                        <input type="radio" name="answer2" checked id="radioDanger1" value="1"
                                            {{ old('answer2') == 1 ? 'checked' : '' }}>
                                        <label for="radioDanger1">
                                            Đúng
                                        </label>
                                    </div>
                                    <div class="icheck-danger d-inline">
                                        <input type="radio" name="answer2" id="radioDanger2" value="0"
                                            {{ old('answer2') == 0 ? 'checked' : '' }}>
                                        <label for="radioDanger2">
                                            Sai
                                        </label>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Điểm <span style="color: red">*</span></label>
                                    <input type="number" name="score"
                                        class="form-control @error('score') is-invalid @enderror" id="exampleInputEmail1"
                                        placeholder="Điểm" value="{{ old('score') }}">
                                    @error('score')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop

@section('scripts')
<script>
    d = document.getElementById("category").value;
        if (d == 1) {
            document.getElementById("multiple_choice").style.display = 'block';
            document.getElementById("check_true").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
        } else if (d == 2) {
            document.getElementById("check_true").style.display = 'block';
            document.getElementById("multiple_choice").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
        }else if (d == 3) {
            document.getElementById("check_question").style.display = 'block';
            document.getElementById("check_true").style.display = 'none';
            document.getElementById("multiple_choice").style.display = 'none';
        } else {
            document.getElementById("check_true").style.display = 'none';
            document.getElementById("multiple_choice").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
        }

    document.getElementById("category").onchange = function() {
        d = document.getElementById("category").value;
        if (d == 1) {
            document.getElementById("multiple_choice").style.display = 'block';
            document.getElementById("check_true").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
        } else if (d == 2) {
            document.getElementById("check_true").style.display = 'block';
            document.getElementById("multiple_choice").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
        }else if (d == 3) {
            document.getElementById("multiple_choice").style.display = 'block';
            document.getElementById("check_true").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
        } else {
            document.getElementById("check_true").style.display = 'none';
            document.getElementById("multiple_choice").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
        }
    };
</script>
<script type="text/javascript">  
    $(document).ready(function(){
        var i=4;
        
        $('#add').click(function(){
            i++;
            $('#answer_field').append('<div class="col-md-6 form-group" id="row'+i+'">'+
            '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fas fa-times-circle"></i></button>'+
            '<input type="text" name="answer1['+ i +']" class="form-control" placeholder="Đáp án'+i+'"value="">'+
            '<input type="checkbox" name="is_correct['+ i +']"class="" value="1"</div>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id).remove();
        });
    });
</script> 
@stop
