<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<form action="{{url('api/stu/login')}}" method="post">
    @csrf
    <label>请输入账号：</label><input type="text" name="stu_id" value=""><br>
    <label>请输入密码：</label><input type="text" name="password" value=""><br>
    <input type="submit" value="提交"><br>

</form>

</body>
</html>
