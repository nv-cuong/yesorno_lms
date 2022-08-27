@if(session('msg'))
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