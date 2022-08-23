@if (session('message'))
<div class="alert alert-{{session('type_alert')}} alert-dismissible fade show" role="alert">
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
