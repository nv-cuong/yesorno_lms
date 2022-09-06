<html>
   <head> 
      <link rel="stylesheet" href="/admin/css/index_test.css">
      @include('admin.tests.bootstrap5')
   </head>
   <body>

<h1> Chọn bài Test yêu thích</h1>

<!-- <select class="form-select" aria-label="Default select example">
  <option selected>Open this select menu</option>
  <option value="1">Test 1</option>
  <option value="2">Test 2</option>
  <option value="3">Test 3</option>
</select> -->
<a href="{{route('test.index_make',[2,2])}}">Làm bài</a>
<a href="{{route('test.view_maked',[2,2])}}">Xem bài</a>
</body>
</html>