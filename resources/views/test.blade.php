<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>api</title>
    </head>
    <body>
        <button id="ad">/AdminApi/SignIn</button>
        <button id="out">/AdminApi/SignOut</button>
       <script src="/js/jQuery.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var user={
                username:'bee',
                nickname:'陈',
                password:'321321s',
                email:'236914977@qq.com',
                authority:0
            };

                var login ={
                    username:'bee',
                    password:'321321'

                }

            $("#ad").click(function () {
                $.post("/AdminApi/SignIn",login,function (data) {
                    console.log(data)
                },'json')
            })


            $("#out").click(function () {
                $.post("/AdminApi/SignOut",login,function (data) {
                    console.log(data)
                },'json')
            })
        </script>
    </body>
</html>
