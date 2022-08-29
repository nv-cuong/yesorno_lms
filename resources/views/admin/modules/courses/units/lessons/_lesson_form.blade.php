@csrf
<div class="mb-3">
    <label for="unit_id" class="form-label">Tên chương học</label>
    <select id="unit_id" name="unit_id" class="form-select @error('unit_id') is-invalid @enderror">
        <option value="">-</option>
        @forelse($unit as $id => $title)
        @if ($id == old('unit_id', $lesson->unit_id))
        <option selected="selected" value="{{ $id }}">{{ $title }}</option>
        @else
        <option value="{{ $id }}">{{ $title }}</option>
        @endif
        @empty
        @endforelse
    </select>
    @error('unit_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="lesson_tile" class="form-label">Tên bài học</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="lesson_title" value="{{ old('title', $lesson->id?$lesson->title:'') }}">
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="config" class="form-label">Loại bài học</label><br>
    <input type="radio" name="config" value="must" id="must">
    <label for="must" class="form-label">Tính tiến độ học</label><br>
    <input type="radio" name="config" value="optional" id="optional">
    <label for="optional" class="form-label">Không tính tiến độ học</label>

</div>
<div class="mb-3">
    <label for="published" class="form-label">Ngày xuất</label>
    <input type="date" name="published" class="form-control @error('published') is-invalid @enderror" id="published" value="{{ old('published', $lesson->published) }}">
    @error('published')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="path" class="form-label">Tệp bài học</label>
    <br>
    <input type="file" name="path" id="path" class="form-control @error('path') is-invalid @enderror" value="{{ old('path', $lesson->path) }}">
    @error('path')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="content" class="form-label">Nội dung bài học</label>
    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="" cols="">{{ old('content', $lesson->content) }}</textarea>
    @error('content')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>