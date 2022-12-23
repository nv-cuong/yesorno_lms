<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Thông báo về khóa học</h2>

<div >
    <h2>Xin chào {{ $user['first_name'] }} chào mừng bạn đến với khóa học !!!</h2> 
    <br>
    <strong> Khóa học: </strong> {{ $data['course_name']}} <br>
    <strong> Mã khóa học: </strong> {{ $data['course_id']}} <br>
    <strong> Ngày bắt đầu: </strong> {{ $data['course_begin_date'] }} <br>
</div>
</body>
</html>