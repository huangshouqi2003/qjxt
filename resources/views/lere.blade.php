<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<form action="/api/user/addlere" method="post">
    @csrf
    <p>stu_id：<input type="text" name="stu_id"/></p>
    <p>name：<input type="text" name="name"/></p>
    <p>reason： <input type="text" name="reason" value="1234"></p>
    <p>time_pr：<input type="text" name="le_time_pr"/></p>
    <p>state：<input type="text" name="le_state"/></p>
    <p>type：<input type="text" name="le_type"/></p>
{{--    <p>email：<input type="text" name="email"/></p>--}}
    <input type="submit" name="提交"/>

</form>
</body>
</html>
