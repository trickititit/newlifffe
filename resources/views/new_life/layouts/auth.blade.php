<!DOCTYPE html>
<html>
<head lang="{{ config('app.locale') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="icon" href="{{ asset(config('settings.theme')) }}/img/favicon.ico"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link href="{{ asset(config('settings.theme')) }}/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="{{ asset(config('settings.theme')) }}/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="{{ asset(config('settings.theme')) }}/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="{{ asset(config('settings.theme')) }}/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="{{ asset(config('settings.theme')) }}/img/favicon.png" rel="icon" type="image/png">
    <link href="{{ asset(config('settings.theme')) }}/img/favicon.ico" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(config('settings.theme')) }}/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="{{ asset(config('settings.theme')) }}/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset(config('settings.theme')) }}/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset(config('settings.theme')) }}/css/main.css">
    <link rel="stylesheet" href="{{ asset(config('settings.theme')) }}/css/auth.login.css">

</head>
<body>
@yield('content')

<script src="{{ asset(config('settings.theme')) }}/js/lib/jquery/jquery.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/js/lib/tether/tether.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/js/plugins.js"></script>
<script type="text/javascript" src="{{ asset(config('settings.theme')) }}/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function(){
            setTimeout(function(){
                $('.page-center').matchHeight({ remove: true });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            },100);
        });
    });
</script>
<script src="{{ asset(config('settings.theme')) }}/js/app.js"></script>
</body>
</html>
