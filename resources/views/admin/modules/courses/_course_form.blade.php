@csrf
<div class="mb-3">
    <label for="course_tile" class="form-label">Tên khóa học</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="course_title" value="{{ old('title', $course->id?$course->title:'') }}">
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="begin_date" class="form-label">Ngày bắt đầu</label>
    <input type="date" name="begin_date" class="form-control @error('begin_date') is-invalid @enderror" value="{{ old('begin_date' , $course->begin_date) }}" id="begin_date">
    @error('begin_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="end_date" class="form-label">Ngày kết thúc</label>
    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" value="{{ old('end_date', $course->end_date) }}">
    @error('end_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="image" class="form-label">Ảnh</label>
    <br>
    <img src="{{ asset($course->image) }}" class="img-thumbnail">
    <br>
    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image', $course->image) }}">
    @error('image')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="" cols="">{{ old('description', $course->description) }}</textarea>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>