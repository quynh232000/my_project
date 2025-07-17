<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Quên mật khẩu</h1>
    <label for="">Xin chào <strong>{{$data['email']}}</strong></label>
    <div>
        Mã xác nhận thay đổi mật khẩu
        <br>
        <button style="color:blue;font-size:32px">
           <strong>{{$data['code']}}</strong>
        </button>
    </div>
</body>
</html>