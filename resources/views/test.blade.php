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
       <script src="/js/jQuery.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#ad").click(function () {
                $.post("/api/SignIn",{
                    username:"bee",
                    password:"123123123"
                },function (data) {
                    console.log(data)
                },'json')
            })
        </script>
    </body>
</html>
