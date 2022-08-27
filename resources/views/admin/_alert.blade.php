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
