<!DOCTYPE html>
<html>
    <head>
        <title> {{ $data['subject'] }}</title>
    </head>
    <body>
    <p>{!! nl2br($data['body']) !!}</p>
    </body>
</html>
