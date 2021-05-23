<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ログイン</title>
    </head>
    <body>
        @if (Session::has('error_message'))
            <p class="err">{!! Session::get('error_message') !!}</p>
        @endif
        <div>
            <a href="{{ url('redirect') }}">Slackでログイン</a>
        </div>
    </body>
</html>
