@if ($row->activations->isNotEmpty())
    @if ($row->activations[0]->completed == 1)
        <a href="#" data-message="{{ __('auth.deactivate_subheading', ['name' => $row->email]) }}"
            data-href="{{ route('users.status', $row->id) }}" id="tooltip" data-method="PUT"
            data-title="{{ __('auth.deactivate_this_user') }}" data-title-modal="{{ __('auth.deactivate_heading') }}"
            data-toggle="modal" data-target="#delete" title="{{ __('auth.deactivate_this_user') }}">
            <span class="label label-success label-sm">Hoạt động</span></a>
    @endif
@else
    <a href="#" data-message="{{ __('auth.activate_subheading', ['name' => $row->email]) }}"
        data-href="{{ route('users.status', $row->id) }}" id="tooltip" data-method="PUT"
        data-title="{{ __('auth.activate_this_user') }}" data-title-modal="{{ __('auth.deactivate_heading') }}"
        data-toggle="modal" data-target="#delete" title="{{ __('auth.activate_this_user') }}">
        <span class="label label-danger label-sm">Không hoạt động</span></a>
@endif
