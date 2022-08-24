@if(session('msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('msg') }}
  <div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color : red"></button>
  </div>

</div>
@endif
