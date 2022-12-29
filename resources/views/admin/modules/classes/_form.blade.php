@csrf
<div class="form-group">
    <label for="">Tên lớp học <span style="color: red">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
        value="{{ old('name', $class->name) }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-sm-12">
    <div class="form-group">
        <label for="">Khóa học <span style="color: red">*</span></label>
        @foreach ($courses as $item1)
            <div class="form-check">
                <input class="form-check-input @error('course_id') is-invalid @enderror" type="checkbox"
                    name="course_id[]" value="{{ $item1->id }}"
                    @foreach ($course as $item2) @if ($item1->id == $item2->id)
                        checked
                    @endif @endforeach>
                <label class="form-check-label">{{ $item1->title }}</label>
            </div>
        @endforeach
        @error('course_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group">
    <label for="begin_date" class="form-label">
        Ngày bắt đầu
    </label>
    <input type="date" name="begin_date" class="form-control @error('begin_date') is-invalid @enderror"
        value="{{ old('begin_date', $class->begin_date) }}" id="begin_date">
    @error('begin_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group">
    <label for="end_date" class="form-label">
        Ngày kết thúc
    </label>
    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
        value="{{ old('end_date', $class->end_date) }}">
    @error('end_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group">
    <label for="">Mô tả (nếu có)</label>
    <textarea name="description" class="form-control ckeditor @error('description') is-invalid @enderror" cols="5"
        rows="3" style="visibility: hidden; display: none;">{{ old('description', $class->description) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
