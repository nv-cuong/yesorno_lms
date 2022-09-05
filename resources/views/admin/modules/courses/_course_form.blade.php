@csrf
<div class="form-group">
    <label for="course_tile">Tên khóa học</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
    id="course_title" value="{{ old('title', $course->id?$course->title:'') }}">
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label class="form-label">Loại khóa học</label>
    <div class="form-group" style="display: flex; justify-content: space-around">
        <div class="form-check ">
            <input class="form-check-input @error('status') is-invalid @enderror" type="radio" 
            name="status" value="1"
            @if ($course->status == 1)
                checked
            @endif >
            <label class="form-check-label">Tính phí</label>
        </div>
        <div class="form-check">
            <input class="form-check-input @error('status') is-invalid @enderror" type="radio" 
            name="status" value="0"
            @if ($course->status == 0)
                checked
            @endif >
            <label class="form-check-label">Miễn phí</label>
        </div>
    </div>
    @error('config')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="begin_date" class="form-label">Ngày bắt đầu</label>
    <input type="date" name="begin_date" class="form-control @error('begin_date') is-invalid @enderror" 
    value="{{ old('begin_date' , $course->begin_date) }}" id="begin_date">
    @error('begin_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="end_date" class="form-label">Ngày kết thúc</label>
    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
    id="end_date" value="{{ old('end_date', $course->end_date) }}">
    @error('end_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="image" class="form-label">Ảnh</label>
    <br>
    <img src="{{ asset($course->image) }}" class="img-thumbnail">
    <br>
    <input type="file" name="image" id="image" class="form-control">
</div>
<div class="form-group">
    <label for="description">Mô tả (Trên 20 ký tự)</label>
    <textarea name="description" id="description" class="form-control ckeditor @error('description') is-invalid @enderror" 
        cols="5" rows="3" style="visibility: hidden; display: none;">{{ old('description', $course->description) }}</textarea>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>