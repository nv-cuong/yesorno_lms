@extends('admin.layouts.master')
@section('title', 'Ngân hàng câu hỏi')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Sửa câu hỏi</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('question.update', $question->id) }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên <span style="color: red">*</span></label>
                                <input type="text" name="content" class="form-control @error('content') is-invalid @enderror" 
                                id="exampleInputEmail1" placeholder="Tên" value="{{ old('content', $question->content) }}">
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Khóa học <span style="color: red">*</span></label>
                                <select class="form-control select2 " style="width: 100%;" name="course_id">
                                    @forelse($course as $cr)
                                    @if ($cr->id == old('course_id', $question->course_id))
                                    <option selected="selected" value="{{ $cr->id }}">{{ $cr->title }}
                                    </option>
                                    @else
                                    <option value="{{ $cr->id }}">{{ $cr->title }}</option>
                                    @endif
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loại câu hỏi <span style="color: red">*</span></label>
                                <select class="form-control select2" style="width: 100%;"  id="category" disabled>
                                    <option value="0" {{ $question->category == 0 ? 'selected' : '' }}>Câu hỏi tự
                                        luận
                                    </option>
                                    <option value="1" {{ $question->category == 1 ? 'selected' : '' }}>Câu hỏi trắc
                                        nghiệm</option>
                                    <option value="2" {{ $question->category == 2 ? 'selected' : '' }}>Câu hỏi Đúng
                                        sai
                                    </option>
                                </select>
                                <input type="hidden" name="category" value="{{ $question->category }}"/>
                            </div>

                            <div class="form-group" id="check_question" style="display: none">
                                <label for="exampleInputEmail1">Đáp án <span style="color: red">*</span></label>
                                <div class="row">
                                    @forelse($answers as $key => $answer)
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="answer1[{{ $key }}]" 
                                            class="form-control @error('answer1.' . $key) is-invalid @enderror" 
                                            id="exampleInputEmail1" placeholder="Đáp án {{ $key + 1 }}" 
                                            value="{{ old('answer1.' . $key, $answer->content) }}">
                                        @error('answer1.' . $key)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <input type="checkbox" name="is_correct[{{ $key }}]" 
                                            class="@error('is_correct') is-invalid @enderror" value="1" 
                                            {{ old('is_correct.' . $key, $answer->checked) ? 'checked' : '' }}> 
                                        @error('is_correct')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="form-group clearfix" id="check_true" style="display: none">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="answer" checked id="radioDanger1" value="1" {{ $question->answer == 1 ? 'checked' : '' }}>
                                    <label for="radioDanger1">
                                        Đúng
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="answer" id="radioDanger2" value="0" {{ $question->answer == 0 ? 'checked' : '' }}>
                                    <label for="radioDanger2">
                                        Sai
                                    </label>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Điểm <span style="color: red">*</span></label>
                                <input type="number" name="score" class="form-control @error('score') is-invalid @enderror" 
                                    id="exampleInputEmail1" placeholder="Điểm" value="{{ old('score', $question->score) }}">
                                @error('score')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Sửa</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@stop

@section('scripts')
<script>
    d = document.getElementById("category").value;
    //alert(d);
    if (d == 1) {
        document.getElementById("check_question").style.display = 'block';
        document.getElementById("check_true").style.display = 'none';
    } else {
        if (d == 2) {
            document.getElementById("check_true").style.display = 'block';
            document.getElementById("check_question").style.display = 'none';
        } else {
            document.getElementById("check_true").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
        }
    }
</script>

@stop