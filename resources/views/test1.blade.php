<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<form action="/api/correcting" method="post">
    @csrf
    <p>id：<input type="text" name="id"/></p>
{{--    <p>name：<input type="text" name="name"/></p>--}}
{{--    <p>type： <input type="text" name="password" value="1234"></p>--}}
{{--    <p>why：<input type="text" name="Teacher"/></p>--}}
{{--    <p>Class：<input type="text" name="Class"/></p>--}}
{{--    <p>Phone：<input type="text" name="Phone"/></p>--}}
{{--    <p>email：<input type="text" name="email"/></p>--}}
    <p>le_state：<input type="text" name="le_state"/></p>
    <input type="submit" name="提交"/>

</form>
</body>
</html>
