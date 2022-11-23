<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> 注册</title>
</head>
<body>
<form action="{{url('')}}" method="post">
    @csrf
    <label>请假类型</label><input type="text" name="le_type" value=""><br>
    <label>请假时间：</label><input type="text" name="le_time_pt value=""><br>
    <label>请假理由：</label><input type="text" name="le_why" value=""><br>
    <input type="submit" value="提交"><br>

</form>

</body>
</html>
