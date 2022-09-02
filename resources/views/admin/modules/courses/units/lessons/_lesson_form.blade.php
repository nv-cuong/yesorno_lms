@csrf
<div class="form-group">
    <label for="unit_id" class="form-label">Tên chương học</label>
    <select id="unit_id" name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
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
<div class="form-group">
    <label for="lesson_tile" class="form-label">Tên bài học</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="lesson_title" value="{{ old('title', $lesson->id?$lesson->title:'') }}">
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="config" class="form-label">Loại bài học</label>
    <div class="form-group" style="display: flex; justify-content: space-around">
        <div class="form-check ">
            <input class="form-check-input @error('config') is-invalid @enderror" type="radio" 
            name="config" value="must"
            @if ($lesson->config == 'must')
                checked
            @endif >
            <label class="form-check-label">Tính tiến độ</label>
        </div>
        <div class="form-check">
            <input class="form-check-input @error('config') is-invalid @enderror" type="radio" 
            name="config" value="optional"
            @if ($lesson->config == 'optional')
                checked
            @endif >
            <label class="form-check-label">Không tính tiến độ</label>
        </div>
    </div>
    @error('config')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="published" class="form-label">Ngày xuất</label>
    <input type="date" name="published" class="form-control @error('published') is-invalid @enderror" id="published" value="{{ old('published', $lesson->published) }}">
    @error('published')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@php 
$path_link = ''
@endphp
@if($lesson->has('files'))
@php
    $files = $lesson->files()->get()
@endphp
@foreach($files as $file)
    @if($file->type == 'link')
    @php
        $path_link = $file->path
    @endphp
    @endif
@endforeach
@endif
<div class="form-group">
    <label class="form-label">Link video</label>
    <input type="text" name="path_link" id="path_link" class="form-control @error('content') is-invalid @enderror" 
    value="{{ old('path', $path_link) }}">
    @error('content')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label class="form-label">Tệp bài học (Định dạng .zip)</label>
    <input type="file" name="path_zip" id="path_zip" class="form-control">
</div>
<div class="form-group">
    <label for="content" class="form-label">Nội dung bài học (Trên 20 ký tự)</label>
    <textarea name="content" id="content" class="form-control ckeditor @error('content') is-invalid @enderror" 
    cols="5" rows="3" style="visibility: hidden; display: none;">{{ old('content', $lesson->content) }}</textarea>
    @error('content')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>