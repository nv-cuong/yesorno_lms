@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">

            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
     @include('admin/_alert')
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Thêm mới role</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('roles.store')}}" method="post">
                    <div class="card-body">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="name">Name <span style="color: red">*</span></label>
                            <input type="text" name="name" class="form-control input-sm " placeholder="@lang('global.name')" value="{{ old('name') }}">
                            {!! $errors->first('name', '<em for="name" class="help-block" style="color: red">:message</em>') !!}
                        </div>

                        <div class="tab-block mb25">
                            <ul class="nav tabs-left tabs-border">
                                <li role="presentation" class="active"><a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">Access Control List</a></li>
                            </ul>
                            <div class="tab-content">
                                <!-- For Auth Form -->
                                <div role="tabpanel" class="tab-pane active" id="auth">
                                    @include('admin.auth.role.acl-create')
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer">



                            <button type="submit" class="btn ladda-button btn-success btn-sm" data-style="zoom-in">
                                <span class="ladda-label"><i class="fa fa-save"></i> Tạo</span>
                                <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span></button>


                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop

@section('scripts')
<script>
    $(function () {
        var oTable = $('#acl-table').DataTable({
            aaSorting: [[0, 'asc']],
            stateSave: true,
            bPaginate: false,
            bInfo: false,
            responsive: true,
            processing: true,
            bFilter: false,
            fixedHeader: true,
            columns: [
                {orderable: true, searchable: true},
                {orderable: false, searchable: false},
                {orderable: false, searchable: false},
                {orderable: false, searchable: false},
                {orderable: false, searchable: false},
                {orderable: false, searchable: false},
            ]

        });
    });
</script>
<script language="javascript">
    $('.styled').click(function(e){
        $("#acl-all").prop( "checked", false );
    })

    $('#acl-all').click(function (e) {
        var all = $('#acl-all');
        if (all.is(":checked")) {
            $('.acl').prop('checked', true);
        } else {
            $('.acl').prop('checked', false);
        }
    });
</script>
@stop