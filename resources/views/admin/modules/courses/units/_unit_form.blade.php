@csrf
<div class="mb-3">
    <label for="course_id" class="form-label">Tên khóa học</label>
    <select id="course_id" name="course_id" class="form-control @error('course_id') is-invalid @enderror">
        <option value="">-</option>
        @forelse($course as $id => $title)
        @if ($id == old('course_id', $unit->course_id))
        <option selected="selected" value="{{ $id }}">{{ $title }}</option>
        @else
        <option value="{{ $id }}">{{ $title }}</option>
        @endif
        @empty
        @endforelse
    </select>
    @error('course_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="unit_tile" class="form-label">Tên chương học</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="unit_title" value="{{ old('title', $unit->id?$unit->title:'') }}">
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>