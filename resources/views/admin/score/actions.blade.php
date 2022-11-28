@if ($row->score == '' && $row->status == 1)
    <a href="{{ route('score.marking', [$row->id]) }}" class="btn btn-primary btn-sm" title="Chấm điểm">
        Chấm điểm
    </a>
@else
    <button class="btn btn-primary btn-sm" title="Không thể chọn" disabled>
        Chấm điểm
    </button>
@endif
