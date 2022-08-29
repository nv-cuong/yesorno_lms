@if (session('message'))
<!-- Conflic đừng xóa cái này nhé -->
    <div class="alert alert-{{ session('type_alert') }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif(session('msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('msg') }}
 
</div>
@endif
@if(Session::has('failed'))
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Warning: </strong> {!! Session::get('failed') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->all())
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Warning: </strong> Please check the form carefully for errors!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif