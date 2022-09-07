<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Mật khẩu Reset</h2>

<div>
Đặt lại mật khẩu của bạn bằng cách nhấp vào <a href="{{ route('resetPassword.form', [$user->getUserId(), $code]) }}">here</a> <br>
Liên kết này sẽ hết hạn sau 60 phút.
</div>
</body>
</html>