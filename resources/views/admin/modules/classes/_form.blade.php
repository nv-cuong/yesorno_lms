@csrf
<div class="form-group">
    {{-- <input type="hidden" name="id" value="{{$item->id}}"> --}}
    <label for="">Tên lớp học</label>
    <input type="text" class="form-control" name="name">
</div>
<div class="col-sm-6">
    <!-- checkbox -->
    <div class="form-group">
        <label for="">Khóa học</label>
        @foreach ($courses as $course)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="vehicle1" name="course_id[]"
                    value="{{ $course->id }}">
                <label class="form-check-label">{{ $course->title }}</label>
            </div>
        @endforeach
    </div>
</div>
<div class="form-group">
    <label for="">Mô tả</label>
    <textarea name="description" class="form-control ckeditor" cols="5" rows="3"
        style="visibility: hidden; display: none;"></textarea>
</div>
<div class="form-group">
    <label for="">Thời gian học (buổi)</label>
    <input type="text" class="form-control" name="amount">
</div>
