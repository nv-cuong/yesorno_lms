<a href="{{ route('question.edit', [$row->id]) }} " class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i>
</a>
<a class="btn btn-sm btn-danger delete_question" data-toggle="modal" data-target="#deleteModalQuestion"
    value="{{ $row->id }}" onclick="javascript:question_delete('{{ $row->id }}')">
    <i class="fas fa-backspace"></i>
</a>
