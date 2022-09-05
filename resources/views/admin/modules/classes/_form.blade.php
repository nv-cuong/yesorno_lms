@csrf
<div class="form-group">
    {{-- <input type="hidden" name="id" value="{{$item->id}}"> --}}
    <label for="">Tên lớp học</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
        value="{{ old('name', $class->name) }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-sm-6">
    <!-- checkbox -->

    <div class="form-group">
        <label for="">Khóa học</label>
        @foreach ($courses as $item1)
            <div class="form-check">
                <input class="form-check-input @error('course_id') is-invalid @enderror" type="checkbox" id="vehicle1"
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
    <label for="">Mô tả (Trên 20 ký tự)</label>
    <textarea name="description" class="form-control ckeditor @error('description') is-invalid @enderror" cols="5"
        rows="3" style="visibility: hidden; display: none;">{{ old('description', $class->description) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-sm-6">
    <!-- radio -->
    <label>Thời gian học</label>
    <div class="form-group" style="display: flex; justify-content: space-between">
        <div class="form-check ">
            <input class="form-check-input @error('schedule') is-invalid @enderror" type="radio" name="schedule"
                value="0" @if ($class->schedule == 0) checked @endif>
            <label class="form-check-label">Sáng</label>
        </div>
        <div class="form-check">
            <input class="form-check-input @error('schedule') is-invalid @enderror" type="radio" name="schedule"
                value="1" @if ($class->schedule == 1) checked @endif>
            <label class="form-check-label">Chiều</label>
        </div>
        <div class="form-check">
            <input class="form-check-input @error('schedule') is-invalid @enderror" type="radio" name="schedule"
                value="2" @if ($class->schedule == 2) checked @endif>
            <label class="form-check-label">Cả ngày</label>
        </div>
    </div>
    @error('schedule')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
