@if (session('message'))
<!-- Conflic đừng xóa cái này nhé -->
    <div class="alert alert-{{ session('type_alert') }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<!-- Thêm icon tắt vào success alert -->
@elseif(session('msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('msg') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif
