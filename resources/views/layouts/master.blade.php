<!doctype html>
<html lang='en'>
    <head>

        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Stream | Realtime Proactive Monitoring</title>
        <!--link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons"-->
        <link rel="stylesheet" href="{{ URL::asset('css/materialize.css') }}" media="screen,projection" >
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    </head>   
    <body>

        @yield('monitor')

        <script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.0.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/timediff.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/materialize.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>

    </body>
</html>