@extends('Admin.Layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
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
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create <small>question</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('question.store') }}" >
                @csrf

                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="content" class="form-control" id="exampleInputEmail1" placeholder="content">
                  </div>
                  
                  
                  <div class="form-group">
                  <label>Course</label>
                  <select class="form-control select2"  style="width: 100%;" name="course_id" >
                    <option selected="selected" value="1">Alabama</option>
                    
                    <option value="2">Washington</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Type</label>
                  <select class="form-control select2"  style="width: 100%;" name="category" id="category">
                    <option selected="selected" value="0">Câu hỏi tự luận</option>
                    <option value="1">Câu hỏi trắc nghiệm</option>
                    <option value="2">Câu hỏi Đúng sai</option>
                    
                  </select>
                </div>
                <div class="form-group" id="check_question" style="display: none">
                    <label for="exampleInputEmail1">Đáp án</label>
                    <input type="number" name="score" class="form-control" id="exampleInputEmail1" placeholder="store">
                  </div>
                  <div class="form-group clearfix" id="check_true" style="display: none">
                      <div class="icheck-danger d-inline">
                        <input type="radio" name="answer" checked id="radioDanger1">
                        <label for="radioDanger1">
                          Đúng 
                        </label>
                      </div>
                      <div class="icheck-danger d-inline">
                        <input type="radio" name="answer" id="radioDanger2">
                        <label for="radioDanger2">
                            Sai
                        </label>
                      </div>
                      
                    </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">store</label>
                    <input type="number" name="score" class="form-control" id="exampleInputEmail1" placeholder="store">
                  </div>
                </div>
                
                
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
 document.getElementById("category").onchange = function () {
         d = document.getElementById("category").value;
         //alert(d);
         if(d == 1)
         {
            document.getElementById("check_question").style.display = 'block';
            document.getElementById("check_true").style.display = 'none';
         }else{
            if(d == 2)
         {
            document.getElementById("check_true").style.display = 'block';
            document.getElementById("check_question").style.display = 'none';
         }
         else{
            document.getElementById("check_true").style.display = 'none';
            document.getElementById("check_question").style.display = 'none';
         }
         }
         
       
       
    };

    
        
  
</script>

@stop
