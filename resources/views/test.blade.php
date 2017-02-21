<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>测试</title>
    </head>
    <body>
        <button id="ad">/AdminApi/SignIn</button>
       <script src="/js/jQuery.js"></script>
        <script>
            $("#ad").click(function () {
                $.post("/AdminApi/SignIn",{
                    username:"bee",
                    password:"123123123"
                },function (data) {
                    console.log(data)
                },'json')
            })
        </script>
    </body>
</html>
